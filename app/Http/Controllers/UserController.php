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
