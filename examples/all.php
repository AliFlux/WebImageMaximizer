<?php

if(isset($_POST["q"])) {

	require_once("../class.webimagemaximizer.php");

	$result = webImageMaximizer::getRelatedImages($_POST["q"]);

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

<h4>Enter a URL of any image</h4>

<form method="post">
	<input type='text' name='q' value='http://staging.distractify.com/wp-content/uploads//2013/12//i-didnt-think-i-could-love-cats-more-than-i-do-then-i-discovered-this-rare-breed-17.jpg' style='width:400px' />
	<br/>
	<input type='submit' value='Go!' />
</form>
<br/>

<?php if(isset($_POST["q"])) { ?>

	<h2>Results</h2>
	<h3>This is... <?php echo $result["guess"]; ?></h3>

	<h4>Versions</h4>
	<?php foreach($result["versions"] as $image) { ?>
		<img src='<?php echo $image["image_url"]; ?>' style='max-width:1000px' /><br/>
	<?php } ?>

	<h4>Relatives</h4>
	<?php foreach($result["relatives"] as $image) { ?>
		<img src='<?php echo $image["image_url"]; ?>' style='max-width:1000px' /><br/>
	<?php } ?>

<?php } ?>

</body>
</html>