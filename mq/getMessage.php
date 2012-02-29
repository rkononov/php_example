<?php
include(__DIR__.'/../lib/IronMQWrapper.php');
$queue_name = $_REQUEST['queue_name'];
$message = $ironmq->getMessage($queue_name);
if (!empty($message))
{
$ironmq->deleteMessage($queue_name,$message->id);
echo($message->body);
}
?>
