$(document).ready(function() {

	var countries = getCountries();
	var phone = "";
	var phone_plus = false;
	
	change_phonecode();
		
	$('#country').on('change', function() {
		change_phonecode();
	});	
	
	$('#phone').on('keyup', function(e) {	
		var code = e.keyCode || e.which;	
		if(e.keyCode == 61 && e.shiftKey) {
			phone_plus = true;					
		}	
		phone = $('#phone').val();
		if(phone_plus == true) {
			check_country_codes();
		}	
	});
	
	function change_phonecode() {
		console.log("change_phone:" + phone);
		$.each(countries, function(index, country) {			
			var selected_country = $('#country').val();
			if(country.nicename == selected_country) {	
				var temp_val = $('#phone').val();
				if(phone.charAt(0) != '0') {
					if(temp_val.indexOf('+') !== -1) {
						console.log("Plus");
						$('#phone').val('+' + country.phonecode + ' ' + phone);
					} else {
						console.log("No Plus");
						$('#phone').val('+' + country.phonecode + ' ' + temp_val);
					}			
				}		
			}
		});	
	}
	
	function check_country_codes() {
		var temp_code = phone.replace("+", "");	
		if($('[data-id="' + temp_code + '"]').length > 0) {		
			$('[data-id="' + temp_code + '"]').attr('selected', 'selected');
			phone_plus = false;
			temp_code = '+' + temp_code;
			phone = phone.replace(temp_code, "");
		} 
	}
});
