<?php

namespace App\Http\Controllers\User;

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
                                            ->first();
        $testResultList = $this->testResult->where('test_script_id', $testScriptId)
                                           ->get();
        // Processing Data
        $data = ['testScriptData' => $testScriptModel,
                 'testResultList' => $testResultList];
        // View
        return view('User.TestResultOverview', compact('data'));
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
    public function show(TestResult $testResult)
    {
        //
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
    public function destroy(TestResult $testResult)
    {
        //
    }
}
