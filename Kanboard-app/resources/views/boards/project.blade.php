@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/project.css') }}">

<div class="wrapper">
  <h2>{{ $board->name }}</h2>
  <p>{{ $board->description }}</p>

  <div class="board-columns">
    @foreach($board->lists as $list)
      <div class="column">
        <h3>{{ $list->name }}</h3>
        <ul>
          @foreach($list->cards as $card)
            <li class="card">
              <strong>{{ $card->title }}</strong>
              <p>{{ $card->description }}</p>
            </li>
          @endforeach
        </ul>

        <!-- Form to add card -->
        <form action="{{ route('cards.store', $list) }}" method="POST">
          @csrf
          <input type="text" name="title" placeholder="Titre de la tâche" required>
          <textarea name="description" placeholder="Description"></textarea>
          <button type="submit">Ajouter</button>
        </form>
      </div>
    @endforeach

    <!-- Add new list -->
    <div class="column new-column">
      <form action="{{ route('lists.store', $board) }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nouvelle colonne" required>
        <button type="submit">Ajouter</button>
      </form>
    </div>
  </div>
</div>
@endsection
