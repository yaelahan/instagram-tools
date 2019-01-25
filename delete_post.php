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
echo "+++ Auto Delete All Post Instagram +++\n";
$cookie = urlencode(readline("Cookie: "));
$sleep = readline("Sleep: ");

proccess:
echo "Getting List Post ... ";
$list = send('feed_user', $cookie);
echo "[DONE]\n";
foreach ($list->media_ids as $id) {
    $delete = send('delete_post', $cookie, $id);
    if($delete->status === "ok"){
        echo "$id [SUCCESS]\n";
    }else{
        echo "$id [FAIL]\n";
    }
    echo "Sleep $sleep seconds ...\n";
    sleep($sleep);
}

if ($list->next_max_id !== null) 
    goto proccess;
