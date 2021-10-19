<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display all the users.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('UserAll', [
            'users' => User::latest()->get(),
        ]);
    }

    /**
     * Display add new user form.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('UserCreate');
    }

    /**
     * Store the new user data.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email:filter|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(),
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User added successfully.'
        ], 201);
    }

    /**
     * Display the edit form for the given user id.
     *
     * @param  int  $id
     * @return void|\Inertia\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if (! $user) {
            abort(404);
        }

        return Inertia::render('UserEdit', [
            'user' => $user
        ]);
    }

    /**
     * Update the user of the given user id.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email:filter|unique:users,email,'. $id,
        ]);

        $user = User::find($id);
        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found with the id: '. $id,
            ], 404);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.'
        ], 201);
    }
}
