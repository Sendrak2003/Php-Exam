@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('New Task') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{route("task.store")}}">
                            @csrf
                            @if(Auth::user()->is_admin)
                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                                    <div class="col-md-6">
                                        <select id="email" name="email" class="form-select form-select-lg mb-3 form-control @error('email') is-invalid @enderror">
                                            @foreach($emails as $email)
                                                <option value="{{ $email->email }}">{{ $email->email }}</option>
                                            @endforeach
                                        </select>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="row mb-3">
                                <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                           name="title" autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="start_date" class="col-md-4 col-form-label text-md-end">{{ __('Start date') }}</label>

                                <div class="col-md-6">
                                    <input id="start_date" name="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror"
                                          autocomplete="start_date" autofocus>

                                    @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="end_date" class="col-md-4 col-form-label text-md-end">{{ __('End date') }}</label>

                                <div class="col-md-6">
                                    <input id="end_date" name="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror"
                                           autocomplete="end_date" autofocus>

                                    @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create task') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
