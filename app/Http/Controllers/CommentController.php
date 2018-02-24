<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Auth;
use Response;
class CommentController extends Controller
{
    public function create(Request $r)
    {
      try {
        $c = new Comment();
        $c->uid = Auth::id();
        $c->pid = $r->pid;
        $c->comment = $r->comment;
        $c->save();
        $code = 200;
        $msg = 'success';
        return Response::json(['message' => $msg], $code);
      } catch (\Exception $e) {
        $code = 500;
        $msg = $e->getMessage();
        return Response::json(['message' => $msg], $code);
      }

    }
}
