/**
 * Created by micha on 24.02.17.
 */

$(document).ready(function(){

    $('#application_id').change(function(){
        $.ajax({
            type: 'GET',
            url: '/ajax/message/application/'+$('#application_id').val(),
            success: function (data) {
                $('#modul_id').html(data);
            }
        })
    });
});