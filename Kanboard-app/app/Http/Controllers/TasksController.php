<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;

class TasksController extends Controller
{
    public function move(Request $request)
    {
    $task = Tasks::findOrFail($request->task_id);
    $task->column_id = $request->new_column_id;
    $task->position = $request->new_position;
    $task->save();

    return response()->json(['success' => true]);
    }

}
