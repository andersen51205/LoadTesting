<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\TestScript;
use Illuminate\Http\Request;
use Auth;

class ProjectController extends Controller
{
    protected $project, $testScript;

    public function __construct(
        Project $project,
        TestScript $testScript
    )
    {
        $this->project = $project;
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
        $this->project->create($data);
        // Redirect Route
        return response()->json(['redirectTarget' => route('Project_View', [$data["name"]])], 200);
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
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
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
        $project = $this->project->where('id', $projectId)
                                 ->first();
        $project->delete();
        return response(null, 204);
    }
}
