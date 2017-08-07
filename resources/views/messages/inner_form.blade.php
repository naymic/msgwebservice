
    <form class="" action="{{URL::to('/')}}/message{{$url_add}}" method="post" id="message-form" nam="message-form">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        {{ method_field($method) }}
        <div class="col-md-4 col-sm-12">
            <div><label class=" control-label">Message</label></div>
            <input class="form-control" type="text" name="message" id="message" value="{{$message}}" />
        </div>

        

        <div class="col-md-2 col-sm-6">
            <div><label class="control-label">Application</label></div>
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
        </div>
        <div class="col-md-2 col-sm-6">
            <div><label class="control-label">Modul</label></div>
            <select class="form-control" name="modul_id" id="modul_id" onchange="">
                <option value="null" >Choose</option>
               @include('messages.modules_form')
            </select>
        </div>

        <div class="col-md-1 col-sm-6">
            <div><label class="control-label">Language</label></div>
            <select class="form-control" name="lang_code" id="lang_code">
                <option value="null" >Choose</option>
                @foreach($languages as $language)
                    @if ($language->lang_code == $lang_code)
                        <option value="{{$language->lang_code}}" selected>{{$language->lang_name}}</option>
                    @else
                        <option value="{{$language->lang_code}}" >{{$language->lang_name}}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="col-md-1 col-sm-6">
            <div><label class="control-label">Type</label></div>
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
        </div>

        <div class="col-md-1 col-sm-6">
            <div><label class="control-label">&nbsp;</label></div>
            <input class="form-control btn btn-success col-md-1 col-sm-6" type="submit" value="{{$submit_value}}" />
        </div>

    </form>
