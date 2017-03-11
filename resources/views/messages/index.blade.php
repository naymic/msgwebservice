@extends('layouts.app')

@section('javascript')
    <script src="/js/crud-message.js"></script>
@endsection

@section('content')
    @include('messages.inner_form')
    <div class="col-md-1 col-sm-6">
        <div><label class="control-label">&nbsp;</label></div>
        <button onclick="window.location.href='/message'" class="form-control ">Reset</button>
    </div>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th>Msg-ID</th>
                    <td>App-ID</td>
                    <th>Modul-ID</th>
                    <th>Lang.</th>
                    <th>Type</th>
                    <td>Message</td>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                @foreach( $messages as $message)
                    <tr>
                        <td><strong>{{$message->idmsg}}</strong></td>
                        <td>{{$message->appid}}</td>
                        <td>{{$message->modid}}</td>
                        <td>{{$message->lang}}</td>
                        <td>{{$message->type}}</td>
                        <td>{{$message->message}}</td>
                        <td>
                            <button  onClick='location.href ="/message/{{$message->id}}/edit";' type="button" class="btn btn-default">Edit</button>
                        </td>
                        <td>
                            <form  method="post" action="message/{{$message->id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                {{ method_field('DELETE') }}
                                <input type="submit" class="btn btn-danger" value="Delete" />
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>

        </table>
        <div>
            {{$messages->appends(request()->input())->links()}}
        </div>
    </div>

    <div><a class="btn btn-success" href="/message/create/">Create a new Message</a> </div>
@endsection