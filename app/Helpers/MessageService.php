<?php


namespace App\Helpers;


class MessageService
{

    const AUTH_KEY = "265094Ax4iz2OyViR5c76a738";
    const ROUTE = "route4";
    const SENDER_ID = "ALMOND";
    const API_URL = "http://api.msg91.com/api/sendhttp.php";
// Messages
    const OTP_MESSAGE = "Your OTP is ";

    public static function sendMessage($phoneNumber, $text) {
        $message = urlencode($text);
        $postData = array(
            'authkey' => self::AUTH_KEY,
            'mobiles' => $phoneNumber,
            'message' => $message,
            'sender' => self::SENDER_ID,
            'route' => self::ROUTE
        );

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => self::API_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);

        //Print error if any
        if(curl_errno($ch))
        {
            error_log('error:' . curl_error($ch));
        }
        curl_close($ch);
        error_log($output);
    }



}
