$(document).ready(function() {	
    $('a.modal').click(function(e) {
        e.preventDefault();
        var id = $(this).attr('href');
        var title = $(this).attr('title');
        var target = $(this).attr('data-modal');
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
        $('#mask').css({
            'width':maskWidth,
            'height':maskHeight
        });
        $('#mask').fadeTo(800,0.95);	
        var winH = $(window).height();
        var winW = $(window).width();
        $(id).css('top',  winH/2.5-$(id).height()/2);
        $(id).css('left', winW/2-$(id).width()/2);
        $(id + ' h2').html(title);
        
        
        $('.modal-content').html('Add Card form will be called here by ajax');
        
        
        $(id).fadeIn(500); 
        
    });	
    $('#mask').click(function () {
        $(this).hide();
        $('.modal-container').hide();
    });
        
    $('[data-dismiss]').click(function(){
        $('#mask').hide();
        $('.modal-container').hide();
    });
});