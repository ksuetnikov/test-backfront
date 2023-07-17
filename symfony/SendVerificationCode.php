<?php

use  App\Repository\SettingParameters;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class RequestData {
    public $phone_number, $region;
}

function send_verification_code($sPD) {
    //$sPD = "tel=+79999999999";
    $sURL = "http://gettelephonecode.com/Examples/http-post.php";
    $aHTTP = array(
        'http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $sPD
            )
    );
    $context = stream_context_create($aHTTP);
    $contents = file_get_contents($sURL, false, $context);
    if (!$contents) {
        return false;
    }
    $phone_number = $contents['phone_number'];
    $phone_number = $settings->getPhoneNumber($phone_number);
    if (!$phone_number) {
        return false;
    }
    $date = date('Y-m-d H:i:s');
    $minutes_to_add = 5;
    $time = new DateTime($date);
    $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
    $verification_code_expiry_time = $time->format('Y-m-d H:i:s');

    $provider = get_communication_provider();
    $message_status_callback = $settings->TWILIO_MESSAGE_STATUS_CALLBACK;
    $res = send_verification_code_sms(
       $provider, $phone_number, 4, $verification_code_expiry_time, $message_status_callback
    );
    if (!res["success"]){
        invalidate_verification_code($res["verification_code"]["code"])}
        return error_response("Failed to send verification SMS");
    return success_response($phone_number);
}


function send_verification_code_sms ($provider, $phone_number, $verification_code_length,$verification_code_expiry_time, $callback ) {
//Отправляем смс код
    $verification_code = create_verification_code($phone_number, $verification_code_expiry_time, $verification_code_length);
    $verification_message = get_verification_code_sms_message($verification_code);
    $success = $provider->send_sms($phone_number, $verification_message, $callback);
    return $verification_code;
}

function get_verification_code_sms_message($verification_code)
    {
    return "Your verification code is".$verification_code;
    }
