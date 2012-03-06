<?
  function upload_file($file_name)
   {
    $handle = fopen($file_name, "r");
    $data = fread($handle, filesize($file_name));
    $pvars   = array('image' => base64_encode($data), 'key' => "b3625162d3418ac51a9ee805b1840452");
    $timeout = 30;
    $curl    = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://api.imgur.com/2/upload.xml');
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
    $xml = curl_exec($curl);
    curl_close ($curl);
    $element_name = "original";
    preg_match('#<'.$element_name.'(?:\s+[^>]+)?>(.*?)</'.$element_name.'>#s', $xml, $matches);
    return $matches[1];
   }
?>
