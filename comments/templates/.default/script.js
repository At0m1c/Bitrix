$(function() {
    $('.comment-send').click(function(e) {
        var name = $('.form-control.name').val();
        var text = $('.form-control.text').val();

        if (name == '' || text == '')
            $('.form-control').parent().addClass('has-error');

        $('.form-control.name, .form-control.text').focus(function() {
            if ($(this).parent().hasClass('has-error'))
                $(this).parent().removeClass('has-error');
        })

        $.ajax({
            url: $('#comment-form').attr('action'),
            type: "POST",
            dataType: "json",
            data: {
                user_name: name,
                message: text,
                submit: 'submit'
            },
            success: function(data) {
                console.log(data);
                $('.comments-list').prepend('<div class="panel panel-default"><div class="panel-heading"><div>' + data.date + ' <span class="panel-title"><b>' + data.user_name + '</b></span></div></div><div class="panel-body"><p>' + data.user_text + '</p></div></div>');
                $('.text-block').html('<div class="alert alert-success" role="alert">' + data.good_message + '</div>');
            }
        });
        $('.ajax-input').each(function(indx, element) {
            $(element).val('');
        });
        setTimeout(function() {
            $('.alert.alert-success').remove();
        }, 3000);
        return false;
    });
});