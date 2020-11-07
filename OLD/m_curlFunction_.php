<?php

//------------------- cURL Function ------------------------------

function http_post_back_server($url, $data)
{
	$obj = curl_init();

	curl_setopt($obj, CURLOPT_URL, $url);
	//curl_setopt($obj, CURLOPT_POST, strlen($data));
	curl_setopt($obj, CURLOPT_POST, true);
	curl_setopt($obj, CURLOPT_POSTFIELDS, $data);
 	curl_setopt($obj, CURLOPT_RETURNTRANSFER, true);

	$ans = curl_exec($obj);

	curl_close($obj);

	return $ans;
}

?>
