$(document).ready(function() {

	$('ul#mainnav li a').bind('click',function(){
		showMask();
	});

    $(".box .box-toggle").bind('click', function() {
        boxToggle(this);
        return false;
    });
    $(".remove-btn").bind('click', function() {
        messageRemove(this);
        return false;
    });

    // Selection Upload Method

    $('input[name=\'upload_method\']').bind('click', function() {
        $('#upload-method').attr('action', $(this).attr('rel'));
    });

    // Banks
    $('select[name=\'currency_code\']').bind('change', function() {

        if (this.value) {
            $.ajax({
                url: 'index.php?route=account/deposit/getBanks&token=' + token + '&currency_id=' + this.value,
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

    // Date Picker
    $('.date').datepicker({
        dateFormat: 'yy-mm-dd'
    });

    // Last Transactions
    $("#last-transactions tr:odd").addClass("master");
    $("#last-transactions tr:not(.master)").hide();
    $("#last-transactions tr:first-child").show();
    
    $("#last-transactions tr.master").click(function() {
        $(this).next("tr").toggle();
        $(this).find(".expand").toggleClass("icon-minus");
        $(this).toggleClass("selected");
        

    });

    $('#last-transactions a').bind('click', function() {
        $(this).next("tr").toggle();
        $(this).find(".expand").toggleClass("icon-minus");
        $(this).toggleClass("selected");
    });

    // All Transactions
    $("#all-transactions tr:odd").addClass("master");
    $("#all-transactions tr:not(.master)").hide();
    $("#all-transactions tr:first-child").show();

    $("#all-transactions tr.master").click(function() {
        $(this).next("tr").toggle();
        $(this).find(".expand").toggleClass("icon-minus");
        $(this).toggleClass("selected");


    });

    $('#last-transactions a').bind('click', function() {
        $(this).next("tr").toggle();
        $(this).find(".expand").toggleClass("icon-minus");
        $(this).toggleClass("selected");
    });

    // Add new card
    $('#addcard').bind('click', function() {
        html = '<div class="panel" style="width: 30%">';
        html += 'New Card Added';
        html += '<div>';

        $('.cards').append(html);
    });
});

function boxToggle(that) {
    content_box = $(that).parent().parent().parent().find(".box-content");
    box = $(content_box).parent();
    if ($(content_box).css("display") == "none") {
        $(content_box).slideDown(200, function() {
            $(box).removeClass("closed").addClass("open");
        });
    }
    else {
        $(content_box).slideUp(200, function() {
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

	$('#mask').hide();
	$('.modal-container').hide();
}

$(document).ready(function() {

    route = getURLVar('route');

    if (!route) {
        $('#dashboard').addClass('active');
    } else {
        part = route.split('/');

        url = part[0];

        if (part[1]) {
            url += '/' + part[1];
        }

        $('a[href*=\'' + url + '\']').parents('li[id]').addClass('active');

    }



});

function DateAdd(date, type, amount){
    var y = date.getFullYear(),
    m = date.getMonth(),
    d = date.getDate();
    if(type === 'y'){
        y += amount;
    };
    if(type === 'm'){
        m += amount;
    };
    if(type === 'd'){
        d += amount;
    };
    return new Date(y, m, d);
}

function DateRemove(date, type, amount){
    var y = date.getFullYear(),
    m = date.getMonth(),
    d = date.getDate();
    if(type === 'y'){
        y -= amount;
    };
    if(type === 'm'){
        m -= amount;
    };
    if(type === 'd'){
        d -= amount;
    };
    return new Date(y, m, d);
}

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
                var data = $('form[id=\'addcard\']').serialize();            
                $.ajax({
                    url: 'index.php?route=account/deposit/validateCard&token=' + token,
                    type:'post',
                    data : data,
                    dataType : 'json',
                    beforeSend : function(){
                            
                        html ='<div class="wait">';
                        html +='<i class="icon-spinner7 spin panel-icon"></i>';
                        html +='</div>';
                        $('.modal-content').html(html);
                    },
                    complete : function(){
                        $('.wait').remove();
                    },
                    success : function(json){
                        if (json.status == 'OK'){
                            $('#mask').hide();
                            $('.modal-container').hide();  

                        } else {
                            $('.modal-content').html(json.status);
                        }
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