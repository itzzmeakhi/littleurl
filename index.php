<?php

ob_start();

session_start();

$_SESSION['littleurl'] = "";
$_SESSION['text'] = "";
$_SESSION['header'] = "";

// Time Zone

$timezone = date_default_timezone_set("Indian/Mauritius");

// Database Connection

$con = mysqli_connect("localhost", "root", "root", "littleurl");

if(mysqli_connect_errno()) {
	echo "Failed to connect to database" . mysqli_connect_errno();
}

$longurl = ""; // Variable for storing long URL
$customized = ""; // Variable for storing customized word
$littleurl = ""; // Variable for storing little URL
$error_array = array(); // Variable that holds error messages
$check_url = ""; // Variable that holds O if checked and 1 if not
$base_url = "http://localhost:8080/littleurl/index.php/"; // Variable for storing base URL


$get_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; // To get the base URL

$len_url = strlen($get_url); // To get the length of the base URL

$check_url = substr($get_url, 42, $len_url); // To slice the customized word from the base URL

$_SESSION['check_url'] = 1;


// To redirect to long URL with respect to short URL given

if(!empty($check_url)) {

	$query = mysqli_query($con, "SELECT * FROM mapped_urls WHERE customized_word = '$check_url'");

	$num_rows = mysqli_num_rows($query);

	$row = mysqli_fetch_array($query);

	if($num_rows == 1) {

		$_SERVER['HTTP_HOST'] = $row['longurl'];

		$protocol = substr($_SERVER['HTTP_HOST'],0 ,4);

		if($protocol == "http") {

			$redirect_to = $_SERVER['HTTP_HOST'];

		} else {

			$redirect_to = "https://".$_SERVER['HTTP_HOST'];

		}

		$counter = $row['clicks'];

		$word = $row['customized_word'];

		$counter = $counter + 1;

		$query = mysqli_query($con, "UPDATE mapped_urls SET clicks = '$counter' WHERE customized_word = '$word'");

		header('Location:'.$redirect_to);
	} 
}


// To search whether customized short URL is available or not


if(isset($_POST['search-url'])) {

	// Customized URL

	$customized = strip_tags($_POST['cust-url']); // To strip tags if any tags are present in the input
	$customized = str_replace(' ', '', $customized); // To remove the spaces

	$check = mysqli_query($con, "SELECT * FROM mapped_urls WHERE customized_word = '$customized'");

	$num_rows = mysqli_num_rows($check);

	if($num_rows > 0) {

		array_push($error_array, "<span style = 'color:#c0392b;'>Your Customized URL is already taken. Try another one!</span></br>");
		$_SESSION['check_url'] = 1;

	} else {

		array_push($error_array, "<span style = 'color:#34495e;'>Your Customized URL is available. Map it!</span></br>");
		$_SESSION['check_url'] = 0;

	}

}


// To Map the short URL to long URL



if(isset($_POST['map-url'])) {

	// Date created

	$date = date("Y-m-d"); // Current date

	// Customized URL

	$customized = strip_tags($_POST['cust-url']); // To strip tags if any tags are present in the input
	$customized = str_replace(' ', '', $customized); // To remove the spaces

	// Long URL

	$longurl = strip_tags($_POST['long-url']); // To strip tags if any tags are present in the input
	$longurl = str_replace(' ', '', $longurl); // To remove the spaces
	$_SESSION['longurl'] = $longurl;


	if($_SESSION['check_url'] != 0) {

		$check = mysqli_query($con, "SELECT * FROM mapped_urls WHERE customized_word = '$customized'");

		$num_rows = mysqli_num_rows($check);

		if($num_rows > 0) {

			array_push($error_array, "<span style = 'color:#c0392b;'>Your Customized URL is already taken. Try another one!</span></br>");

		} else {

			$_SESSION['check_url'] = 0;

		}
	}

	if($_SESSION['check_url'] == 0) {

		$littleurl = $base_url . $customized;

		$query = mysqli_query($con, "INSERT INTO mapped_urls VALUES ('', '$longurl', '$littleurl', '$customized', '$date', 0)");

        $_SESSION['longurl'] = "";
        $_SESSION['check_url'] = "";

        $_SESSION['text'] = "Your Short URL is </h4></br>";
        $_SESSION['header'] = "<h4>";
		$_SESSION['littleurl'] = $littleurl;


	}

}

?>






<!DOCTYPE html>
<html>
<head>

	<title> Welcome to Little Url </title>
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

		<!--------------- Long URL Form ----------------->


		<form action = "index.php" method = "POST" id = "url-form" class = "url-form">

			<label> Enter the long url </label></br>

			<input type = "text" name = "long-url" id = "long-url" placeholder = "Your URL" value="<?php 
					if(isset($_SESSION['longurl'])) {
						echo $_SESSION['longurl'];
					} 
					?>"required></br>

			<label> Search for your Customized URL </label></br>

			<h6> (i.e., Only Word) </h6></br>

			<input type = "text" name = "cust-url" id = "cust-url" placeholder = "Customized URL" required></br>


			<?php if(in_array("<span style = 'color:#c0392b;'>Your Customized URL is already taken. Try another one!</span></br>", $error_array)) echo  "<span style = 'color:#c0392b;'>Your Customized URL is already taken. Try another one!</br></span>"; ?>



			<?php if(in_array("<span style = 'color:#34495e;'>Your Customized URL is available. Map it!</span></br>", $error_array)) echo  "<span style = 'color:#34495e;'>Your Customized URL is available. Map it!</span></br>"; ?>

			<input type = "submit" name = "search-url" id = "search-url" value = "Search..!">

			<input type = "submit" name = "map-url" id = "map-url" value = "Map..!">

		</form>

		<div class = "display-littleurl">

			<?php

				if(isset($_SESSION['littleurl'])) {
					echo $_SESSION['header'].$_SESSION['text']."<h5>".$_SESSION['littleurl']."</h5>";

				}

			?>


		</div>


	</div>

</body>
</html>