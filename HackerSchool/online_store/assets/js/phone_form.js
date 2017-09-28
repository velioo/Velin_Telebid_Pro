$(document).ready(function() {

	var countries = getCountries();
	
	change_phonecode();
		
	$('#country').on('change', function() {
		change_phonecode();
	});	
	
	function change_phonecode() {
		$.each(countries, function(index, country) {			
			var selected_country = $('#country').val();
			if(country.nicename == selected_country) {		
				$('#phone_label').text('Телефон*: (' + country.phonecode + ')');
			}
		});	
	}
});
