<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Filename;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filename;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        Filename $filename
    )
    {
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Filename $filename)
    {
        // Get Data
        $scriptName = $this->filename;
        // Set Command
        $jmeterPath = 'D:\ProgramFiles\apache-jmeter-5.4.2\bin\jmeter';
        $scriptFile = 'storage/app/TestScript/'.$scriptName['hash'];
        $resultLog = 'storage/app/TestResult/'.$scriptName['hash'].'.jtl';
        $command = $jmeterPath.' -n -t '.$scriptFile.' -l '.$resultLog;
        // Check Result
        $deleteMessage = '';
        if(file_exists($resultLog)) {
            $deleteMessage = unlink($resultLog);
        }
        // Start Test
        $result = shell_exec($command);
    }
}
