<?php

function send($type, $cookie, $id = null){
    $url = "https://api.sgb.ooo/ig/$type.php?cookie=$cookie";
    $url .= ($id) ? "&id=$id" : "";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response);
}

echo "+++ Auto Delete All DM Instagram +++\n";
$cookie = urlencode(readline("Cookie: "));
echo "Getting List DM ... ";
$list = send('dm', $cookie);
echo "[DONE]\n";
$sleep = readline("Sleep: ");

foreach ($list as $id) {
    $delete = send('delete', $cookie, $id);
    if($delete->status === "ok"){
        echo "$id [SUCCESS]\n";
    }else{
        echo "$id [FAIL]\n";
    }
    echo "Sleep $sleep seconds ...\n";
    sleep($sleep);
}
