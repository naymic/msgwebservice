@extends('layouts.app')

@section('content')
    <div align="center">
        <h1>Info</h1>
        <p>{{$message}}</p>
        <button onclick="window.location.href='{{URL::to('/')}}/{{$url}}';">{{$button_value}}</button>
    </div>
@endsection