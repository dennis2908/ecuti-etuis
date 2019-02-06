<?php

return array(

    'pdf' => array(
        'enabled' => true,
        'binary' => strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? storage_path('vendor/wkhtml/bin/wkhtmltopdf.exe') : base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? storage_path('vendor/wkhtml/bin/wkhtmltoimage.exe') : base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltoimage-amd64'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
