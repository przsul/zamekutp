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

		<!-- Whitelist header -->
		<div class="row">
			<div class="col"></div>
			<div class="col-sm-8 sticky-top mt-2">
				<h1 id="whitelistHeader" class="text-center"></h1>
			</div>
			<div class="col"></div>
		</div>

		<!-- Search -->
		<div class="row">
			<div class="col"></div>
			<div class="col-sm-8 py-0 px-1">
				<span class="font-weight-bold">Search:</span>
				<input id="search" type="text" class="form-control form-control-sm mb-2" placeholder="e.g. Kowalski">
			</div>
			<div class="col"></div>
		</div>

		<!-- Add form -->
		<div class="row">
			<div class="col"></div>
			<div class="col-sm-2 py-0 px-1">
				<span class="font-weight-bold">Last name:</span>
				<input id="last_name" type="text" class="form-control form-control-sm mb-2" placeholder="Last name">
			</div>
			<div class="col-sm-2 py-0 px-1">
				<span class="font-weight-bold">First name:</span>
				<input id="first_name" type="text" class="form-control form-control-sm mb-2" placeholder="First name">
			</div>
			<div class="col-sm-2 py-0 px-1">
				<span class="font-weight-bold">UID:</span>
				<input id="card_id" type="text" class="form-control form-control-sm mb-2" placeholder="UID">
			</div>
			<div class="col-sm-2 py-0 px-1">
				<button type="button" class="btn btn-sm btn-success btn-block mt-4 mb-2">Add</button>
			</div>
			<div class="col"></div>
		</div>

		<!-- Table entries + footer -->
		<div class="row">
			<div class="col"></div>
			<div class="col-sm-8 pt-0 pb-4 px-1">
				<div class="table-responsive">
					<table class="table table-hover">
						<tbody id="persons">
							<thead>
								<th>Database ID</th>
								<th>Last name</th>
								<th>First name</th>
								<th>UID</th>
								<th id="delete">DELETE</th>
							</thead>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col"></div>
		</div>

	</div>
</body>
</html>

<?php
}
?>
