<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',
    'vc_width' => 680,
    'vc_height' => 398,
    'vc_path' => public_path(). '/uploads/vehicle/colors/',

    'fc_width_1' => 400,
    'fc_height_1' => 600,

    'fc_width_2' => 543,
    'fc_height_2' => 300,

    'fc_width_3' => 268,
    'fc_height_3' => 300,

    'fc_path' => public_path(). '/uploads/vehicle/features/',

);
