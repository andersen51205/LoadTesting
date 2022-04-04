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
use Storage;

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
        // Get Data
        $scriptName = $this->filename;
        // Set Status : 1 -> ready, 2 -> wait, 3 -> doing, 4 -> finish
        $this->testScript->status = 3;
        $this->testScript->save();
        // Set Command
        $jmeterPath = 'D:\ProgramFiles\apache-jmeter-5.4.2\bin\jmeter';
        $scriptFile = 'storage/app/TestScript/'.$scriptName['hash'];
        $resultLog = 'storage/app/TestResult/'.$scriptName['hash'].'.jtl';
        $resultFolder = 'storage/app/TestResult/'.$scriptName['hash'];
        $command = $jmeterPath.' -n -t '.$scriptFile.' -l '.$resultLog;
        // Check Result
        $deleteMessage = '';
        if(file_exists($resultLog)) {
            // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
            $deleteMessage = unlink($resultLog);
        }
        if(file_exists($resultFolder)) {
            $this->removeDirectory($resultFolder);
        }
        // Start Time
        $this->testScript->start_at = date("Y-m-d H:i:s");
        $this->testScript->save();
        // Start Test
        $result = shell_exec($command);
        echo($result."\n");
        // Generating reports
        $reportCommand = $jmeterPath.' -g '.$resultLog.' -o '.$resultFolder;
        $result = shell_exec($reportCommand);
        echo($result."\n");
        // End Time
        $this->testScript->end_at = date("Y-m-d H:i:s");
        $this->testScript->save();
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
}
