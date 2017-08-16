
    <form class="" action="{{URL::to('/')}}/message{{$url_add}}" method="post" id="message-form" nam="message-form">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        {{ method_field($method) }}
        <div class="col-md-4 col-sm-12">
            <div><label class=" control-label">Message</label></div>
            <input class="form-control" type="text" name="message" id="message" value="{{$message}}" />

        </div>

        <div class="col-md-2 col-sm-6">
            <div><label class="control-label">Application</label></div>
            @include('messages.form_select_application')
        </div>

        <div class="col-md-2 col-sm-6">
            <div><label class="control-label">Modul</label></div>
            @include('messages.form_select_module')
        </div>

        <div class="col-md-1 col-sm-6">
            <div><label class="control-label">Language</label></div>
            @include('messages.form_select_language')
        </div>

        <div class="col-md-1 col-sm-6">
            <div><label class="control-label">Type</label></div>
            @include('messages.form_select_msgtype')
        </div>

        <div class="col-md-1 col-sm-6">
            <div><label class="control-label">&nbsp;</label></div>
            <input class="form-control btn btn-success col-md-1 col-sm-6" type="submit" value="{{$submit_value}}" />
        </div>

    </form>
