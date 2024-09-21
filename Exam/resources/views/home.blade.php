@extends('layouts.app')

@section('content')
    <div class="taskList">
        @foreach($tasks as $task)
            <div class="listContainer">
                <a href="{{route('edit', $task->id)}}">
                        <div class="taskCard">
                            <h1>{{ $task->title }}</h1>
                        </div>
                        <h2>start date: {{ $task->start_date }}</h2>
                        <h2>end date: {{ $task->end_date }}</h2>
                </a>
            </div>
        @endforeach
    </div>

    <div class="button-container">
       <button class="overlay-button">
           <a href="{{route('add_task_form.show')}}">
               <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" color="" viewBox="0 0 512 512">
                   <title>plus</title>
                   <path d="M496 192h-176v-176c0-8.836-7.164-16-16-16h-96c-8.836 0-16 7.164-16 16v176h-176c-8.836 0-16 7.164-16 16v96c0 8.836 7.164 16 16 16h176v176c0 8.836 7.164 16 16 16h96c8.836 0 16-7.164 16-16v-176h176c8.836 0 16-7.164 16-16v-96c0-8.836-7.164-16-16-16z"></path>
               </svg>
           </a>
       </button>
    </div>
@endsection
