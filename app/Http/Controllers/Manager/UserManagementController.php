<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class UserManagementController extends Controller
{
    protected $user;

    public function __construct(
        User $user
    )
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Data
        $userList = $this->user->where('permission', 1)
        //                     ->where('id', '!=', Auth::user()->id)
                               ->with('project')
                               ->with('testScript')
                               ->get();
        // Formate Data
        $data = ['userList' => $userList];
        // View
        return view('Manager.UserManagement', compact('data'));
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update($userId, Request $request, User $user)
    {
        // Get Data
        $userData = $this->user->where('id', $userId)
                               ->first();
        // Processing Data
        $data['expired_at'] = null;
        // Update Data
        $userData->update($data);
        // Redirect Route
        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, User $user)
    {
        // Get Data
        $userData = $this->user->where('id', $userId)
                               ->first();
        // Processing Data
        $data['expired_at'] = date("Y-m-d");
        // Update Data
        $userData->update($data);
        // Redirect Route
        return response()->json(null, 200);
    }
}
