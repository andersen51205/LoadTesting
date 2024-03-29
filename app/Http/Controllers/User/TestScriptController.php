<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TestScript;
use App\Models\TestResult;
use App\Models\Project;
use App\Models\Filename;
use App\Jobs\TestJob;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Storage;

class TestScriptController extends Controller
{
    protected $project, $filename, $testScript, $testResult;

    public function __construct(
        Project $project,
        Filename $filename,
        TestScript $testScript,
        TestResult $testResult
    )
    {
        $this->project = $project;
        $this->filename = $filename;
        $this->testScript = $testScript;
        $this->testResult = $testResult;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Data
        $projectList = $this->project->where('user_id', Auth::user()->id)
                                     ->get();
        $testScriptList = $this->testScript->where('user_id', Auth::user()->id)
                                           ->orderBy('user_id')
                                           ->orderBy('project_id')
                                           ->with('project')
                                           ->get();
        // Formate Data
        $data = ['projectList' => $projectList,
                 'testScriptList' => $testScriptList];
        // View
        return view('User.TestScriptManagement', compact('data'));
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
    public function show(TestScript $testScript)
    {
        //
    }

    public function download($testScriptId)
    {
        // Get Data
        $testScriptModel = $this->testScript->where('user_id', Auth::user()->id)
                                            ->where('id', $testScriptId)
                                            ->with('filename')
                                            ->first();
        $fileHash = $testScriptModel['filename']['hash'];
        $fileName = $testScriptModel['filename']['name'];
        return Storage::disk('TestScript')->download($fileHash, $fileName);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestScript  $testScript
     * @return \Illuminate\Http\Response
     */
    public function edit($testScriptId, TestScript $testScript)
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
        $testScriptModel = $this->testScript->where('user_id', Auth::user()->id)
                                            ->where('id', $testScriptId)
                                            ->first();
        // Check File
        if($request['file']) {
            $updateData['status'] = 1;
            // Get Data
            $fileModel = $this->filename->where('id', $testScriptModel['file_id'])
                                        ->first();
            $originalFileHash = $fileModel['hash'];
            // Create File
            $file = $request['file'];
            $originalFileName = $file->getClientOriginalName();
            $uid = hash('sha256', Str::uuid().time());
            Storage::disk('TestScript')->put($uid, $file->get());
            // Update File
            $fileModel->update([
                'hash' => $uid,
                'name' => $originalFileName,
            ]);
            // Delete Result From DataTable
            $this->testResult->where('test_script_id', $testScriptModel['id'])
                             ->delete();
            // Delete Script File
            Storage::disk('TestScript')->delete($originalFileHash);
            Storage::disk('TestScript')->delete($originalFileHash.'.jmx');
            // Delete Result File
            $resultFiles = Storage::disk('TestResult')->allFiles($originalFileHash);
            Storage::disk('TestResult')->delete($resultFiles);
            Storage::disk('TestResult')->deleteDirectory($originalFileHash);
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
        $testScriptModel->update($updateData);
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
        $testScriptModel = $this->testScript->where('user_id', Auth::user()->id)
                                           ->where('id', $testScriptId)
                                           ->with('filename')
                                           ->first();
        $fileHash = $testScriptModel['filename']['hash'];
        // Delete Result From DataTable
        $this->testResult->where('test_script_id', $testScriptModel['id'])
                         ->delete();
        // Delete Script File
        Storage::disk('TestScript')->delete($fileHash);
        Storage::disk('TestScript')->delete($fileHash.'.jmx');
        // Delete Result File
        $resultFiles = Storage::disk('TestResult')->allFiles($fileHash);
        Storage::disk('TestResult')->delete($resultFiles);
        Storage::disk('TestResult')->deleteDirectory($fileHash);
        
        $testScriptModel->filename->delete();
        $testScriptModel->delete();
        return response(null, 204);
    }

    public function start($testScriptId)
    {
        // Get Data
        $testScriptModel = $this->testScript->where('id', $testScriptId)
                                            ->with('filename')
                                            ->first();
        // Set Status : 1->ready, 2->wait, 3->doing, 4->finish, 5->fail
        $testScriptModel->status = 2;
        $testScriptModel->threads = $testScriptModel['start_thread'];
        $testScriptModel->save();
        // Add to job queue
        $this->dispatch(new TestJob($testScriptModel));
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
