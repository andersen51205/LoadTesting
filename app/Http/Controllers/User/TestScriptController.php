<?php

namespace App\Http\Controllers\User;

use App\Jobs\TestJob;
use App\Http\Controllers\Controller;
use App\Models\TestScript;
use App\Models\Project;
use App\Models\Filename;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Storage;

class TestScriptController extends Controller
{
    protected $project, $filename, $testScript;

    public function __construct(
        Project $project,
        Filename $filename,
        TestScript $testScript
    )
    {
        $this->project = $project;
        $this->filename = $filename;
        $this->testScript = $testScript;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "Sorry, this page is not completed.";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get Data
        $projectList = $this->project->where('user_id', Auth::user()->id)
                                     ->get();
        // Formate Data
        $data = ['projectList' => $projectList];
        // View
        return view('User.TestScriptCreate', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate
        $request['extension'] = $request->file->getClientOriginalExtension();
        $request->validate([
            'file' => 'required|file|mimes:xml',
            'extension' => 'in:jmx',
        ]);
        // Create File
        try {
            $file = $request->file;
            if($file) {
                $originalFileName = $file->getClientOriginalName();
                $uid = hash('sha256', Str::uuid().time());
                $fileId = $this->filename->create([
                            'hash' => $uid,
                            'name' => $originalFileName,
                        ])->id;
                Storage::disk('TestScript')->put($uid, $file->get());
            }
        }
        catch(\Exception $e) {
            return response('Server Error', 500);
        }
        // Get Data
        $projectData = $this->project->where('id', $request['projectId'])
                                     ->first();
        $data = [];
        $data['user_id'] = Auth::user()->id;
        $data['project_id'] = $projectData['id'];
        $data['file_id'] = $fileId;
        $data['name'] = $request['testScriptName'];
        $data['description'] = $request['testScriptDescription'];
        $data['status'] = 1;
        // Create Script
        $this->testScript->create($data);
        // Return Response
        return response()->json([
            'redirectTarget' => route('Project_View', [$projectData['id']])
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestScript  $testScript
     * @return \Illuminate\Http\Response
     */
    public function show($testScriptId, TestScript $testScript)
    {
        // Get Data
        $projectList = $this->project->where('user_id', Auth::user()->id)
                                     ->get();
        $testScriptData = $this->testScript->where('user_id', Auth::user()->id)
                                           ->where('id', $testScriptId)
                                           ->first();
        $projectData = $this->project->where('id', $testScriptData['project_id'])
                                     ->first();
        $fileName = $this->filename->where('id', $testScriptData['file_id'])
                                   ->first();
        // 
        $testScriptData['fileName'] = $fileName['name'];
        // Formate Data
        $data = ['projectList' => $projectList,
                 'projectData' => $projectData,
                 'testScriptData' => $testScriptData];
        // View
        return view('User.TestScriptView', compact('data'));
    }

    public function download($testScriptId)
    {
        // Get Data
        $testScriptData = $this->testScript->where('user_id', Auth::user()->id)
                                           ->where('id', $testScriptId)
                                           ->first();
        $fileName = $this->filename->where('id', $testScriptData['file_id'])
                                   ->first();
        $path = '../storage/app/TestScript/'.$fileName['hash'];
        // Script File
        return response()->download($path, $fileName['name']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestScript  $testScript
     * @return \Illuminate\Http\Response
     */
    public function edit(TestScript $testScript)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestScript  $testScript
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestScript $testScript)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestScript  $testScript
     * @return \Illuminate\Http\Response
     */
    public function destroy($testScriptId ,TestScript $testScript)
    {
        // Get Data
        $testScriptData = $this->testScript->where('user_id', Auth::user()->id)
                                           ->where('id', $testScriptId)
                                           ->first();
        $fileName = $this->filename->where('id', $testScriptData['file_id'])
                                   ->first();
        // Delete File
        $deleteMessage = '';
        $resultPath = '../storage/app/TestResult/';
        $scriptPath = '../storage/app/TestScript/';

        if(file_exists($resultPath . $fileName['hash'])) {
            $this->removeDirectory($resultPath . $fileName['hash']);
        }
        $currentFile = $resultPath . $fileName['hash'] . '.json';
        if(file_exists($currentFile)) {
            // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
            $deleteMessage = unlink($currentFile);
        }
        $currentFile = $resultPath . $fileName['hash'] . '-error.json';
        if(file_exists($currentFile)) {
            // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
            $deleteMessage = unlink($currentFile);
        }
        $currentFile = $resultPath . $fileName['hash'] . '-errorByType.json';
        if(file_exists($currentFile)) {
            // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
            $deleteMessage = unlink($currentFile);
        }
        $currentFile = $resultPath . $fileName['hash'] . '.jtl';
        if(file_exists($currentFile)) {
            // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
            $deleteMessage = unlink($currentFile);
        }
        $currentFile = $scriptPath . $fileName['hash'];
        if(file_exists($currentFile)) {
            // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
            $deleteMessage = unlink($currentFile);
        }
        $fileName->delete();
        $testScriptData->delete();
        return response(null, 204);
    }

    public function start($testScriptId)
    {
        // $result = shell_exec('dir');
        // $resultUtf8 = mb_convert_encoding($result, "UTF-8", "BIG-5"); 
        // return response()->json($result, 200);
        // $result = shell_exec('jmeter -n -t my_test.jmx -l log.jtl -H my.proxy.server -P 8000');
        // return 'done';

        // Get Data
        $testScriptData = $this->testScript->where('id', $testScriptId)
                                           ->first();
        $filename = $this->filename->where('id', $testScriptData['file_id'])
                                   ->first();
        // Set Status : 1 -> ready, 2 -> wait, 3 -> doing, 4 -> finish
        $testScriptData->status = 2;
        $testScriptData->save();
        // Add to job queue
        $this->dispatch(new TestJob($filename, $testScriptData));
    }

    public function result($testScriptId)
    {
        // Get Data
        $testScript = $this->testScript->where('id', $testScriptId)
                                       ->first();
        $filename = $this->filename->where('id', $testScript['file_id'])
                                   ->first();
        // Check Status
        $resultFolder = '../storage/app/TestResult/'.$filename['hash'];
        if(file_exists($resultFolder)) {
            // $result = Storage::disk('TestResult')->has('file.jpg');
            // $result = Storage::disk('TestResult')->get($filename['hash'].'/statistics.json');
            $result = Storage::disk('TestResult')->get($filename['hash'].'.json');
            $error = Storage::disk('TestResult')->get($filename['hash'].'-error.json');
            $errorByType = Storage::disk('TestResult')->get($filename['hash'].'-errorByType.json');
            $statistics = json_decode($result, true);
            $errorStatistics = json_decode($error, true);
            $errorStatisticsByType = json_decode($errorByType, true);
            // ksort($statistics);
            // Formate Data
            $data = ['testScript' => $testScript,
                     'result' => $statistics,
                     'error' => $errorStatistics,
                     'errorByType' => $errorStatisticsByType];
            // View
            return view('User.TestResult', compact('data'));
        }
        dd($resultFolder.' not exist.');
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
