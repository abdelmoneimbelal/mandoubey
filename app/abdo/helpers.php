<?php

function responseJson($status, $message, $data = null)
{
    $response = [
        'status' => $status,
        'message' => $message,
        'data' => $data
    ];
    return response()->json($response);
}


function notifyByFirebase($title, $body, $tokens, $data = [])        // paramete 5 =>>>> $type
{
    $registrationIDs = $tokens;

// prep the bundle
// to see all the options for FCM to/notification payload:
// https://firebase.google.com/docs/cloud-messaging/http-server-ref#notification-payload-support

// 'vibrate' available in GCM, but not in FCM
    $fcmMsg = array(
        'body' => $body,
        'title' => $title,
        'sound' => "default",
        'color' => "#203E78"
    );
    $fcmFields = array(
        'registration_ids' => $registrationIDs,
        'priority' => 'high',
        'notification' => $fcmMsg,
        'data' => $data
    );

    $headers = array(
        'Authorization: key=' . env('FIREBASE_API_ACCESS_KEY'),
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
    $result = curl_exec($ch);
    curl_close($ch);
//    return $result;
}