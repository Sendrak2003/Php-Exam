@extends('layouts.app')

@section('content')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <th>
                ID
            </th>
            <th>
                Employee id
            </th>
            <th>
                Title
            </th>
            <th>
                Start date
            </th>
            <th>
                End data
            </th>
            <th>
                Status
            </th>
            <th>
            </th>
            <th>
            </th>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->user_id }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->start_date }}</td>
                    <td>{{ $task->end_date }}</td>
                    <td>
                        <input id="status" name="status" type="checkbox" class="form-check-input" disabled
                               autocomplete="status" autofocus {{ $task->status ? 'checked' : '' }}>
                    </td>
                    <td>
                        <a class="btn btn-link"  href="{{ route('edit', $task->id) }}">{{ __('Edit') }}</a>
                    </td>
                    <td>
                        <form action="{{ route('task.delete', $task->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
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
