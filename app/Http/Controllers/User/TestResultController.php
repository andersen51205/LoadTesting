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
        $testScriptModel = $this->testScript->where('user_id', Auth::user()->id)
                                            ->where('id', $testScriptId)
                                            ->with('filename')
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
    public function show($testResultId, TestResult $testResult)
    {
        // Get Data
        $testResultModel = $this->testResult->where('user_id', Auth::user()->id)
                                            ->where('id', $testResultId)
                                            ->first();
        $testScriptModel = $this->testScript->where('user_id', Auth::user()->id)
                                            ->where('id', $testResultModel['test_script_id'])
                                            ->with('filename')
                                            ->first();
        $fileHash = $testScriptModel['filename']['hash'];
        $resultName = $testResultModel['file_name'];
        $testResultList = $this->testResult->where('test_script_id', $testScriptModel['id'])
                                           ->get();
        // Get Result
        $result = Storage::disk('TestResult')->get($fileHash.'/'.$resultName.'.json');
        $resultArray = json_decode($result, true);
        $statistics = $resultArray['detail'];
        $errorStatistics = $resultArray['errorDetail'];
        $errorStatisticsByType = $resultArray['errorByType'];
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
        $testResultModel = $this->testResult->where('user_id', Auth::user()->id)
                                            ->where('id', $testResultId)
                                            ->first();
        $testScriptData = $this->testScript->where('user_id', Auth::user()->id)
                                           ->where('id', $testResultModel['test_script_id'])
                                           ->with('filename')
                                           ->first();
        $fileHash = $testScriptData['filename']['hash'];
        $resultName = $testResultModel['file_name'];
        // Delete File
        Storage::disk('TestResult')->delete($fileHash.'/'.$resultName.'.jtl');
        Storage::disk('TestResult')->delete($fileHash.'/'.$resultName.'.json');
        // Delete Result From DataTable
        $testResultModel->delete();
        return response(null, 204);
    }
}
