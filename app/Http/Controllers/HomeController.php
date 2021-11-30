<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;
use App\Models\Task;


class HomeController extends Controller
{
  public function index()
  {
    $folder = Folder::where('user_id', Auth::user()->id)->limit(1)->get();
    $folderArr = $folder->toArray();

    if($folder->isEmpty()){
      return view('home');
    } else {
      // return redirect('folders/' . $folderArr[0]['id'] . '/tasks');
      return redirect()->route('tasks.index',[
        "id" => $folderArr[0]['id'],
     ]);
    }
  }
}
