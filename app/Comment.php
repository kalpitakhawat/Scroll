<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class Comment extends Model
{
  use SyncsWithFirebase;
  protected $table = 'comments';
  protected $fillable = ['id' , 'uid' , 'pid' , 'comment'];
}
