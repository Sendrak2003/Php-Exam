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
            Message
        </th>
        <th>
        </th>
    </thead>
    <tbody>
        @foreach($registration_requests as $registration_request)
            <tr>
                <td>{{ $registration_request->id }}</td>
                <td>{{ $registration_request->lastname }}</td>
                <td>{{ $registration_request->firstname }}</td>
                <td>{{ $registration_request->email }}</td>
                <td>{{ $registration_request->message }}</td>
                <td>
                      <a class="btn btn-link"  href="{{ route('register_form.get', $registration_request->id) }}">{{ __('Register') }}</a>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endsection
