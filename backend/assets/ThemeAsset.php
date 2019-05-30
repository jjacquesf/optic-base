<?php

namespace backend\assets;

use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/theme';
    public $css = [
        '//use.fontawesome.com/releases/v5.0.13/css/all.css',
        '//fonts.googleapis.com/css?family=Roboto:300,400,700,900',
        'vendor.css',
        'main.css',
    ];
    public $js = [
        // 'vendor.js',
        // 'main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
