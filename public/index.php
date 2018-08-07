<?php
require 'authConfig.php';

$auth = false;
if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
	$_login = $_SERVER['PHP_AUTH_USER'];
	$_pass = $_SERVER['PHP_AUTH_PW'];
	if ($_login == $login && $_pass == $pass) {
		$auth = true;
	}
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

		<!-- Latest compiled and minified Bootstrap4 CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

		<!-- Font Awesone -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!-- Own CSS -->
		<link rel="stylesheet" type="text/css" href="css/style.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

		<!-- Latest compiled JavaScript for Bootstrap4-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

		<!-- Own JS -->
		<script src="js/script.js"></script>
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

				<!-- Multiple inputs -->
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">Person</span>
					</div>
					<input id="last_name" type="text" class="form-control" placeholder="Last Name">
					<input id="first_name" type="text" class="form-control" placeholder="First Name">
					<input id="card_id" type="text" class="form-control" placeholder="Card ID">
					<div class="input-group-append">
						<button class="btn btn-success" type="submit">Add</button> 
					</div>
				</div>

					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Database ID</th>
									<th>Last name</th>
									<th>First name</th>
									<th>Card ID</th>
									<th id="delete">DELETE</th>
								</tr>
							</thead>
							<tbody id="persons">
							</tbody>
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
