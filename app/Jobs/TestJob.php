<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Filesystem\Filesystem;
use App\Models\Filename;
use App\Models\TestScript;
use App\Models\TestResult;
use Storage;
use Throwable;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filename, $testScript;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 600;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        Filename $filename,
        TestScript $testScript
    )
    {
        $this->filename = $filename;
        $this->testScript = $testScript;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Filename $filename, TestScript $testScript)
    {
        printf("Start Job\n");
        // Get Data
        $scriptName = $this->filename['hash'];
        $threads = $this->testScript['threads'];
        $rampUpPeriod = $this->testScript['ramp_up_period'];
        $loops = $this->testScript['loops'];
        // Set Status : 1 -> ready, 2 -> wait, 3 -> doing, 4 -> finish
        $this->testScript->status = 3;
        $this->testScript->save();
        // Set Command
        $jmeterPath = 'D:\ProgramFiles\apache-jmeter-5.4.2\bin\jmeter';
        $testScriptPath = 'storage/app/TestScript/';
        $testResultPath = 'storage/app/TestResult/'.$scriptName.'/';

        $originalScriptFile = $testScriptPath . $scriptName;
        $currentScriptFile = $testScriptPath . $scriptName . '.jmx';

        $resultName = $threads . '-' . $rampUpPeriod . '-' . $loops;
        $resultJTL = $testResultPath . $resultName .'.jtl';
        $command = $jmeterPath.' -n -t '.$currentScriptFile.' -l '.$resultJTL;
        // Generating TestScript
        printf("Generating TestScript\n");
        $this->generationTestScript($this->testScript, $scriptName);

        // Check Result
        $deleteMessage = "";
        if(file_exists($resultJTL)) {
            // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
            $deleteMessage = unlink($resultJTL);
        }
        // if(file_exists($resultJson)) {
        //     $deleteMessage = unlink($resultJson);
        // }
        // if(file_exists($resultFolder)) {
        //     $this->removeDirectory($resultFolder);
        // }

        // Start Time
        $startTime = date("Y-m-d H:i:s");
        printf("Start Testing.\n");
        // Start Test
        $result = shell_exec($command);
        printf("%s\n", $result);
        // End Time
        $endTime = date("Y-m-d H:i:s");

        // Generating Reports
        printf("Start Generating reports.\n");
        // $reportCommand = $jmeterPath.' -g '.$resultLog.' -o '.$resultFolder;
        // $result = shell_exec($reportCommand);

        $this->GenerationReport($testResultPath, $resultName);
        // printf("%s\n", $result);
        $testResult = [];
        $testResult['user_id'] = $this->testScript['user_id'];
        $testResult['test_script_id'] = $this->testScript['id'];
        $testResult['threads'] = $threads;
        $testResult['ramp_up_period'] = $rampUpPeriod;
        $testResult['loops'] = $loops;
        $testResult['start_at'] = $startTime;
        $testResult['end_at'] = $endTime;
        $testResult['file_name'] = $resultName;
        TestResult::create($testResult);

        // Set Status : 1 -> ready, 2 -> wait, 3 -> doing, 4 -> finish
        $this->testScript->status = 4;
        $this->testScript->save();
    }

    public function removeDirectory($path)
    {
        // $files = glob($path . '/*');
        $files = glob($path . '/{,.}[!.,!..]*', GLOB_BRACE);
        foreach ($files as $file) {
            if(is_dir($file)) {
                $this->removeDirectory($file);
            }
            else {
                unlink($file);
            }
        }
        rmdir($path);
    }

    public function generationTestScript(TestScript $testScript, $scriptName)
    {
        $testScriptPath = 'storage/app/TestScript/';
        $originalScriptFile = $testScriptPath . $scriptName;
        $currentScriptFile = $testScriptPath . $scriptName . '.jmx';
        $message = "";
        // Get Parameter
        $threads = $testScript['threads'];
        $rampUpPeriod = $testScript['ramp_up_period'];
        $loops = $testScript['loops'];
        // Load XML file
        $xml = simplexml_load_file($originalScriptFile, "SimpleXMLElement", LIBXML_NOEMPTYTAG);
        
        $threadGroupNode = $xml->hashTree->hashTree->ThreadGroup; // 主執行緒Node
        foreach($threadGroupNode->children() as $child) {
            if($child->attributes()->name == "ThreadGroup.num_threads") {
                // Set Parameter
                $child[0] = $threads;
                $message = $message . "Thread Done.\n";
            }
            else if($child->attributes()->name == "ThreadGroup.ramp_time") {
                // Set Parameter
                $child[0] = $rampUpPeriod;
                $message = $message . "RampUpTime Done.\n";
            }
            else if($child->attributes()->name == "ThreadGroup.main_controller") {
                // Set Parameter
                $child->stringProp[0] = $loops;
                $message = $message . "Loop Done.\n";
            }
        }
        if($message === "") {
            $message = "TestScript generate Fail !\n";
        }
        printf("%s", $message);
        $xml->asXml($currentScriptFile);
    }

    public function generationReport($resultPath, $resultName)
    {
        // $resultLog = 'storage/app/TestResult/'.$scriptName['hash'].'.jtl';
        // $resultJTL = 'storage/app/TestResult/'.$scriptName.'.jtl';
        // $resultJSON = 'storage/app/TestResult/'.$scriptName.'.json';
        // $errorJSON = 'storage/app/TestResult/'.$scriptName.'-error.json';
        // $errorByTypeJSON = 'storage/app/TestResult/'.$scriptName.'-errorByType.json';
        $resultJTL = $resultPath . $resultName . '.jtl';
        $resultJSON = $resultPath . $resultName . '.json';
        $errorJSON = $resultPath . $resultName . '-error.json';
        $errorByTypeJSON = $resultPath . $resultName . '-errorByType.json';
        
        printf("Start Read CSV\n");
        // 讀取CSV
        $file = fopen($resultJTL, 'r');
        $statistics = [];
        // 讀取標題
        $row = fgetcsv($file);
        if($row !== FALSE) {
            $rawTitle = $row;
        }
        // 讀取內容：$statistics[步驟][欄位][使用者]
        while (($row = fgetcsv($file)) !== FALSE) {
            // 取得步驟名稱
            $labelName = $row[2];
            // 判斷statistics中是否存在該步驟
            $index = -1;
            for($i=0; $i<count($statistics); $i++) {
                if($statistics[$i][2] === $row[2]) {
                    $index = $i;
                    break;
                }
            }
            if($index === -1) {
                $index = count($statistics);
                // statistics中不存在該步驟 則建立需要的項目
                $statistics[$index] = [];
                // 建立欄位數量的array
                for($i=0; $i<count($row); $i++) {
                    if($i === 2 || $i === 13) {
                        $statistics[$index][$i] = $row[$i];
                    }
                    else {
                        $statistics[$index][$i] = [];
                    }
                }
            }
            // 新增每個欄位的資料
            for($i=0; $i<count($row); $i++) {
                if($i === 2 || $i === 13) {
                    continue;
                }
                array_push($statistics[$index][$i], $row[$i]);
            }
        }
        fclose($file);
        // 計算結果：$statistics[步驟][欄位][使用者])
        $statisticsResult = [];
        $totalResult = [
            "sampleCount" => 0,
            "errorCount" => 0,
            "resTime" => [],
            "maxResTime" => 0,
            "minResTime" => 999999,
            "totalRecv" => 0,
            "totalSent" => 0,
            "startTime" => $statistics[0][0][0],
            "endTime" => 0
        ];
        $errorStatistics = [];
        for($i=0; $i<count($statistics); $i++) {
            $result = [];
            $isAddToTotal = "true";
            if(strtolower($statistics[$i][13]) === "null") {
                $isAddToTotal = "false";
            }
            // 項目名稱
            $result["transaction"] = $statistics[$i][2];
            // 取樣數量
            $sampleCount = count($statistics[$i][5]);
            $result["sampleCount"] = $sampleCount;
            if($isAddToTotal === "true") {
                $totalResult["sampleCount"] += $sampleCount;
            }
            // 失敗次數
            $errorCount = 0;
            for($j=0; $j<count($statistics[$i][7]); $j++) {
                if(strtolower($statistics[$i][7][$j]) === "false") {
                    $errorCount++;
                    if($isAddToTotal === "true") {
                        // 取得失敗類型
                        $errorTypeName = $statistics[$i][3][$j]."/".$statistics[$i][4][$j];
                        // 判斷errorStatistics中是否存在該步驟的失敗類型
                        $index = -1;
                        for($k=0; $k<count($errorStatistics); $k++) {
                            if($errorStatistics[$k]["errorLabel"] === $statistics[$i][2]
                                    && $errorStatistics[$k]["errorType"] === $errorTypeName) {
                                $index = $k;
                                break;
                            }
                        }
                        if($index === -1) {
                            $index = count($errorStatistics);
                            // errorStatistics中不存在該失敗類型 則建立需要的項目
                            $errorStatistics[$index] = [
                                "errorLabel" => $statistics[$i][2],
                                "sampleCount" => $sampleCount,
                                "errorCount" => 0,
                                "errorType" => $errorTypeName
                            ];
                        }
                        $errorStatistics[$index]["errorCount"] += 1;
                    }
                }
            }
            $result["errorCount"] = $errorCount;
            if($isAddToTotal === "true") {
                $totalResult["errorCount"] += $errorCount;
            }
            // 失敗比例
            $result["errorPct"] = $errorCount/$sampleCount*100;
            // 回應時間
            $totalTime = 0;
            $min = $statistics[$i][1][0];
            $max = $statistics[$i][1][0];
            for($j=0; $j<count($statistics[$i][1]); $j++) {
                $totalTime += $statistics[$i][1][$j];
                if($isAddToTotal === "true") {
                    array_push($totalResult["resTime"], $statistics[$i][1][$j]);
                }
                if($statistics[$i][1][$j] > $max) {
                    $max = $statistics[$i][1][$j];
                }
                if($statistics[$i][1][$j] < $min) {
                    $min = $statistics[$i][1][$j];
                }
            }
            $mean = $totalTime/count($statistics[$i][1]);
            $result["meanResTime"] = $mean;
            $result["minResTime"] = $min;
            $result["maxResTime"] = $max;
            if($isAddToTotal === "true") {
                if($totalResult["minResTime"] > $min) {
                    $totalResult["minResTime"] = $min;
                }
                if($totalResult["maxResTime"] < $max) {
                    $totalResult["maxResTime"] = $max;
                }
            }

            $sort = $statistics[$i][1];
            sort($sort);
            $halfLength = intdiv($sampleCount, 2);
            if($sampleCount % 2 === 1) {
                $result["medianResTime"] = $sort[$halfLength];
            }
            else {
                $result["medianResTime"] = ($sort[$halfLength]+$sort[$halfLength-1])/2;
            }
            $result["pct90ResTime"] = $sort[intdiv($sampleCount*9, 10)];
            // 網路流量與平均請求量
            $startTime = $statistics[$i][0][0];
            $endTime = $statistics[$i][0][0]+$statistics[$i][1][0];
            $spendTime = 0;
            $totalRecv = 0;
            $totalSent = 0;
            for($j=0; $j<count($statistics[$i][9]); $j++) {
                // 計算總接收與送出
                $totalRecv += $statistics[$i][9][$j];
                $totalSent += $statistics[$i][10][$j];
                // 計算開始與結束時間
                if($startTime > $statistics[$i][0][$j]) {
                    $startTime = $statistics[$i][0][$j];
                }
                if($endTime < $statistics[$i][0][$j]+$statistics[$i][1][$j]) {
                    $endTime = $statistics[$i][0][$j]+$statistics[$i][1][$j];
                }
            }
            if($isAddToTotal === "true") {
                if($totalResult["startTime"] > $startTime) {
                    $totalResult["startTime"] = $startTime;
                }
                if($totalResult["endTime"] < $endTime) {
                    $totalResult["endTime"] = $endTime;
                }
                $totalResult["totalRecv"] += $totalRecv;
                $totalResult["totalSent"] += $totalSent;
            }

            $spendTime = ($endTime - $startTime)/1000;
            $result["throughput"] = $result["sampleCount"]/$spendTime;
            $result["receivedKBytesPerSec"] = $totalRecv/1024/$spendTime;
            $result["sentKBytesPerSec"] = $totalSent/1024/$spendTime;

            $statisticsResult[$result["transaction"]] = $result;
        }
        // 總和結果
        $statisticsTotal = [];
        $statisticsTotal["transaction"] = "Total";
        $statisticsTotal["sampleCount"] = $totalResult["sampleCount"];
        $statisticsTotal["errorCount"] = $totalResult["errorCount"];
        $statisticsTotal["errorPct"] = $totalResult["errorCount"]/$totalResult["sampleCount"]*100;
        $totalTime = 0;
        for($j=0; $j<count($totalResult["resTime"]); $j++) {
            $totalTime += $totalResult["resTime"][$j];
        }
        $statisticsTotal["meanResTime"] = $totalTime/$totalResult["sampleCount"];
        $statisticsTotal["minResTime"] = $totalResult["minResTime"];
        $statisticsTotal["maxResTime"] = $totalResult["maxResTime"];
        $sort = $totalResult["resTime"];
        sort($sort);
        $halfLength = intdiv($totalResult["sampleCount"], 2);
        if($totalResult["sampleCount"] % 2 === 1) {
            $statisticsTotal["medianResTime"] = $sort[$halfLength];
        }
        else {
            $statisticsTotal["medianResTime"] = ($sort[$halfLength]+$sort[$halfLength-1])/2;
        }
        $statisticsTotal["pct90ResTime"] = $sort[intdiv($totalResult["sampleCount"]*9, 10)];
        $spendTime = ($totalResult["endTime"] - $totalResult["startTime"])/1000;
        $statisticsTotal["throughput"] = $totalResult["sampleCount"]/$spendTime;
        $statisticsTotal["receivedKBytesPerSec"] = $totalResult["totalRecv"]/1024/$spendTime;
        $statisticsTotal["sentKBytesPerSec"] = $totalResult["totalSent"]/1024/$spendTime;
        $statisticsResult["Total"] = $statisticsTotal;
        // 失敗結果 $errorStatistics[$index]["errorLabel", "sampleCount", "errorCount", "errorType"];
        $errorsByType = [];
        $totalErrorCount = 0;
        $totalCount = $statisticsResult["Total"]["sampleCount"];
        for($i=0; $i<count($errorStatistics); $i++) {
            // 判斷errorsByType中是否存在該失敗類型
            $index = -1;
            for($j=0; $j<count($errorsByType); $j++) {
                if($errorsByType[$j]["errorType"] === $errorStatistics[$i]["errorType"]) {
                    $index = $j;
                    break;
                }
            }
            // errorsByType中不存在該失敗類型 則建立需要的項目
            if($index === -1) {
                $index = count($errorsByType);
                $errorsByType[$index] = [
                    "errorType" => $errorStatistics[$i]["errorType"],
                    "errorCount" => 0
                ];
            }
            // 統計失敗類型數量
            $errorsByType[$index]["errorCount"] += $errorStatistics[$i]["errorCount"];
            $totalErrorCount += $errorStatistics[$i]["errorCount"];
        }
        $errorStatisticsByType = [];
        for($i=0; $i<count($errorsByType); $i++) {
            $errorType = $errorsByType[$i]["errorType"];
            $errorCount = $errorsByType[$i]["errorCount"];
            $errorPctInError = $errorCount/$totalErrorCount*100;
            $errorPctInAll = $errorCount/$totalCount*100;
            $errorStatisticsByType[$errorType] = [
                "errorType" => $errorType,
                "errorCount" => $errorCount,
                "errorPctInError" => $errorPctInError,
                "errorPctInAll" => $errorPctInAll
            ];
        }
        // 匯出結果
        printf("Start Export Json\n");
        // printf("%s\n", $resultJSON);
        // $json = json_encode($statisticsResult);
        $exportData = [
            'detail' => $statisticsResult,
            'errorDetail' => $errorStatistics,
            'errorByType' => $errorStatisticsByType,
        ];
        $fp = fopen($resultJSON, 'w');
        fwrite($fp, json_encode($exportData, JSON_UNESCAPED_SLASHES));
        fclose($fp);
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
        $this->testScript->where('status', '3')
                         ->first()
                         ->update(['status' => '5']);
        echo $exception;
    }
}
