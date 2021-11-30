<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFolder;
use Illuminate\Http\Request;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
  public function showCreateForm()
  {
    return view("folders/create");
  }

  public function create(CreateFolder $request)
  {

    $folder = new Folder();
    // タイトルに入力値を代入する
    $folder->title = $request->title;
    $folder->user_id = Auth::user()->id;

    // インスタンスの状態をデータベースに書き込む
    $folder->save();

    return redirect()->route('tasks.index', [
      "id" => $folder->id,
    ]);
  }
}
