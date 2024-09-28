@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <ul>
                                <li>Star : Count : %</li>
                                @foreach($rates as $key => $rate)
                                    <li>{{ $key }} : count => {{ $rate['count'] }} : {{ $rate['percentage'] . '%' }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-9">
                            @if(session()->has('message'))
                                <div class="alert alert-danger">{{ session('message') }}</div>
                            @endif
                            @if(session()->has('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <form action="{{ route('set-user-rate') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="user_id" class="col-md-4 col-form-label text-md-end">User</label>

                                    <div class="col-md-6">
                                        <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" id="user_id">
                                            <option value="" selected disabled>Select</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('user_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="rate" class="col-md-4 col-form-label text-md-end">Rate</label>

                                    <div class="col-md-6">
                                        <input id="rate" type="text" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate') }}" autocomplete="name" autofocus>

                                        @error('rate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Rate
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

