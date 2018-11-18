
<?php

ob_start();

session_start();

$con = mysqli_connect("localhost", "root", "root", "littleurl");

if(mysqli_connect_errno()) {
	echo "Failed to connect to database" . mysqli_connect_errno();
}


if(isset($_POST['admin-login'])) {

	$username = "";
	$password = "";
	$error_array = array();
	$_SESSION['username'] = "";

	$header1 = "<h3> Customized Word </h3>";
	$header2 = "<h3> Number of Clicks </h3>";
	$header3 = "<h2 class = 'analysis-header'> URL's Analysis </h2>";
	$button = "<a href = 'logout.php' class = 'button'>Logout</a>";
	$table_s = "<table border='3'>";
	$table_e = "</table>";
	


	$username = strip_tags($_POST['admin-username']);
	$username = str_replace(" ", "", $username);

	$password = strip_tags($_POST['admin-pwd']);


	$query = mysqli_query($con, "SELECT * FROM login WHERE username = '$username' AND password = '$password'");

	$num_rows = mysqli_num_rows($query);

	if($num_rows == 1) {
		$_SESSION['username'] = $username;
		$query = mysqli_query($con, "SELECT customized_word, clicks FROM mapped_urls");
	} else {
		array_push($error_array, "<span style = 'color:#c0392b;'> Wrong Credentials..! </span></br>");
	}


}



?>



<!DOCTYPE html>
<html>
<head>
	<title> ADMIN LOGIN </title>
	<meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1">

    <!-- Font -->

    <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet">

    <!-- Favicon -->

    <link rel="icon" href="assets/images/logo-main.png">

    <!-- CSS INCLUDES -->

	<link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel = "stylesheet" type = "text/css" href = "assets/css/index.css">
	<link rel = "stylesheet" type = "text/css" href = "assets/css/mediaqueries.css">


	<!-- JAVASCRIPT INCLUDES -->

	<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src = "https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</head>
<body>

	<!-- NAVBAR SECTION -->


	<nav class = "navbar navbar-expand-sm bg-dark navbar-dark">

		<a class = "navbar-brand" href = "index.php"> 
			<h3> Little Url </h3>
		</a>


	</nav>

	<div class = "container-fluid body-container">


		<form action = "admin.php" method = "POST" class = "admin-form">

			<h3> Administrator Login </h3>

			<label> Username </label>

			<input type = "text" name = "admin-username" id = "admin-username" placeholder = "Enter Username" required></br>

			<label> Password </label>

			<input type = "password" name = "admin-pwd" id = "admin-pwd" placeholder = "Enter Password" required></br>

			<input type = "submit" name = "admin-login" id = "admin-login" value = "Login..!">

			<?php if(in_array("<span style = 'color:#c0392b;'> Wrong Credentials..! </span></br>", $error_array)) echo  "<span style = 'color:#c0392b;'> Wrong Credentials..! </span></br>"; ?>


		</form>

		<div class = "analysis">


			

		    <?php

		    echo $header3;

			echo $table_s."
				<tr>
				<th>".$header1."</th>
				<th>".$header2."</th>
				</tr>";

			while($row = mysqli_fetch_array($query)) {
				echo "<tr>";
				echo "<td>".$row['customized_word']."</td>";
				echo "<td>".$row['clicks']."</td>";
				echo "</tr>";

			}
			echo $table_e;

			echo $button;

			


		    ?>

		    



		</div>

	</div>

	


</body>

</html>