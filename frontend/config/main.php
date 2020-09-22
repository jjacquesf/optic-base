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
    'sourceLanguage' => 'es',
    'modules' => [
        'banorte' => [
            'class' => 'frontend\\modules\\banorte\\Module',
        ],
    ],
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                // 'categoria/<cat_id:\d+>/<cat_alias:[a-z|0-9|-]+>/<sc_id:\d+>/<sc_alias:[a-z|0-9|-]+>' => 'catalog/default/index',
                // 'categoria/<cat_id:\d+>/<cat_alias:[a-z|0-9|-]+>' => 'catalog/default/index',
                // 'producto/<id:\d+>/<alias:[a-z|0-9|-]+>/<brand:[a-z|0-9|-]+>/<sku:[a-z|0-9|-]+>' => 'catalog/default/product',
                // 'producto/<id:\d+>/<alias:[a-z|0-9|-]+>' => 'catalog/default/product',
                // 'marcas' => 'catalog/default/brands',
                // 'marca/<store_id:\d+>/<alias:[a-z|0-9|-]+>' => 'catalog/default/brand',

                // 'productos' => '/product/index',
                // 'producto/<id:\d+>/<alias:[a-z|0-9|-]+>' => '/product/view',
                // 'marca/<store_id:\d+>/<alias:[a-z|0-9|-]+>' => '/product/index',
                // 'categoria/<cat_id:\d+>/<alias:[a-z|0-9|-]+>' => '/product/index',
                // // 'marca/<store_id:\d+>' => '/product/index',
                // // 'categoria/<cat_id:\d+>' => '/product/index',


                // 'carrito' => '/sale/cart',
                // 'mis-pedidos/<id:\d+>/<reference:[a-z|0-9|-]+>/<status:[a-z|0-9|-]+>' => '/sale/view',
                // 'mis-pedidos/<id:\d+>/<reference:[a-z|0-9|-]+>' => '/sale/view',
                // 'mis-pedidos' => '/sale/index',
                // 'perfil' => '/site/profile',
                // 'crear-una-cuenta' =>  '/site/signup',
                
                // 'nosotros' => '/site/about',
                // 'contacto' => '/site/contact',
                // 'pedidos-especiales' => '/site/special-order',
                // 'nuestras-raices' => '/site/origins',
                // 'preguntas-frecuentes' => '/site/faq',
                // 'terminos-y-condiciones' => '/site/terms',
                // 'condiciones-de-venta' => '/site/sales-terms',
                // 'politica-de-privacidad' => '/site/privacy',


                // 'mi-tienda/entrar' => '/store/default/login',
                // 'mi-tienda/productos' => '/store/product/index',
                // 'registrar-mi-tienda' => '/store/default/signup',

                // 'file/<id:\d+>' => 'file/show',
                // '<alias:\w+>' => '/site/<alias>',
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
