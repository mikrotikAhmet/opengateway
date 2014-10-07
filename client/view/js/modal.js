$(document).ready(function() {
    $('a.modal').click(function(e) {
        e.preventDefault();
        var id = $(this).attr('href');
        var title = $(this).attr('title');
        var target = $(this).attr('data-modal');
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
        $('#mask').css({
            'width': maskWidth,
            'height': maskHeight
        });
        $('#mask').fadeTo(800, 0.95);
        var winH = $(window).height();
        var winW = $(window).width();
        $(id).css('top', winH / 2.5 - $(id).height() / 2);
        $(id).css('left', winW / 2 - $(id).width() / 2);

        if (target == 'addcard') {
            addcard(id, title, target);
        }

    });
    $('#mask').click(function() {
        $(this).hide();
        $('.modal-container').hide();
    });

    $('#spinner').click(function() {
        $(this).hide(); // remove this later
    });
    
});

function addcard(id, title, target) {

    $.ajax({
        url: 'index.php?route=account/deposit/addcard&token=' + token,
        type: 'post',
        dataType: 'html',
        beforeSend: function() {
        },
        complete: function() {
        },
        success: function(html) {
            $('.modal-content').html(html);
            $(id + ' h2').html(title);
            $(id).fadeIn(500);
            
                $('.addnewcard').bind('click',function(){
                    
                    $.ajax({
                        url: 'index.php?route=account/deposit/validateCard&token=' + token,
                        type:'post',
                        dataType : 'json',
                        beforeSend : function(){
                            
                            html ='<div class="wait">';
                            html +='<i class="icon-spinner7 spin panel-icon"></i>';
                            html +='<p>Please wait.</p>';
                            html +='</div>';
                            $('.modal-content').html(html);
                        },
                        complete : function(){
//                            $('.wait').remove();
                        },
                        success : function(json){
//                            $('#mask').hide();
//                            $('.modal-container').hide();
                        }
                    });
                    
                    $('[data-dismiss]').trigger('click');
                });

            $('[data-dismiss]').click(function() {
                $('#mask').hide();
                $('.modal-container').hide();
            });
        }
    });

}

function showMask() {
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();
    $('#spinner').css({
        'width': maskWidth,
        'height': maskHeight
    });
    $('#spinner').fadeTo(800, 0.95);
}