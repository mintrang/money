$(document).ready(function(){
    function loadData(page){
        loading_show();
        $.ajax
        ({
            type: "POST",
            url: "http://local.tutorial/users/list",
            data: "page="+page,
            success: function(msg)
            {
                $(".content").ajaxComplete(function(event, request, settings)
                {
                    $(".content").html(msg);
                });
            }
        });
    }

// LOAD GIÁ TRỊ MẶC ĐỊNH PAGE = 1 CHO LẦN ĐẦU TIÊN
    loadData(1);
});