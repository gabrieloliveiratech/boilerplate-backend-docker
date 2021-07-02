<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;


/**
 * @group  Users
 *
 * APIs for managing users
 */
class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     * 
     * @transformerCollection \App\Transformers\UserTransformer
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(UserIndexRequest $request)
    {
        $users = User::filter($request->all())->get();
        return $this->showData($users, 200);
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
     * @transformer App\Transformers\UserTransformer
     * 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserSaveRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->save();
        return $this->showOne($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
