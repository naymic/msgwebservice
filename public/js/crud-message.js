/**
 * Created by micha on 24.02.17.
 */

$(document).ready(function(){

    $('#application_id').change(function(){
        console.log('http://localhost/msgwebservice/public/ajax/message/application/'+$('#application_id').val());
        $.ajax({
            type: 'GET',
            url: 'http://localhost/msgwebservice/public/ajax/message/application/'+$('#application_id').val(),
            success: function (data) {
                $('#modul_id').html(data);
            }
        })
    });
});