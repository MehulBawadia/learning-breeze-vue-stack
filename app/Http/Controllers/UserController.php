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
}
