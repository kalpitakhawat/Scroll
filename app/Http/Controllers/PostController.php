<?php

namespace App\Http\Controllers;
ini_set('upload_max_filesize', '100M');
use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Like;
use App\Comment;
use Auth;
use Response;
use Uuid;
class PostController extends Controller
{
  public function create(Request $r)
  {
    try {
      $post = new Post();
      $post->uid = Auth::id();
      $post->type = $r->type;
      $post->content = $r->content;
      $post->isActive = 'true';
      $post->save();
      $like = Like::where('pid',$post->id)->where('uid',Auth::id())->first();
      if ($like) {
        $post->isLiked = true;
      } else {
        $post->isLiked = false;
      }
      $post->likes = Like::where('pid',$post->id)->count();
      $post->comments = Comment::where('pid',$post->id)->count();
      $user = User::find($post->uid);
      $post->avatar =$user->avatar;
      $post->user_name = $user->name;
      $code = 200;
      $msg = 'success';
      return Response::json(['message' => $msg , 'post'=>$post], $code);
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
      $pfile->move('post_content',$fileName);
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
  public function index(Request $r)
  {
    try {
      $posts= Post::where('isActive','true')->orderBy('created_at', 'desc')->offset($r->offset)->limit($r->limit)->get();
      foreach ($posts as  $post) {
        $like = Like::where('pid',$post->id)->where('uid',Auth::id())->first();
        if ($like) {
          $post->isLiked = true;
        } else {
          $post->isLiked = false;
        }
        $post->likes = Like::where('pid',$post->id)->count();
        $post->comments = Comment::where('pid',$post->id)->count();
        $user = User::find($post->uid);
        $post->avatar =$user->avatar;
        $post->user_name = $user->name;
      }
      $code = 200;
      $msg = 'success';
      return Response::json(['message' => $msg ,'post'=>$posts], $code);
    } catch (\Exception $e) {
      $code = 500;
      $msg = $e->getMessage();
      return Response::json(['message' => $msg], $code);
    }

  }
  public function like(Request $r)
  {
    try {
      $like = new Like();
      $like->pid = $r->pid;
      $like->uid = Auth::id();
      $like->save();
      $code = 200;
      $msg = 'success';
      return Response::json(['message' => $msg ], $code);
    } catch (\Exception $e) {
      $code = 500;
      $msg = $e->getMessage();
      return Response::json(['message' => $msg], $code);
    }
  }
  public function unlike(Request $r)
  {
    try {
      $like = Like::where('pid' , $r->pid)->where('uid',Auth::id());
      $like->delete();
      $code = 200;
      $msg = 'success';
      return Response::json(['message' => $msg ], $code);
    } catch (\Exception $e) {
      $code = 500;
      $msg = $e->getMessage();
      return Response::json(['message' => $msg], $code);
    }
  }
  public function details($id)
  {
      return view('postDetail');
  }
  public function getDetails(Request $r)
  {
    try {
      $post = Post::find($r->pid);
      $like = Like::where('pid',$post->id)->where('uid',Auth::id())->first();
      if ($like) {
        $post->isLiked = true;
      } else {
        $post->isLiked = false;
      }
      $post->likes = Like::where('pid',$post->id)->count();
      $post->comments = Comment::where('pid',$post->id)->count();
      $user = User::find($post->uid);
      $post->avatar =$user->avatar;
      $post->user_name = $user->name;
      $code = 200;
      $msg = 'success';
      return Response::json(['message' => $msg ,'post'=>$post , 'isLogin' => Auth::check()], $code);
    } catch (\Exception $e) {
      $code = 500;
      $msg = $e->getMessage();
      return Response::json(['message' => $msg], $code);
    }

  }
  public function getLikes(Request $r)
  {
    try {
      $likes = Like::where('pid',$r->pid)->get();
      foreach ($likes as $like) {
        $user = User::find($like->uid);
        $like->user_name = $user->name;
        $like->avatar = $user->avatar;
      }
      $code = 200;
      $msg = 'success';
      return Response::json(['message' => $msg ,'likes'=>$likes ], $code);
    } catch (\Exception $e) {
      $code = 500;
      $msg = $e->getMessage();
      return Response::json(['message' => $msg], $code);
    }

  }
}
