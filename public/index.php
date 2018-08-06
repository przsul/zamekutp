<?php

  require 'authConfig.php';

  $auth = false;
  if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
      $_login = $_SERVER['PHP_AUTH_USER'];
      $_pass = $_SERVER['PHP_AUTH_PW'];
      if ($_login == $login && $_pass == $pass)
              $auth = true;
  }

  if ($auth == false) {
      header('WWW-Authenticate: Basic');
      header('HTTP/1.0 401 Unauthorized');
      echo "<b>Authentication failed. Refresh page for new access attempt.</b>";
      exit;
  } else { 
?>     

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

	<style>
		.center-block {
			justify-content: center
		}
		i {
			cursor: pointer;
		}
	</style>
	<script>
		$(document).ready(function () {
			$.getJSON("getData.php", function (result) {
				var count = result.length;
				$("#whitelistHeader").text("Whitelist: " + count + " persons");

				$.each(result, function (i, field) {
					$("#persons").append(
						'<tr class="person">' + 
						'<td>' + field.id + '</td><td>' + field.last_name + '</td>' + 
						'<td>' + field.first_name + '</td><td class="text-center"><i class="fa fa-times-circle" data-toggle="modal" data-target="#myModal"></i></td>' +
						'</tr>');
				});

				$("i.fa").click(function() {
					if (confirm("Are you sure to delete this person?")) {
						var personID = $(this).parent().prev().prev().prev().text();
						var data = {id: personID};
						$.post("deleteData.php", data); 
						$(this).closest("tr").fadeOut("fast");
						$("#whitelistHeader").text("Whitelist: " + --count + " persons");
					}
				});

			});

			$("#search").keyup(function () {
				var value = $(this).val().toLowerCase();
				$("#persons tr").filter(function () {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});

		});
	</script>
</head>

<body>

	<div class="container">
		<div class="row center-block">
			<div class="col-sm-8 mt-3">
				<h1 id="whitelistHeader" class="text-center"></h1>
			</div>

			<div class="col-sm-7">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">Search:</span>
					</div>
					<input id="search" type="text" class="form-control" placeholder="e.g. Kowalski" aria-label="Username" aria-describedby="basic-addon1">
				</div>

				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Lastname</th>
								<th>Firstname</th>
								<th style="color:red;text-align:center">DELETE</th>
							</tr>
						</thead>
						<tbody id="persons"></tbody>
					</table>
				</div>
			</div>
		</div>

	</div>

</body>

</html>

<?php
}
?>
