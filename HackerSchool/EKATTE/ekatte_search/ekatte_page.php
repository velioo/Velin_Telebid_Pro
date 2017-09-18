<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>EKATTE Search</title>
  <meta name="description" content="EKATE Search">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>
	
  <script>
      $(document).ready(function() {
		  
		  $('#search_selishta').on('keyup', function(e) { 
			  var selishte = $('#search_selishta').val();
			  if(e.keyCode == 13) {
				$.get("ekatte_search.php", { name:selishte }, function(data, status){
					$('#results').empty();
					if(data != 0) {						
						$('#results').append(data);
			     	} else {
						$('#no_results').append("Няма намерени резултати");
					}
				});	  
			  }
	      });
		  
	  });
  </script>	
  <p>Търси селища</p>
  <input type="search" value="" id="search_selishta">
  </br></br>
  <table border="1" style="border-color: red;">
	  <thead>
		 <tr>
			 <td>Селище</td>
			 <td>Област</td>
			 <td>Община</td>
	     </tr>
	  </thead>
	  <tbody id="results">
	  </tbody>
  </table>
  <div id="no_results">
  </div>
</body>

</html>
