<?php



function verify_phone_number($request){
    $request_data = get_request_data($request);
    if (!$request_data)
        return "Missing or invalid data";

    $date = date('Y-m-d H:i:s');
    $active_codes = get_active_verification_codes_for_phone_number($request_data["phone_number"], $date);
    $is_valid_code = in_array($active_codes, $request_data["verification_code"]);
    if (!$is_valid_code)
        return "Invalid verification code";


    $created = get_or_create_user($request_data["phone_number"])["created"];
    $user = get_or_create_user($request_data["phone_number"])["user"];
    if (!$created)
        return "Generating refresh token for existing user";

    $refresh_token = generate_and_record_refresh_token($user, $date);
   $token_payload = generate_access_token_for_user(
    $user["user_id"], $date
)["payload"];
    $access_token = generate_access_token_for_user(
        $user["user_id"], $date
    )["access"];
    $expiry_time = $token_payload["exp"];
    return ResponseData(
         $refresh_token, $access_token, $expiry_time
    );
}


