@extends('layouts.app')

@section('javascript')
    <script src="/js/crud-message.js"></script>
@endsection
@section('content')
    @include('messages.inner_form')
    <div class="col-md-1 col-sm-6">
        <div><label class="control-label">&nbsp;</label></div>
        <button onclick="window.location.href='/message'" class="form-control ">Voltar</button>
    </div>
@endsection