<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
  public function index(int $id)
  {
    // ユーザーに紐づくフォルダを取得する
    // $folders = $user_id->folders()->get();
    $folders = Folder::where('user_id', Auth::user()->id)->get();

    // 選ばれたフォルダを取得する
    $current_folder = Folder::find($id);

    if (is_null($current_folder)) {
      abort(404);
    }

    // 選ばれたフォルダに紐づくタスクを取得する
    $tasks = $current_folder->tasks()->get();
    // $tasks = Task::where('folder_id', $current_folder->id)->get();

    return view('tasks/index', [
      'folders' => $folders,
      'current_folder_id' => $id,
      'tasks' => $tasks,
    ]);
  }

  public function showCreateForm(int $id)
  {
    return view('tasks/create', [
      'folder_id' => $id
    ]);
  }

  public function create(int $id, CreateTask $request)
  {
    // 選ばれたフォルダを取得する
    $current_folder = Folder::find($id);

    $task = new Task();
    $task->title = $request->title;
    $task->due_date = $request->due_date;

    $current_folder->tasks()->save($task);

    return redirect()->route('tasks.index', [
      "id" => $current_folder,
    ]);
  }

  public function showEditForm(int $id, int $task_id,)
  {
    $task = Task::find($task_id);

    return view('tasks/edit', [
      'task' => $task,
    ]);
  }

  public function edit(int $id, int $task_id, EditTask $request)
  {
    // 1
    $task = Task::find($task_id);

    // 2
    $task->title = $request->title;
    $task->status = $request->status;
    $task->due_date = $request->due_date;
    $task->save();

    // 3
    return redirect()->route('tasks.index', [
      'id' => $task->folder_id,
    ]);
  }
}
