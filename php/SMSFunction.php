<?php
    use Twilio\Rest\Client;

    function SendSMS($number,$sms_message){
        require '../vendor/autoload.php';

        //Send SMS
        $account_id = "AC57954df91c6c98ce6035bc08546d6e12";
        $auth_token = "628077c59c3722d19f52c8601e179b03";

        $client = new Twilio\Rest\Client($account_id, $auth_token);
        $client->messages->create(
        $number, // Text this number
            [
                'from' => '+17164577755', // From a valid Twilio number
                'body' => $sms_message
            ]
        );
    }
?>