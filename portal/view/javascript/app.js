/**
 * Created by root on 1/10/15.
 */
$(document).ready(function() {

	// Formating fields
	$('.cc').mask('0000-0000-0000-0000', {reverse: false});
	$('.cvv').mask('0000', {reverse: false});
	$('.amount').mask('000000000.00', {reverse: true});
	$('.phone').mask('+000000000000000', {reverse: false});


	$('#button-generate').on('click', function(){

		var element = this;

		$.ajax({
			url : 'index.php?route=account/setting/generateKey&token='+$.cookie("tokenize"),
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

	$('#button-add-verify').on('click',function(){

		var element = this;

		$('#error-message').hide();

		var data = $('#add-card').serialize();

		$.ajax({
			url : 'index.php?route=account/account/addCard&token='+$.cookie("tokenize"),
			dataType : 'json',
			type : 'POST',
			data : data,
			beforeSend: function() {
				$(element).button('loading');
			},
			complete: function() {
				$(element).button('reset');
			},
			success : function(json){

				if (json.status != "OK") {
					html = json.status
					$('#card-error-message').html(html);
					$('#error-message').show();
					return false;
				}
				$('#add_card_modal').modal('hide');
				location.reload(true);

			},
			error : function(err){
				console.log(err);
			}
		});
	});

	$('#button-deposit').on('click',function(){
		if ($(this).attr('data-link') == ''){
			alert('Error card!');
			return false;
		}
		$('input[name=\'card_id\']').prop('value',$(this).attr('data-link'));
		$('input[name=\'verification\']').prop('value',$('input[name=\'card_'+$(this).attr('data-link')+'\']').val());

		if ($('input[name=\'verification\']').val() == 0){
			$('#verification').show();
			$('#deposit-limit').show();
		} else {
			$('#verification').hide();
			$('#deposit-limit').hide();
		}

		$('#button-make-deposit').attr('disabled',false);

		$('#deposit_modal').modal('show');
	});

	$('#button-make-deposit').on('click',function(){

		var deposit = this;

		$('#button-make-deposit').attr('disabled',true);

		var data = $('#makeDeposit').serialize();

		$.ajax({
			url : 'index.php?route=api/charge/deposit&token='+$.cookie("tokenize"),
			dataType : 'json',
			type : 'POST',
			data : data,
			beforeSend: function() {
				$(deposit).button('loading');
			},
			complete: function() {
				$(deposit).button('reset');
			},
			success : function(json){

				if (json.status != "OK") {
					html = json.status
					$('#card-error-message2').html(html);
					$('#error-message2').show();
					$('#button-make-deposit').attr('disabled',false);
					return false;
				}

				console.log(json);
				$('#deposit_modal').modal('hide');
				window.location='index.php?route=report/transaction/detail&token='+$.cookie("tokenize")+'&transaction_id='+json.transaction_id;

			}
		});
	});

	// Make new transaction
	$('#button-charge').on('click',function(){

		var element = this;

		$('#error-message').hide();
		$('#button-charge').attr('disabled',true);

		var data = $('#new-transaction').serialize();

		$.ajax({
			url : 'index.php?route=api/charge/charge&token='+$.cookie("tokenize"),
			dataType : 'json',
			type : 'POST',
			data : data,
			beforeSend: function() {
				$(element).button('loading');
			},
			complete: function() {
				$(element).button('reset');
			},
			success : function(json){

				if (json.status != "OK") {
					html = json.status
					$('#charge-error-message').html(html);
					$('#error-message').show();
					$('#button-charge').attr('disabled',false);
					return false;
				}

				$('#button-charge').attr('disabled',false);
				window.location='index.php?route=report/transaction/detail&token='+$.cookie("tokenize")+'&transaction_id='+json.transaction_id;

			},
			error : function(err){
				console.log(err);
			}
		});
	});

	$('#button-do-verification').on('click',function(){

		var verification = this;

		$('#button-do-verification').attr('disabled',true);

		var data = $('#startVerification').serialize();

		$.ajax({
			url : 'index.php?route=account/account/doVerification&token='+$.cookie("tokenize"),
			dataType : 'json',
			type : 'POST',
			data : data,
			beforeSend: function() {
				$(verification).button('verifying');
			},
			complete: function() {
				$(verification).button('reset');
			},
			success : function(json){

				if (json.status != "OK") {
					html = json.status
					$('#verification-error-message').html(html);
					$('#error-verification').show();
					$('#button-do-verification').attr('disabled',false);
					$('#startVerification')[0].reset();
					return false;
				}

				console.log(json);
				$('#verification_modal').modal('hide');
				window.location='index.php?route=report/transaction/detail&token='+$.cookie("tokenize")+'&transaction_id='+json.transaction_id;

			},
			error : function(err){
				console.log(err);
			}
		});
	});

	$('#button-send-money').on('click',function(){

		var send = this;

		$('#button-send-money').attr('disabled',true);

		var data = $('#send-money').serialize();

		$.ajax({
			url : 'index.php?route=account/account/sendMoney&token='+$.cookie("tokenize"),
			dataType : 'json',
			type : 'POST',
			data : data,
			beforeSend: function() {
				$(send).button('loading');
			},
			complete: function() {
				$(send).button('reset');
			},
			success : function(json){

				if (json.status != "OK") {
					html = json.status
					$('#send-error-message').html(html);
					$('#error-send-message').show();
					$('#button-send-money').attr('disabled',false);
					$('#send-money')[0].reset();
					return false;
				}

				console.log(json);
				window.location='index.php?route=common/dashboard&token='+$.cookie("tokenize");


			},
			error : function(err){
				console.log(err);
			}
		});
	});


	$('#add_card_modal').on('hidden.bs.modal', function () {
		$('#error-message').hide();
		$('#add-card')[0].reset();
	});

	$('#deposit_modal').on('hidden.bs.modal', function () {
		$('#error-message2').hide();
		$('#makeDeposit')[0].reset();
	});


});

function makeRefund(element,id){

	var data =  { transaction_id : id}

	$.ajax({

		url : 'index.php?route=api/common/refund&token='+$.cookie("tokenize"),
		dataType : 'json',
		type : 'POST',
		data : data,
		beforeSend: function() {
			$(element).button('loading');
		},
		complete: function() {
			$(element).button('reset');
		},
		success : function(json){

			console.log(json);

			if (json.status != "OK") {
				html = json.status
				$('#charge-error-message').html(html);
				$('#error-message').show();
				$('#button-charge').attr('disabled',false);
				return false;
			}

			$('#button-charge').attr('disabled',false);
			window.location='index.php?route=report/transaction/detail&token='+$.cookie("tokenize")+'&transaction_id='+json.transaction_id;

		},
		error : function(err){
			console.log(err);
		}
	});
}

function makeCapture(element,id){

    var data =  { transaction_id : id}

    $.ajax({

        url : 'index.php?route=api/common/capture&token='+$.cookie("tokenize"),
        dataType : 'json',
        type : 'POST',
        data : data,
        beforeSend: function() {
            $(element).button('loading');
        },
        complete: function() {
            $(element).button('reset');
        },
        success : function(json){

            console.log(json);

            if (json.status != "OK") {
                html = json.status
                $('#charge-error-message').html(html);
                $('#error-message').show();
                $('#button-charge').attr('disabled',false);
                return false;
            }

            $('#button-charge').attr('disabled',false);
            window.location='index.php?route=report/transaction/detail&token='+$.cookie("tokenize")+'&transaction_id='+json.transaction_id;

        },
        error : function(err){
            console.log(err);
        }
    });
}

function doVerification(verify,card){

	$('input[name=\'verification_card_id\']').val(card);

	$('#verification_modal').modal('show');
}

function verifyCard(verify,card){

	$.ajax({
		url : 'index.php?route=account/account/cardVerification&token='+$.cookie("tokenize"),
		dataType : 'json',
		type : 'POST',
		data : 'card='+card,
		beforeSend: function() {
			$(verify).button('loading');
		},
		complete: function() {
		},
		success : function(json){

			if (json.status == 'OK') {
				window.location='index.php?route=report/transaction/detail&token='+$.cookie("tokenize")+'&transaction_id='+json.transaction_id;
			}

			if (json.status == 'Error') {
				return false;
			}

		},
		error : function(err){
			console.log(err);
		}
	});
}

function makeVoid(element,id){

    var data =  { transaction_id : id}

    $.ajax({

        url : 'index.php?route=api/common/void&token='+$.cookie("tokenize"),
        dataType : 'json',
        type : 'POST',
        data : data,
        beforeSend: function() {
            $(element).button('loading');
        },
        complete: function() {
            $(element).button('reset');
        },
        success : function(json){

            console.log(json);

            if (json.status != "OK") {
                html = json.status
                $('#charge-error-message').html(html);
                $('#error-message').show();
                $('#button-charge').attr('disabled',false);
                return false;
            }

            $('#button-charge').attr('disabled',false);
            window.location='index.php?route=report/transaction/detail&token='+$.cookie("tokenize")+'&transaction_id='+json.transaction_id;

        },
        error : function(err){
            console.log(err);
        }
    });
}

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