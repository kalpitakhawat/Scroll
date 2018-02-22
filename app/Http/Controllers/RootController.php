<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Uuid;
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
        $pfile->move('temp',$fileName);
        $filePath = '/temp/' . $fileName;
        $code = 200;
        $msg = 'success';
        return Response::json(['message' => $msg , 'file_path' => $filePath], $code);
      } catch (\Exception $e) {
        $code = 500;
        $msg = $e->getMessage();
      }
      return Response::json(['message' => $msg], $code);
    }
}
