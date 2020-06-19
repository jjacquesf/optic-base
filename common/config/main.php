<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'banorte' => [
            'class' => 'frontend\\modules\\banorte\\components\\Banorte',
            'merchant_id' => '8373132', // Afiliacion
            'terminal_id' => '83731321', // Afiliacion
            'merchant_name' => 'OPTIC PT', // Nombre
            'merchant_city' => 'JAL',
            'cert_3d' => '03',
            'cert_3d_forward_path' => 'https://opticpt.com/index.php?r=banorte%2Fdefault%2F3d-secure-response&travel_id=',
            'mode' => 'AUT', // PRD, AUT, DEC, RND
            'pw_username' => 'a8373132',
            'pw_password' => 'jN4=h!3J\\',
        ],
    ],
];
