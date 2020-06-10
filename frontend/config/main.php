<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'es',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => ['@app/themes/main'],
                    // '@common/modules' => ['@app/themes/main/modules']
                    // '@vendor/yii2mod/yii2-user/views' => '@app/themes/main/user'
                ],
                'baseUrl' => '@web',
            ],
        ],
        'paypalEC' => [
            'class' => 'common\components\paypal\ExpressCheckout',
            'business_account' => 'director@opticpt.com',
            'currency_code' => 'USD',
            'sandbox' => false,
            'ipn_url' => 'http://opticpt.com/index.php?r=site/paypal-ipn',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
