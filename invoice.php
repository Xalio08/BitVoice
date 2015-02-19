<?php
//Get 
print_r($_GET);


$my_address = '1PyHmhotZJu4ULjnzQyCdEt8FAZBTe4Ywx';

$my_callback_url = 'http://localhost/BitVoice/invoice.php';

$root_url = 'https://blockchain.info/api/receive';

$parameters = 'method=create&address=' . $my_address .'&callback='. urlencode($my_callback_url);

$response = file_get_contents($root_url . '?' . $parameters);

$object = json_decode($response);

echo 'Send Payment To : ' . $object->input_address;

print_r($object);



function CallAPI($my_address,$my_callback_url, $data=false)
{
  $root_url = 'https://blockchain.info/api/receive';
  $parameters = 'method=create&address=' . $my_address .'&callback='. urlencode($my_callback_url);

  $final_url = $root_url . '?' . $parameters;

    $curl = curl_init();

    switch ($sMethod)
    {
        case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
?>