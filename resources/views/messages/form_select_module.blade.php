<select class="form-control" name="modul_id" id="modul_id" onchange="">
    <option value="null" >Choose</option>
    @foreach($modules as $modul)
        @if ($modul->id==$modul_id)
            <option value="{{$modul->id}}" selected>{{$modul->modul_name}}</option>
        @else
            <option value="{{$modul->id}}" >{{$modul->modul_name}}</option>
        @endif
    @endforeach
</select>