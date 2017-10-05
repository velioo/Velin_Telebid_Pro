$(document).ready(function() {
	
  var declineOrderUrl = getDeclineOrderUrl();
	
  $(".cancel_order").click(function(){
	if (confirm('Сигурни ли сте, че искате да откажете поръчката.')) {
		var order_id = $(this).data("id");
		var self = $(this);
		$.post(declineOrderUrl , {orderId: order_id}, function(data){
			if(data) {
				self.parent().parent().find('.order_status').text("Canceled");
				self.remove();
			} else {
				window.alert("Възникна проблем, моля свържете се с вашия администратор.");
			}			
		});
	} 
  });  
	
});
