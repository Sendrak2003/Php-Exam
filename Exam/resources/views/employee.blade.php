@extends('layouts.app')

@section('content')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <th>
                ID
            </th>
            <th>
                Last Name
            </th>
            <th>
                First Name
            </th>
            <th>
                Email
            </th>
            <th>
            </th>
            </thead>
            <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->lastname }}</td>
                    <td>{{ $employee->firstname }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>
                        <form action="{{ route('employee.delete', $employee->id) }}" method="POST">
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
@endsection
