$(document).ready(function() {


});

// Payment Functions

function refund(transaction, status){

		$.ajax({
			url: 'index.php?route=account/transaction/refund&token=' + token,
			type: 'post',
			data : 'transaction=' + transaction + '&status=' + status,
			dataType: 'json',
			beforeSend: function() {
				showMask();
			},
			complete: function() {

				hideMask();

			},
			success: function(json) {

				if (json.status == 'OK'){
					$('li.transaction_action'+transaction).remove();
					$('span.transaction_status'+transaction).html('Refunded');
				}


			},
			error : function(){
				alert('Error');
			}
		});
}

function capture(transaction, status){
	alert(transaction);
}