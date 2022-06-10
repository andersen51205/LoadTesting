<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\TestScript;
use App\Models\Project;
use App\Models\Filename;
use App\Jobs\TestJob;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        // Get Data
        $testScriptList = $this->testScript->orderBy('user_id')
                                           ->orderBy('project_id')
                                           ->with('user')
                                           ->with('project')
                                           ->get();
        // Formate Data
        $data = ['testScriptList' => $testScriptList];
        // View
        return view('Manager.TestScriptManagement', compact('data'));
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
        if($request['testScriptIncremental'] === "0") {
            $request['testScriptEndThreads'] = $request['testScriptStartThreads'];
            $request['testScriptIncrementAmount'] = 1;
        }
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
        $testScriptModel = [];
        $testScriptModel['user_id'] = Auth::user()->id;
        $testScriptModel['project_id'] = $request['projectId'];
        $testScriptModel['file_id'] = $fileId;
        $testScriptModel['name'] = $request['testScriptName'];
        $testScriptModel['description'] = $request['testScriptDescription'];
        $testScriptModel['is_incremental'] = $request['testScriptIncremental'];
        $testScriptModel['start_thread'] = $request['testScriptStartThreads'];
        $testScriptModel['end_thread'] = $request['testScriptEndThreads'];
        $testScriptModel['increment_amount'] = $request['testScriptIncrementAmount'];
        $testScriptModel['threads'] = $request['testScriptStartThreads'];
        $testScriptModel['ramp_up_period'] = $request['testScriptRampUpPeriod'];
        $testScriptModel['loops'] = $request['testScriptLoops'];
        $testScriptModel['status'] = 1;
        // Create Script
        $this->testScript->create($testScriptModel);
        // Return Response
        return response()->json([
            'redirectTarget' => route('User_Project_View', [$request['projectId']])
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
    public function update($testScriptId, Request $request, TestScript $testScript)
    {
        $updateData = [];
        // Validate
        if($request['testScriptIncremental'] === "0") {
            $request['testScriptEndThreads'] = $request['testScriptStartThreads'];
            $request['testScriptIncrementAmount'] = 1;
        }
        // Get Data
        $testScriptData = $this->testScript->where('user_id', Auth::user()->id)
                                           ->where('id', $testScriptId)
                                           ->first();
        // Check File
        if($request['file']) {
            $updateData['status'] = 1;
            // Get Data
            $fileData = $this->filename->where('id', $testScriptData['file_id'])
                                       ->first();
            $originalFileHash = $fileData['hash'];
            // Create File
            $file = $request['file'];
            $originalFileName = $file->getClientOriginalName();
            $uid = hash('sha256', Str::uuid().time());
            Storage::disk('TestScript')->put($uid, $file->get());
            // Update File
            $fileData->update([
                'hash' => $uid,
                'name' => $originalFileName,
            ]);
            // Delete File
            $deleteMessage = '';
            $resultPath = '../storage/app/TestResult/';
            $scriptPath = '../storage/app/TestScript/';

            if(file_exists($resultPath . $originalFileHash)) {
                $this->removeDirectory($resultPath . $originalFileHash);
            }
            $currentFile = $resultPath . $originalFileHash . '.json';
            if(file_exists($currentFile)) {
                // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
                $deleteMessage = unlink($currentFile);
            }
            $currentFile = $resultPath . $originalFileHash . '-error.json';
            if(file_exists($currentFile)) {
                // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
                $deleteMessage = unlink($currentFile);
            }
            $currentFile = $resultPath . $originalFileHash . '-errorByType.json';
            if(file_exists($currentFile)) {
                // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
                $deleteMessage = unlink($currentFile);
            }
            $currentFile = $resultPath . $originalFileHash . '.jtl';
            if(file_exists($currentFile)) {
                // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
                $deleteMessage = unlink($currentFile);
            }
            $currentFile = $scriptPath . $originalFileHash;
            if(file_exists($currentFile)) {
                // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
                $deleteMessage = unlink($currentFile);
            }
        }
        // Processing data
        $updateData['project_id'] = $request['projectId'];
        $updateData['name'] = $request['testScriptName'];
        $updateData['description'] = $request['testScriptDescription'];
        $updateData['is_incremental'] = $request['testScriptIncremental'];
        $updateData['start_thread'] = $request['testScriptStartThreads'];
        $updateData['end_thread'] = $request['testScriptEndThreads'];
        $updateData['increment_amount'] = $request['testScriptIncrementAmount'];
        $updateData['threads'] = $request['testScriptStartThreads'];
        $updateData['ramp_up_period'] = $request['testScriptRampUpPeriod'];
        $updateData['loops'] = $request['testScriptLoops'];
        // Update Test Script
        $testScriptData->update($updateData);
        // Redirect Route
        return response()->json([
            'redirectTarget' => route('User_Project_View', $updateData['project_id'])
        ], 200);
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
                                           ->with('filename')
                                           ->first();
        // Set Status : 1 -> ready, 2 -> wait, 3 -> doing, 4 -> finish
        $testScriptData->status = 2;
        $testScriptData->threads = $testScriptData['start_thread'];
        $testScriptData->save();
        // Add to job queue
        $this->dispatch(new TestJob($testScriptData));
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

    public function tutorial()
    {
        // Get Data
        $projectList = $this->project->where('user_id', Auth::user()->id)
                                     ->get();
        // Formate Data
        $data = ['projectList' => $projectList];
        // View
        return view('User.TestTutorial', compact('data'));
    }
}
