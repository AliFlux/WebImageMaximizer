<?php

if(isset($_POST["q"])) {

	require_once("../class.webimagemaximizer.php");

	$result = webImageMaximizer::getRelatedImages($_POST["q"]);

	// $result["guess"] is the guess
	// try print_r($result) to check the result
}

?><!DOCTYPE html><html><head lang='en-US'>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Guessing game</title>
<style>
* {
	font-family: 'segoe-ui', 'helvetica', sans-serif;
}
</style>
</head>
<body>

<h4>Enter a URL of any image and I will find out what it is!</h4>

<form method="post">
	<input type='text' name='q' value='http://www.blitzquotidiano.it/wp/wp/wp-content/uploads/2009/10/cacatua-300x199.jpg' style='width:400px' />
	<br/>
	<input type='submit' value='Search!' />
</form>
<br/>

<?php if(isset($_POST["q"])) { ?>
	<?php if($result["guess"] != "") { ?>

		<h4>This is an image of...</h4>
		<h3><?php echo $result["guess"]; ?></h3>
		<img src='<?php echo $result["biggestVersion"]; ?>' />

	<?php } else { ?>

		<h4>Sorry, Couldn't find what this image is... :(</h4>

	<?php } ?>
<?php } ?>

</body>
</html>