/**
 * Created by root on 1/10/15.
 */

$(document).ready(function() {

    $('.cc').mask('0000-0000-0000-0000', {reverse: false});
    $('.cvv').mask('0000', {reverse: false});
    $('.amount').mask('000000000.00', {reverse: true});
    $('.phone').mask('+000000000000000', {reverse: false});


	$("#loading").fadeOut(500);
	$("#loading-overlay").delay(200).fadeOut(600);

	$('#button-generate').on('click', function(){

		var element = this;

		$.ajax({
			url : 'index.php?route=account/account/generateKey&token='+$.cookie("tokenize"),
			dataType : 'json',
			type : 'POST',
			beforeSend: function() {
				$(element).button('loading');
			},
			complete: function() {
				$(element).button('reset');
			},
			success : function(json){
				$('input[name=\'api_id\']').val(json.api_id);
				$('textarea[name=\'secret_key\']').val(json.secret_key);
				console.log(json);

			},
			error : function(err){
				console.log(err);
			}
		});
	});

});