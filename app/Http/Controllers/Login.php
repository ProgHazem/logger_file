<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view("/index");
    }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->only('username', 'password');
        if ($credentials["username"] === "admin" && $credentials["password"] === "admin"){
            Session::put("auth", ["username" => $credentials["username"], "password" => $credentials["password"]]);
            return response()->redirectTo("/");
        }else{
            return response()->redirectTo("/register")->withErrors(["error" => "Incorrect "]);
        }
    }
}
