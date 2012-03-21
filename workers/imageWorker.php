<?php

require_once dirname(__FILE__) . "/lib/Imgur.php";
require_once dirname(__FILE__) . "/lib/IronMQ.class.php";

$args = getArgs();

print_r($args);

$payload = $args['payload'];

// Download image.
$raw_image_content = file_get_contents($payload->image_url);
$url = $payload->image_url;
$file = substr($url, strrpos($url, '/'), strlen($url));
// Create a test source image for this example.
$im = imagecreatefromstring($raw_image_content);

$output_file = dirname(__FILE__) . "/output";

// make thumb
$thumbWidth = 100;
$width = imagesx($im);
$height = imagesy($im);

// calculate thumbnail size
$new_width = $thumbWidth;
$new_height = floor($height * ($thumbWidth / $width));

// create a new temporary image
$tmp_img = imagecreatetruecolor($new_width, $new_height);

// copy and resize old image into new image 
imagecopyresized($tmp_img, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
// save thumbnail into a file
imagejpeg($tmp_img, $output_file . '.jpg');
// Upload image.
$link = upload_file($output_file . '.jpg');

//rotate thumbnail
$degrees = 180;
$rotated_thumbnail = imagerotate($tmp_img, $degrees, 0);
// save rotated thumbnail into a file
imagejpeg($rotated_thumbnail, $output_file . '_rotated.jpg');
// Upload rotated image.
$link_rotated = upload_file($output_file . '_rotated.jpg');

//grayscale thumbnail
imagefilter($tmp_img, IMG_FILTER_GRAYSCALE);
// save grayscale thumbnail into a file
imagejpeg($tmp_img, $output_file . '_grayscale.jpg');
// Upload grayscale image.
$link_grayscale = upload_file($output_file . '_grayscale.jpg');

$links = array("thumbnail" => $link, "rotated" => $link_rotated, "grayscale" => $link_grayscale,"task_id" => $args['task_id']);

$ironmq = new IronMQ(array(
    'token' => $payload->iron_mq->token,
    'project_id' => $payload->iron_mq->project_id
));
$ironmq->postMessage($payload->queue_name, json_encode($links));
?>