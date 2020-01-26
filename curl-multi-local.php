<?php

$hosts_local = 'hosts_local.txt';

$hosts_local = file_get_contents($hosts_local);

// clean white space at the end and normalize to spaces
$hosts_input = trim(str_replace("\t",' ',$hosts_input));
$hosts_lines = explode("\n", $hosts_input);
$request_urls = array();
foreach ($hosts_lines as $hosts_line)
{
  // fields should be separated by spaces at this point
  $hosts_fields = explode(' ', $hosts_line);
  // trim any leftover whitespace and grab domain name
  $hosts_name = trim($hosts_field[1]);
  // trim any leftover whitespace and grab ip address
  $hosts_ip = trim($hosts_field[0]);
  if ((filter_var('mail@' . $hosts_name, FILTER_VALIDATE_EMAIL))&&(str_replace('.','',$hosts_ip) > 0)&&(filter_var($hosts_ip, FILTER_VALIDATE_IP)))
  {
    // the key will be the hosts name and the value is the ip address
    $request_urls[$hosts_name] = $hosts_ip;
  }
}

// create both cURL resources
$ch1 = curl_init();
$ch2 = curl_init();

// set URL and other appropriate options
curl_setopt($ch1, CURLOPT_URL, "http://example.com/");
curl_setopt($ch1, CURLOPT_HEADER, 0);
curl_setopt($ch2, CURLOPT_URL, "http://www.php.net/");
curl_setopt($ch2, CURLOPT_HEADER, 0);

//create the multiple cURL handle
$mh = curl_multi_init();

//add the two handles
curl_multi_add_handle($mh,$ch1);
curl_multi_add_handle($mh,$ch2);

//execute the multi handle
do {
    $status = curl_multi_exec($mh, $active);
    if ($active) {
        // Wait a short time for more activity
        curl_multi_select($mh);
    }
} while ($active && $status == CURLM_OK);

//close the handles
curl_multi_remove_handle($mh, $ch1);
curl_multi_remove_handle($mh, $ch2);
curl_multi_close($mh);

?>