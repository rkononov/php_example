<?php
include(__DIR__.'/../lib/IronWorkerWrapper.php');
$config = parse_ini_file(__DIR__.'/../config.ini', true);
$url = $_REQUEST['url'];
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
    's3' => array(
        'access_key' => $config['s3']['access_key'],
        'secret_key' => $config['s3']['secret_key'],
        'bucket'     => $config['s3']['bucket'],
    ),
    'iron_mq' => array(
        'token' => $config['iron_mq']['token'],
        'project_id' => $config['iron_mq']['project_id'],
    ),

    'image_url' => $url
);

$task_id = $iw->postTask($name, $payload);
echo "Task posted";
?>
