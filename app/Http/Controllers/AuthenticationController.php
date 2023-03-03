<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;
use Session;

/**
 * the class provides the functionalities needed
 * for user authentication, login and logout 
 * 
 * @author Marino Giudice
 */

class AuthenticationController extends Controller
{   
    // checks if the user is authenticated 
    public function index() {
        //if yes return the component index page
        if (Auth::check()) {
            return view('admin.index');
        }
        //return the login page otherwise
        return view('admin.login');
    }

    //the function it's used to make the login
    public function tryLogin(Request $request)
    {
        //validates the parameter of the login form
        $request->validate([
            'username' => 'required|min:5',
            'password' => 'required',
        ]);
        $user=$request->input('username');
        //check if the databelongs to a user
        Auth::check($user);
        $userData = $request->only('username', 'password');
        if (Auth::attempt($userData)) {
            //regenerate the user session
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }
        return redirect('admin/login')->with('fail','Login details are not valid');
    }

    //the function it's used for logout operations
    public function logOut() {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
