<?php
//---- IMPORTING CURL FUNCTION ---
include "m_curlFunction_.php";

/*RECEIVE DATA FROM POST REQUEST*/
$indata = file_get_contents("php://input");

//---- CONTACTING BACK SERVER ----
$url = "https://web.njit.edu/~pio3/CS490/loginquery.php";

echo http_post_back_server($url, $indata);

?>