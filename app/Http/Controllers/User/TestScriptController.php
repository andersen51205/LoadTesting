<?php

namespace App\Http\Controllers\User;

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
        $projectId = $this->project->where('name', $request['projectName'])->first()->id;
        $data = [];
        $data['user_id'] = Auth::user()->id;
        $data['project_id'] = $projectId;
        $data['file_id'] = $fileId;
        $data['name'] = $request['testScriptName'];
        $data['description'] = $request['testScriptDescription'];
        // Create Script
        $this->testScript->create($data);
        // Return Response
        return response()->json([
            'redirectTarget' => route('Project_View', [$request['projectName']])
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
    public function destroy(TestScript $testScript)
    {
        //
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
        // Set Command
        $jmeterPath = 'D:\ProgramFiles\apache-jmeter-5.4.2\bin\jmeter';
        $scriptFile = '../storage/app/TestScript/'.$filename['hash'];
        $resultLog = '../storage/app/TestResult/'.$filename['hash'].'.jtl';
        $command = $jmeterPath.' -n -t '.$scriptFile.' -l '.$resultLog;
        // Check Result
        $deleteMessage = '';
        if(file_exists($resultLog)) {
            $deleteMessage = unlink($resultLog);
        }
        // Start Test
        $result = shell_exec($command);
        dd($result);
    }
}
