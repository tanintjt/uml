<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => true,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAVkAD3sU:APA91bEkAlGmcRQIRaT_wII1EwXZOFyLD5hFNq6gRPkf18oz_Oy_-7AlG6WBL8deY2jUuYjXWsuE4LrgfSG5hCbyIu13G8N-s4d8zk8jDtq4B8M67Fw7Vu51Jssfidm6DX18fq772I-N'),
        'sender_id' => env('FCM_SENDER_ID', '370441182917'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
