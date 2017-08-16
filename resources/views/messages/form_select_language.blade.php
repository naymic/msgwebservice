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