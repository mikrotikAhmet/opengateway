$(document).ready(function() {
    $(".box .box-toggle").bind('click', function(){
        boxToggle(this);
        return false;
    });
    $(".remove-btn").bind('click', function(){
        messageRemove(this);
        return false;
    });
    
    // Selection Upload Method
    
        $('input[name=\'upload_method\']').bind('click',function(){
        $('#upload-method').attr('action', $(this).attr('rel'));
    });
    
    // Banks
        $('select[name=\'currency_code\']').bind('change',function(){
        
                if (this.value){
                    $.ajax({
		url: 'index.php?route=account/deposit/getBanks&token='+token+'&currency_id='+this.value,
		type: 'post',
		dataType: 'html',
		beforeSend: function() {
		},
		complete: function() {
		},
		success: function(html) {
			$('#banks').html(html);
		}
	});
                } else {
                    $('#banks').html('');
                }
});
           
    // JExpand
    $("#last-transactions tr:odd").addClass("master");
    $("#last-transactions tr:not(.master)").hide();
    $("#last-transactions tr:first-child").show();
    $("#last-transactions tr.master").click(function() {
        $(this).next("tr").toggle();
        $(this).find(".expand").toggleClass("icon-minus");
        
    });

    $('#last-transactions a').bind('click', function() {
        $(this).next("tr").toggle();
        $(this).find(".expand").toggleClass("icon-minus");
    });
    
        // Add new card
        $('#addcard').bind('click', function (){
            html = '<div class="panel" style="width: 30%">';
            html +='New Card Added';
            html +='<div>';
            
            $('.cards').append(html);
        });
    });

function boxToggle(that) {
    content_box = $(that).parent().parent().parent().find(".box-content");
    box = $(content_box).parent();
    if($(content_box).css("display") == "none") {
        $(content_box).slideDown(200, function(){
            $(box).removeClass("closed").addClass("open");
        });
    }
    else {
        $(content_box).slideUp(200, function(){
            $(box).removeClass("open").addClass("closed");
        });
    }
}

function messageRemove(that) {
    $(that).parent().slideUp(200);
}

function getURLVar(key) {
    var value = [];
	
    var query = String(document.location).split('?');
	
    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');
			
            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }
		
        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
} 

$(document).ready(function() {
    route = getURLVar('route');
	
    if (!route) {
        $('#dashboard').addClass('selected');
    } else {
        part = route.split('/');
		
        url = part[0];
		
        if (part[1]) {
            url += '/' + part[1];
        }
		
        $('a[href*=\'' + url + '\']').parents('li[id]').addClass('selected');
    }	
});