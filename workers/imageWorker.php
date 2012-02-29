<?php

require_once dirname(__FILE__) . "/lib/S3.php";
require_once dirname(__FILE__) . "/lib/IronMQ.class.php";

$args = getArgs();
$payload = $args['payload'];

// Download image.
$raw_image_content = file_get_contents($payload->image_url);
$url = $payload->image_url;
$file = substr($url,strrpos($url,'/'),strlen($url));
// Create a test source image for this example.
$im = imagecreatefromstring($raw_image_content);

$output_file = dirname(__FILE__)."/output.jpg";

// make thumb
$thumbWidth  = 100;
$width = imagesx( $im );
$height = imagesy( $im );

// calculate thumbnail size
$new_width = $thumbWidth;
$new_height = floor( $height * ( $thumbWidth / $width ) );

// create a new temporary image
$tmp_img = imagecreatetruecolor( $new_width, $new_height );

// copy and resize old image into new image 
imagecopyresized( $tmp_img, $im, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

// save thumbnail into a file
imagejpeg( $tmp_img, $output_file );
// Upload image.
$s3 = new S3($payload->s3->access_key, $payload->s3->secret_key);
$bucket = $payload->s3->bucket;

if ($s3->putObjectFile($output_file, $bucket, $file, S3::ACL_PUBLIC_READ)) {
$ironmq = new IronMQ(array(
    'token' => $payload->iron_mq->token,
    'project_id' => $payload->iron_mq->project_id
));
$ironmq->postMessage("output_queue", "https://$bucket.s3.amazonaws.com/$file");
}else{
    echo "File not uploaded!";
}

?>
