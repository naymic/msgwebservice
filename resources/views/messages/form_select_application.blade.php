<select class="form-control" name="application_id" id="application_id">
    <option value="null" >Choose</option>
    @foreach($applications as $application)
        @if ($application->id==$application_id)
            <option value="{{$application->id}}" selected>{{$application->app_name}}</option>
        @else
            <option value="{{$application->id}}" >{{$application->app_name}}</option>
        @endif
    @endforeach
</select>