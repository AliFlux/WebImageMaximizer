<?php

class WebImageMaximizer
{
	public static function getRelatedImages($img)
	{

		// URL string for Google Images
		$requestURL = "https://www.google.com/searchbyimage?image_url=" . urlencode($img) . "&encoded_image=&image_content=&filename=&hl=en&bih=554&biw=1920";
		$contents = self::getRemoteContents($requestURL);

		// Use FirePath extension of Firebug for Firefox, to check out Xpaths
		list($DD, $xp) = self::getHtmlXPath($contents);

		// Meta tags for finding different relatives.
		$metaTags = $xp->evaluate("//div[@class='rg_meta']");

		$relatives = array();
		$i = 0;
		foreach($metaTags as $v) {

			$json = $metaTags->item($i)->nodeValue;
			$result = json_decode($json, true);

			array_push($relatives, array(
				"title" => $result["pt"],
				"image_url" => $result["ou"],
				"thumb_url" => $result["tu"],
				"webpage" => $result["ru"], 
				"size" => array(
					"width" => $result["ow"],
					"height" => $result["oh"],
				),
			));

			$i++;
		}

		usort($relatives, "WebImageMaximizer::imageResolutionSort");

		// Thumbnail tags for finding different versions
		$thumbTags = $xp->evaluate("//a[contains(@href,'imgrefurl')]/img");

		$versions = array();
		$i = 0;
		foreach($thumbTags as $v) {

			$parts = array();
			$query = $thumbTags->item($i)->parentNode->getAttribute("href");
			parse_str($query, $parts);

			array_push($versions, array(
				"image_url" => $parts["http://www_google_com/imgres?imgurl"],
				"webpage" => $parts["imgrefurl"], 
				"size" => array(
					"width" => $parts["w"],
					"height" => $parts["h"],
				),
			));

			$i++;
		}

		usort($versions, "WebImageMaximizer::imageResolutionSort");

		$biggestVersion = "";
		if(sizeof($versions) > 0) {
			// these 3 lines could be further optimized.
			$biggestVersion = $versions[0]["image_url"];
		}

		$biggestRelative = "";
		if(sizeof($relatives) > 0) {
			$biggestRelative = $relatives[0]["image_url"];
		}

		// guess the title of this image
		$guessTags = $xp->evaluate("//div[contains(text()[1],'guess')]/a");

		$guess = "";
		if($guessTags->length > 0) {
			$guess = $guessTags->item(0)->nodeValue;
		}

		// return everything
		$return = array(
			"guess" => $guess,						// string, title
			"biggestVersion" => $biggestVersion,	// string, url
			"biggestRelative" => $biggestRelative,	// string, url
			"versions" => $versions, 				// array, [image_url, webpage, size: [width, height]]
			"relatives" => $relatives, 				// array, [title, image_url, thumb_url, webpage, size: [width, height]]
		);

		return $return;
	}

	// sort image array by its resolution
	private static function imageResolutionSort($a, $b)
	{
		$resA = $a["size"]["width"] * $a["size"]["height"];
		$resB = $b["size"]["width"] * $b["size"]["height"];
	    if ($resA == $resB) {
	        return 0;
	    }
	    return ($resA < $resB) ? 1 : -1;
	}

	// get *HTML* Xpath
	public static function getHtmlXPath($contents)
	{
		$contents = mb_convert_encoding($contents, 'HTML-ENTITIES', "UTF-8");
		$xmlDoc = new DOMDocument();
		@$xmlDoc->loadHTML($contents);
		$xpath = new DOMXPath($xmlDoc);
		return array($xmlDoc, $xpath);
	}

	// grab page contents
	public static function getRemoteContents($url)
	{
		$ch = curl_init();
		$timeout = 8;
		// Disguise as a firefox browser
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0");
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, 3);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

}

?>