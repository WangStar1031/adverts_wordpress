<?php

$_imgUrl = "";
if(isset($_GET['imgUrl'])) $_imgUrl = $_GET['imgUrl'];
if(isset($_POST['imgUrl'])) $_imgUrl = $_POST['imgUrl'];

if( $_imgUrl == ""){
	$response = array(
		"status" => 'error',
		"message" => 'There is no image url.',
	);
	print json_encode($response);
	exit();
}
$imgPath = __DIR__ . "/temp/" . basename($_imgUrl);
if( !file_exists($imgPath)){
	$response = array(
		"status" => 'error',
		"message" => 'There is no image file.',
	);
	print json_encode($response);
	exit();
}

$path_parts = pathinfo($imgPath);
$type = $path_parts['extension'];

if( $type ==  'jpeg') $type = 'jpg';
$_imgInitW = 0;
if(isset($_GET['imgInitW'])) $_imgInitW = intval( $_GET['imgInitW']);
if(isset($_POST['imgInitW'])) $_imgInitW = intval( $_POST['imgInitW']);
$_imgInitH = 0;
if(isset($_GET['imgInitH'])) $_imgInitH = intval( $_GET['imgInitH']);
if(isset($_POST['imgInitH'])) $_imgInitH = intval( $_POST['imgInitH']);
$_imgW = 0;
if(isset($_GET['imgW'])) $_imgW = intval( $_GET['imgW']);
if(isset($_POST['imgW'])) $_imgW = intval( $_POST['imgW']);
$_imgH = 0;
if(isset($_GET['imgH'])) $_imgH = intval( $_GET['imgH']);
if(isset($_POST['imgH'])) $_imgH = intval( $_POST['imgH']);
$_objW = 0;
if(isset($_GET['objW'])) $_objW = intval( $_GET['objW']);
if(isset($_POST['objW'])) $_objW = intval( $_POST['objW']);
$_objH = 0;
if(isset($_GET['objH'])) $_objH = intval( $_GET['objH']);
if(isset($_POST['objH'])) $_objH = intval( $_POST['objH']);
$_imgX1 = 0;
if(isset($_GET['imgX1'])) $_imgX1 = intval( $_GET['imgX1']);
if(isset($_POST['imgX1'])) $_imgX1 = intval( $_POST['imgX1']);
$_imgY1 = 0;
if(isset($_GET['imgY1'])) $_imgY1 = intval( $_GET['imgY1']);
if(isset($_POST['imgY1'])) $_imgY1 = intval( $_POST['imgY1']);
$_cropW = 0;
if(isset($_GET['cropW'])) $_cropW = intval( $_GET['cropW']);
if(isset($_POST['cropW'])) $_cropW = intval( $_POST['cropW']);
$_cropH = 0;
if(isset($_GET['cropH'])) $_cropH = intval( $_GET['cropH']);
if(isset($_POST['cropH'])) $_cropH = intval( $_POST['cropH']);
$_rotation = 0;
if(isset($_GET['rotation'])) $_rotation = $_GET['rotation'];
if(isset($_POST['rotation'])) $_rotation = $_POST['rotation'];
if( $_imgInitW == 0 || $_imgInitH == 0 || $_imgW == 0 || $_imgH == 0 || $_cropH == 0 || $_cropW == 0){
	$response = array(
		"status" => 'error',
		"message" => 'Invalid parameter.',
	);
	print json_encode($response);
	exit();
}

switch($type){
	case 'bmp': $_imgSrc = imagecreatefromwbmp($imgPath); break;
	case 'gif': $_imgSrc = imagecreatefromgif($imgPath); break;
	case 'jpg': $_imgSrc = imagecreatefromjpeg($imgPath); break;
	case 'png': $_imgSrc = imagecreatefrompng($imgPath); break;
	default : $_imgSrc = false; break;
}

if( $_imgSrc == false){
	$response = array(
		"status" => 'error',
		"message" => 'Source Image Error.',
	);
	print json_encode($response);
	exit();
}

$_imgDst = imagecreatetruecolor($_cropW, $_cropH);

$_scaleW = floatval($_imgInitW / $_imgW);
$_scaleH = floatval($_imgInitH / $_imgH);

// $_scaleW = floatval($_imgInitW / $_imgW);
// $_scaleH = floatval($_imgInitH / $_imgH);
$_posX = intval( $_imgX1 * $_scaleW);
$_posY = intval( $_imgY1 * $_scaleH);
$_srcW = intval( $_objW * $_scaleW);
$_srcH = intval( $_objH * $_scaleH);

if( !imagecopyresampled($_imgDst, $_imgSrc, 0, 0, $_posX, $_posY, $_cropW, $_cropH, $_srcW, $_srcH)){
	$response = array(
		"status" => 'error',
		"message" => 'Error on cropping image.'
	);
	print json_encode($response);
	exit();
}


$dstImgPath = __DIR__ . "/temp/" . $path_parts['filename'] . "_crop." . $type;

$_imgLogo = imagecreatefrompng(__DIR__ . "/img/logo.png");
$margin_right = 10;
$margin_bottom = 10;
$sx = imagesx($_imgLogo);
$sy = imagesy($_imgLogo);
$left = $margin_right; //imagesx($_imgDst) - $sx - $margin_right;
$top = $margin_bottom; //imagesy($_imgDst) - $sy - $margin_bottom;
imagecopy($_imgDst, $_imgLogo, $left, $top, 0, 0, $sx, $sy);

switch($type){
	case 'bmp': $retVal = imagewbmp( $_imgDst, $dstImgPath); break;
	case 'gif': $retVal = imagegif( $_imgDst, $dstImgPath); break;
	case 'jpg': $retVal = imagejpeg( $_imgDst, $dstImgPath); break;
	case 'png': $retVal = imagepng( $_imgDst, $dstImgPath); break;
	default : $retVal = false; break;
}

$prefix = "";
switch($type){
	case 'bmp': $prefix = "data:image/bmp;base64,"; break;
	case 'gif': $prefix = "data:image/gif;base64,"; break;
	case 'jpg': $prefix = "data:image/jpg;base64,"; break;
	case 'png': $prefix = "data:image/png;base64,"; break;
	default : $prefix = ""; break;
}
// "data:image/png;base64,"
if( $prefix == ""){
	$response = array(
		"status" => 'error',
		"message" => "type error."
	);
} else{
	// ob_start();
	// switch($type){
	// 	case 'bmp': imagewbmp($_imgDst); break;
	// 	case 'gif': imagegif($_imgDst); break;
	// 	case 'jpg': imagejpeg($_imgDst); break;
	// 	case 'png': imagepng($_imgDst); break;
	// 	// default : $prefix = ""; break;
	// }
	// $contents =  ob_get_contents();
	// ob_end_clean();
	$response = array(
		"status" => 'success',
		// "url" => $prefix . base64_encode($contents),
		"url" => $baseDir = dirname($_SERVER['REQUEST_URI']) . "/temp/" . $path_parts['filename'] . "_crop." . $type,
		"width" => $_cropW,
		"height" => $_cropH,
		"dstImgPath" => $dstImgPath,
		"_posX" => $_posX,
		"_posY" => $_posY,
		"_srcW" => $_srcW,
		"_srcH" => $_srcH,
		"scaleX" => $_scaleW,
		"scaleY" => $_scaleH
	);
}
print json_encode($response);
?>