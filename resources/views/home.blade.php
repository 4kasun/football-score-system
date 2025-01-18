@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <h1>Update Scoreboard</h1>

                    @if(session('success'))
                    <div class="success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('scoreboard.update') }}">
                        @csrf
                        <label for="teams">Teams</label>
                        <input type="text" id="teams" name="teams" value="{{ old('teams') }}" placeholder="Team A vs Team B" required>

                        <label for="score">Score</label>
                        <input type="text" id="score" name="score" value="{{ old('score') }}" placeholder="e.g., 2 - 1" required>

                        <label for="status">Status</label>
                        <input type="text" id="status" name="status" value="{{ old('status') }}" placeholder="e.g., In Progress" required>

                        <button type="submit">Update Scoreboard</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection