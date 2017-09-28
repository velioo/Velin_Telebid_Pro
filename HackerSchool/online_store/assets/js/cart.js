$(document).ready(function() {
	
	var addToCartUrl = getAddToCartUrl();
	var cartCountPriceUrl = getCartCountPriceUrl();
	var redirectUrl = getRedirectUrl();
	
	update_cart();
	
	$('.buy_button').on('click', function() {
		
		var product_id = $(this).parent().data('id');
		$.post(addToCartUrl, {product_id: product_id}, function(data, status) {
			if(data) {
				if(data != 'login') {
					update_cart();
					window.alert("Продуктът е добавен успешно в количката.");
				} else {
					window.location.href = redirectUrl;
				}			
				
			} else {
				window.alert("Имаше проблем в обработването на заявката ви.");
			}
		});
	});
	
	function update_cart() {
		$.post(cartCountPriceUrl, function(data, status) {
			if(data) {
				$('#cart_count_price').text(data[0].count + " артикул(а) - " + data[0].price_leva + " лв.");	
				if($('.cart_sum').length > 0) {
					$('.cart_sum').text("Обща сума: " + data[0].price_leva + " лв.");
				}	
			} 
		});
	}	
	
});
