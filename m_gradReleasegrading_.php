<?php
// --- cURL Function ---
include "m_curlFunction_.php";

/*RECEIVE DATA FROM POST REQUEST*/
$indata = file_get_contents("php://input");

//Back Server URL
$url = "https://web.njit.edu/~pio3/CS490/grading/releasegrades.php";

echo http_post_back_server($url,$indata);

?>
