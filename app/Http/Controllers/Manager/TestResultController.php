<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\TestScript;
use App\Models\TestResult;
use App\Models\Filename;
use Illuminate\Http\Request;
use Auth;
use Storage;

class TestResultController extends Controller
{
    protected $filename, $testScript, $testResult;

    public function __construct(
        Filename $filename,
        TestScript $testScript,
        TestResult $testResult
    )
    {
        $this->filename = $filename;
        $this->testScript = $testScript;
        $this->testResult = $testResult;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($testScriptId, Request $request)
    {
        // Get Data
        $testScriptModel = $this->testScript->where('id', $testScriptId)
                                            ->with('filename')
                                            ->first();
        $testResultList = $this->testResult->where('test_script_id', $testScriptId)
                                           ->get();
        // Processing Data
        $data = ['testScriptData' => $testScriptModel,
                 'testResultList' => $testResultList];
        // View
        return view('Manager.TestResultOverview', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestResult  $testResult
     * @return \Illuminate\Http\Response
     */
    public function show($testResultId, TestResult $testResult)
    {
        // Get Data
        $testResultModel = $this->testResult->where('user_id', Auth::user()->id)
                                            ->where('id', $testResultId)
                                            ->first();
        $testScriptModel = $this->testScript->where('user_id', Auth::user()->id)
                                            ->where('id', $testResultModel['test_script_id'])
                                            ->first();
        $filename = $this->filename->where('id', $testScriptModel['file_id'])
                                   ->first();
        $testResultList = $this->testResult->where('test_script_id', $testScriptModel['id'])
                                           ->get();
        // Check Status
        // $resultFolder = '../storage/app/TestResult/'.$filename['hash'].'/';
        // $result = Storage::disk('TestResult')->has('file.jpg');
        // $result = Storage::disk('TestResult')->get($filename['hash'].'/statistics.json');
        $result = Storage::disk('TestResult')->get($filename['hash'].'/'.$testResultModel['file_name'].'.json');
        // $error = Storage::disk('TestResult')->get($filename['hash'].'-error.json');
        // $errorByType = Storage::disk('TestResult')->get($filename['hash'].'-errorByType.json');
        $resultArray = json_decode($result, true);
        $statistics = $resultArray['detail'];
        $errorStatistics = $resultArray['errorDetail'];
        $errorStatisticsByType = $resultArray['errorByType'];
        // ksort($statistics);

        // Processing Data
        // $testInfomation = [];
        // 腳本資訊
        // $testInfomation['name'] = $testScriptModel['name'];
        // $testInfomation['description'] = $testScriptModel['description'];
        // 結果資訊
        // $testInfomation['id'] = $testResultModel['id'];
        // $testInfomation['threads'] = $testResultModel['threads'];
        // $testInfomation['loops'] = $testResultModel['loops'];
        // $testInfomation['rampUpTime'] = $testResultModel['ramp_up_period'];
        // $testInfomation['start_at'] = $testResultModel['start_at'];
        // $testInfomation['end_at'] = $testResultModel['end_at'];
        // Formate Data
        $data = ['testScriptData' => $testScriptModel,
                 'testResultList' => $testResultList,
                 'testResultData' => $testResultModel,
                 'result' => $statistics,
                 'error' => $errorStatistics,
                 'errorByType' => $errorStatisticsByType];
        // View
        return view('User.TestResult', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestResult  $testResult
     * @return \Illuminate\Http\Response
     */
    public function edit(TestResult $testResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestResult  $testResult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestResult $testResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestResult  $testResult
     * @return \Illuminate\Http\Response
     */
    public function destroy($testResultId, TestResult $testResult)
    {
        // Get Data
        $testResultModel = $this->testResult->where('id', $testResultId)
                                            ->first();
        $testScriptModal = $this->testScript->where('id', $testResultModel['test_script_id'])
                                            ->with('filename')
                                            ->first();
        $scriptName = $testScriptModal['filename']['hash'];
        $resultName = $testResultModel['file_name'];
        // Delete File
        Storage::disk('TestResult')->delete($scriptName.'/'.$resultName.'.jtl');
        Storage::disk('TestResult')->delete($scriptName.'/'.$resultName.'.json');
        // Delete From DataTable
        $testResultModel->delete();
        return response(null, 204);
    }
}
