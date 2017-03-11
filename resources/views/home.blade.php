@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div><a href="/message">List all Messages</a></div>
                    <div><a href="/message/create/">Create a new Message</a></div>
                    <div>{{$token}}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
