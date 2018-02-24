<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\FirebaseLib;
const DEFAULT_URL = 'https://scroll-ca149.firebaseio.com';
const DEFAULT_TOKEN = 'YH1YtfIiUCyVVXIcQW14k93qitd2OyHWUFBIHFEf';
const DEFAULT_PATH = '/users';
class TestController extends Controller
{

  public function test(Request $r)
  {


      $firebase = new FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
      //dd($firebase);
      // --- storing an array ---
      $test = array(
          "foo" => "bar",
          "i_love" => "lamp",
          "id" => 42
      );
      // $dateTime = new DateTime();
      // $firebase->set(DEFAULT_PATH . '/' . $dateTime->format('c'), $test);

      // --- storing a string ---
      // $firebase->set(DEFAULT_PATH . '/name/contact001', "John Doe");

      // --- reading the stored string ---
      $name = $firebase->get(DEFAULT_PATH );
      dd($firebase->get(DEFAULT_PATH ));
  }
  // function firebaseRetrive($url , $api_secrets , $path)
  // {
  //   $ch = curl_init();
  //
  //   // set url
  //   curl_setopt($ch, CURLOPT_URL, $url.$path.'.json?auth='.$api_secrets);
  //
  //   //return the transfer as a string
  //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  //
  //   // $output contains the output string
  //   $output = curl_exec($ch);
  //
  //   // close curl resource to free up system resources
  //   curl_close($ch);
  //   return $output;
  // }
  // function firbaseDelete($value='')
  // {
  //   # code...
  // }
}
//curl 'https://scroll-ca149.firebaseio.com/comments.json?print=pretty'
