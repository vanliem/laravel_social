<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function getDashboard()
    {
        $posts = Post::Post()->get();
        
        return view('dashboard', compact('posts'));
    }

    public function signIn(Request $request)
    {
        $this->validate($request, [
            'email_signin' => 'required',
            'password_signin'  => 'required|min:4'
        ]);

        if (Auth::attempt(['email' => $request->email_signin, 'password' => $request->password_signin])) {
            return redirect()->route('dashboard');
        }

        return redirect()->back();

    }

    public function signUp(Request $request, User $user)
    {
        $this->validate($request, [
            'first_name' => 'required|min:4',
            'email' => 'required|unique:users',
            'password'  => 'required|min:4'
        ]);

        $user->first_name = $request->first_name;
        $user->email      = $request->email;
        $user->password   = bcrypt($request->password);

        if ($user->save()) {
            Auth::login($user);

            return redirect()->route('dashboard');
        } else {
            return redirect()->back();
        }


    }

    public function logOut()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function getAccount()
    {
        return view('account', ['user' => Auth::user()]);
    }

    public function editUser(Request $request)
    {
        if (!User::validateRequest($request->all())) {
            return redirect()->back()->withErrors(User::geterrors());
        }

        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->update();

        if ($request->file('image')) {
            $fileName = $request->first_name .'-' . $user->id . '.jpg';
            Storage::disk('local')->put($fileName, File::get($request->file('image')));
        }

        return redirect()->route('account');
    }

    public function getUserImage($fileName)
    {
        $file = Storage::disk('local')->get($fileName);
        return new Response($file, 200);
    }

}
