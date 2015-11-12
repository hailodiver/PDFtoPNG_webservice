<?php
//PDF to PNG
if(isset($_GET['debug'])){
	echo '<pre>
	"ACTION->key[payload description](default)"
	POST->image[base64 encoded pdf](local out.pdf test)
	GET->format[png jpg eps etc.](png)
	GET->show[](prints image header for browser display if present)
	GET->debug[](prints debug info if present)
	GET->dpi[a number](300)
	</pre>';
}
$image = new Imagick();
$dpi = 300;
if(isset($_GET['dpi'])){
	$dpi = (float)$_GET['dpi'];
}
$image->setResolution($dpi,$dpi);
if(isset($_POST['image'])){
	$decoded = base64_decode($_POST['image']);
	$image->readimageblob($decoded);
}else{
	if(isset($pdftopng)){
		//todo include pdftopng inline rather than utilizing as a webservice//
	        $image->readImage($pdftopng);
	}else{
	        $myurl='out.pdf';
	        $image->readImage($myurl);
	};
}
$format = "png";
if(isset($_GET['format'])){
	$format = (string)$_GET['format'];
}
if(isset($_GET['show'])){
	header("Content-Type: image/".$format);
}
$image->setImageFormat($format); 
echo $image->getImageBlob(); 
die;
?>
