<?php

require('vendor/autoload.php');

$result = ['success'=>false,'url'=>'','message'=>'Invalid API parameters.'];

// this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = Aws\S3\S3Client::factory();
$bucket = getenv('S3_BUCKET');

if (!$bucket) {
    $result['message'] = 'No "S3_BUCKET" config var in found in env!';
}


if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['tempfile']) && isset($_GET['destfolder']) ) {

    $tempfile = $_GET['tempfile'];
    $destfolder = $_GET['destfolder'];

    if (!file_exists($tempfile)) {
        $result['message'] = "File doesn't exists: " . $tempfile;
    } else {

        try {
            $upload = $s3->upload($bucket, 'test.png'/*$destfolder*/, fopen($tempfile, 'rb'), 'public-read');
            $result['url'] = $upload->get('ObjectURL');
            $result['success'] = true;
            $result['message'] = 'OK';

        } catch(Exception $e) {
            $result['message'] = 'Upload error :'. $e->getMessage();
        }
    }
}

echo json_encode($result);
