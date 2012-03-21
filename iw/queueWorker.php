<?php
ob_start();
include(__DIR__.'/../lib/IronWorkerWrapper.php');
$config = parse_ini_file(__DIR__.'/../config.ini', true);
$url = $_REQUEST['url'];
$queue_name = $_REQUEST['queue_name'];
$name = "imageWorker.php";
$tmpdir = $_SERVER['TMP_DIR'];
if (empty($tmpdir)){
$tmpdir = dirname(__FILE__);
}
print_r($tmpdir);
$zipName = $tmpdir."/$name.zip";
$file = IronWorker::zipDirectory(dirname(__FILE__)."/../workers", $zipName, true);
$res = $iw->postCode('imageWorker.php', $zipName, $name);
print_r($res);
$payload = array(
    'iron_mq' => array(
        'token' => $config['iron_mq']['token'],
        'project_id' => $config['iron_mq']['project_id'],
    ),

    'image_url' => $url,
    'queue_name' => $queue_name
);

$task_id = $iw->postTask($name, $payload);
ob_end_clean();
echo $task_id;
?>
