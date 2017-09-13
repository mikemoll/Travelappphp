<?php

include_once 'AbstractController.php';

class TravelertypeController extends AbstractController {

    public static function move_to_aws($dest) {
        $url = HTTP_HOST.'/aws/aws_upload_api.php' .
                         '?tempfile=' . urlencode($dest) .
                         '&destfolder=' . urlencode($dest);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = json_decode(curl_exec($ch));
        curl_close($ch);
        return $result;
    }

}