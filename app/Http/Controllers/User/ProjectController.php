<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\TestScript;
use App\Models\Filename;
use Illuminate\Http\Request;
use Auth;

class ProjectController extends Controller
{
    protected $project, $testScript, $filename;

    public function __construct(
        Project $project,
        TestScript $testScript,
        Filename $filename
    )
    {
        $this->project = $project;
        $this->testScript = $testScript;
        $this->filename = $filename;
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
        // Formate Data
        $data = ['projectList' => $projectList];
        // View
        return view('User.ProjectManagement', compact('data'));
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
        return view('User.ProjectCreate', compact('data'));
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
        // $this->userInformationValidator->checkUserInformation($request);
        // Get Data
        $data = [];
        $data['name'] = $request['projectName'];
        $data['description'] = $request['projectDescription'];
        $data['user_id'] = Auth::user()->id;
        // Create Data
        $newProject = $this->project->create($data);
        // Redirect Route
        return response()->json([
            'redirectTarget' => route('Project_View', [$newProject['id']])
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($projectId, Project $project)
    {
        // Get Data
        $projectList = $this->project->where('user_id', Auth::user()->id)
                                     ->get();
        $projectData = $this->project->where('user_id', Auth::user()->id)
                                     ->where('id', $projectId)
                                     ->first();
        $testScriptList = $this->testScript->where('project_id', $projectId)
                                           ->get();
        // Processing Data
        foreach ($testScriptList as $testScript) {
            $updateData = explode(" ", $testScript['updated_at']);
            $testScript['updateDate'] = $updateData[0];
            $testScript['updateTime'] = $updateData[1];
        }
        // Formate Data
        $data = ['projectList' => $projectList,
                 'projectData' => $projectData,
                 'testScriptList' => $testScriptList];
        // View
        return view('User.ProjectView', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($projectId, Project $project)
    {
        // Get Data
        $projectList = $this->project->where('user_id', Auth::user()->id)
                                     ->get();
        $projectData = $this->project->where('user_id', Auth::user()->id)
                                     ->where('id', $projectId)
                                     ->first();
        // Formate Data
        $data = ['projectList' => $projectList,
                 'projectData' => $projectData];
        // View
        return view('User.ProjectEdit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update($projectId, Request $request, Project $project)
    {
        // Get Data
        $projectData = $this->project->where('user_id', Auth::user()->id)
                                     ->where('id', $projectId)
                                     ->first();
        // Processing Data
        $data['name'] = $request['projectName'];
        $data['description'] = $request['projectDescription'];
        // Update Test Script
        $projectData->update($data);
        // Redirect Route
        return response()->json([
            'redirectTarget' => route('ProjectManagement_View')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($projectId)
    {
        // Get Data
        $project = $this->project->where('user_id', Auth::user()->id)
                                 ->where('id', $projectId)
                                 ->first();
        $testScriptList = $this->testScript->where('project_id', $projectId)
                                           ->with('filename')
                                           ->get();
        foreach ($testScriptList as $testScript) {
            // Delete File
            $deleteMessage = '';
            $resultPath = '../storage/app/TestResult/';
            $scriptPath = '../storage/app/TestScript/';

            if(file_exists($resultPath . $testScript['filename']['hash'])) {
                $this->removeDirectory($resultPath . $testScript['filename']['hash']);
            }
            $currentFile = $resultPath . $testScript['filename']['hash'] . '.json';
            if(file_exists($currentFile)) {
                // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
                $deleteMessage = unlink($currentFile);
            }
            $currentFile = $resultPath . $testScript['filename']['hash'] . '-error.json';
            if(file_exists($currentFile)) {
                // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
                $deleteMessage = unlink($currentFile);
            }
            $currentFile = $resultPath . $testScript['filename']['hash'] . '-errorByType.json';
            if(file_exists($currentFile)) {
                // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
                $deleteMessage = unlink($currentFile);
            }
            $currentFile = $resultPath . $testScript['filename']['hash'] . '.jtl';
            if(file_exists($currentFile)) {
                // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
                $deleteMessage = unlink($currentFile);
            }
            $currentFile = $scriptPath . $testScript['filename']['hash'];
            if(file_exists($currentFile)) {
                // Storage::disk('TestResult')->delete($scriptName['hash'].'.jtl');
                $deleteMessage = unlink($currentFile);
            }
            $testScript['filename']->delete();
            $testScript->delete();
        }
        $project->delete();
        return response(null, 204);
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
