@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2>Welcome to GPX Trips Visualizer</h2>
                    <p>You can now view all your trips <a href="/trips">here</a>, or create a new one <a href="/trips/create">here</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection