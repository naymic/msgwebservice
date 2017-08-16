<select class="form-control" name="type" id="type">
    <option value="null" >Choose</option>
    @foreach($types as $msgtype)
        @if ($msgtype->type == $type)
            <option value="{{$msgtype->type}}" selected>{{$msgtype->type}}</option>
        @else
            <option value="{{$msgtype->type}}" >{{$msgtype->type}}</option>
        @endif
    @endforeach
</select>