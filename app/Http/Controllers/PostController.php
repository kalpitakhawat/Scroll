<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;
use Response;
use Uuid;
class PostController extends Controller
{
  public function create(Request $r)
  {
    try {
      $p = new Post();
      $p->uid = Auth::id();
      $p->type = $r->type;
      $p->content = $r->content;
      $p->isActive = 'true';
      $p->save();
      $code = 200;
      $msg = 'success';
    } catch (\Exception $e) {
      $code = 500;
      $msg = $e->getMessage();
    }

    return Response::json(['message' => $msg], $code);
  }
  public function upload(Request $r)
  {
    try {
      $pfile = $r->file('file');
      $fileName = Uuid::generate(1)->string . $pfile->getClientOriginalName();
    //  $pfile->move('post_content',$fileName);
      $filePath = '/post_content/' . $fileName;
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
