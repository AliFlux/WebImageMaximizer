# WebImageMaximizer
#### Finds bigger image versions online

![WebImageMaximizer](https://raw.github.com/AliFlux/WebImageMaximizer/master/examples/images/webimagesmaximizer.png)

## Introduction

A tiny PHP class to find bigger versions of images online. And also guess the name of any image. It's actually a hack, that makes use of Google Similar Image Search.

## Features

- Tiny size
- Zero dependencies
- Object-oriented usage
- Easy to use (1 function, returns in array)

## Installation

Just copy the [class.webimagemaximizer.php](class.webimagemaximizer.php) into your working path, where it is easily accessible by your PHP script.

## A Simple Example

```php
<?php
require_once("class.webimagemaximizer.php");

// url for any small image
$smallImage = "http://4.bp.blogspot.com/-V0A30kKCaKE/U9YgNkcnKzI/AAAAAAACV4I/4ECi9eQGxxY/s1600/borjkajpiza.jpg";

// $result will contain the images information
$result = webImageMaximizer::getRelatedImages($smallImage);

header('content-type: text/plain');

echo "Your image: " . $smallImage . "\n";
echo "Online search results: \n";
echo "\n";

print_r($result);
?>
```

You'll find plenty more to play with in the [examples](examples/) folder.

### Guessing game

You can use this class to make a tiny guessing game where people input their images and this class finds out the name of given image. Check out the [guessing game demo](examples/guessing-game.php).

### Augumented reality

To find out what an image infront of you actually means, you can make use of the `$result["guess"]` value.

## Note

- Since this class works on Google's *unofficial* API. Thing's might change unexpectedly.
- This class was made during a 2 hour *educational* hackathon. Don't use it in your proprietary code without checking Google's TOS.

## Contributing

Please submit bug reports, suggestions and pull requests to the [GitHub issue tracker](https://github.com/AliFlux/NaturalThreading/issues).
I would be happy if someone helps in expanding its functionality by adding more useful threading features such as joining threads and thread-pooling.

## License

This software is licenced under the [LGPL 2.1](http://www.gnu.org/licenses/lgpl-2.1.html). Please read LICENSE for information on the
software availability and distribution.
