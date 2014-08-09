<?php

require_once("../class.webimagemaximizer.php");

// url for the small image
$smallImage = "http://4.bp.blogspot.com/-V0A30kKCaKE/U9YgNkcnKzI/AAAAAAACV4I/4ECi9eQGxxY/s1600/borjkajpiza.jpg";

$result = webImageMaximizer::getRelatedImages($smallImage);

header('content-type: text/plain');

echo "Your image: " . $smallImage . "\n";
echo "Online search results: \n";
echo "\n";
print_r($result);

?>