<?php

abstract class CurlRequest {
    public function getsmth($mobile)
    {
        $message ='Your message';
        $url = 'www.your-domain.com/api.php?to='.$mobile.'&text='.$message;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);
        $err = curl_error($ch);
        curl_close ($ch);
        return $response;
    }
}
