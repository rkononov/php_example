<?php
include(__DIR__.'/../lib/IronMQWrapper.php');
$url = $_REQUEST['url'];
$res = $ironmq->postMessage("input_queue", array("body" => $url));
echo("Message posted");
?>
