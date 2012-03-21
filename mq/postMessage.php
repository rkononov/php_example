<?php
include(__DIR__.'/../lib/IronMQWrapper.php');
$url = $_REQUEST['url'];
$queue_name = $_REQUEST['queue_name'];
$res = $ironmq->postMessage($queue_name, array("body" => $url));
echo("Message posted");
?>
