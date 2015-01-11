$(document).ready(function () {


    var root = location.protocol + '//' + location.host + "/";
    var sub;
    var link = root + sub;

    //---------------------------------------------------------------------
    $('.add_images').click(function () {
        var chk = $(this).attr('id');
        $('.display').show();
        var att = $(this).attr('rel');
        var filename = $(this).attr('filename');
        var sl = parseInt($(".add_file" + att + " input[type='file']").length);
        if (sl < 10) {
            sl++;
            val_radio = sl;

            $(".add_file" + att).append('<div class="tir"><input multiple type="file" name="' + 'file' + '[' + chk + '][]"><a class="remove">Remove</a></div></div>'
            );
            $("#images-" + att).removeAttr('sl');
            $("#images-" + att).attr('sl', '' + sl + '');

        } else {
            alert('Must be lower 10');
        }
    });

    $('.add_text').click(function () {
        var filename = $(this).attr('filename');
        var chk = $(this).attr('id');
        $('.display2').show();
        var att = $(this).attr('rel');
        var sl = parseInt($(".add_text" + att + " input[type='text']").length);
        if (sl < 10) {
            sl++;
            val_radio = sl;
            $(".add_text" + att).append('<div class="tir-text"><input type="text" name="' + 'text' + '[' + chk + '][]"><a class="remove">Remove</a></div>');

        } else {
            alert('Must be lower 10');
        }
    })
    $('.remove').live('click', function () {
        $(this).parent().remove();
    })
// ----------------------------xoa--------------------------------//

});