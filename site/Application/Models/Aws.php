<?php

class Aws {

    const BASE_AWS_URL = 'https://s3.amazonaws.com/tumbleweed-files/app/site/';

    public static function moveToAWS($dest) {
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

    // I opted to do not do this because it would be very slow to check in another server, we probably won't use this.
    // public static function fileExists($dest) {
    //     $url = HTTP_HOST.'/aws/aws_file_exists_api.php' .
    //                      '?file=' . urlencode($dest);
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    //     $result = curl_exec($ch);
    //     curl_close($ch);
    //     return $result == 'true';
    // }
}