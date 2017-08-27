@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="/trips" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="text" name="name" placeholder="Please add the name of your trip">
                            <input type="file" name="trip">
                            <input type="submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection