<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Columns;


class TrelloControllers extends Controller
{
    public function showBoard()
{
    $columns = Columns::with('tasks')->get();
    return view('trello', compact('columns'));
}

}
