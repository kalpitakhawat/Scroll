<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Uuid;
use Auth;
use App\User;
class RootController extends Controller
{
    public function showRegistrationForm()
    {
      return view('auth/register');
    }
    public function showLoginForm()
    {
      return view('auth/login');
    }
    public function profilepic(Request $r)
    {
      return view('profilepicform');
    }
    public function avatarupload(Request $r)
    {
      try {
        $pfile = $r->file('file');
        $fileName = Uuid::generate(1)->string . '.png';
        $pfile->move('avatar',$fileName);
        $filePath = '/avatar/' . $fileName;
        $user = User::find(Auth::id());
        $user->avatar = $filePath;
        $user->update();
        $code = 200;
        $msg = 'success';
        return Response::json(['message' => $msg ], $code);
      } catch (\Exception $e) {
        $code = 500;
        $msg = $e->getMessage();
      }
      return Response::json(['message' => $msg], $code);
    }
}
