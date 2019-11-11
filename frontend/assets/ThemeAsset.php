<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle
{
    public $sourcePath = '@app/../gulp/frontend/public/assets';
    public $basePath = '@webroot';
    public $css = [
        '//use.fontawesome.com/releases/v5.0.13/css/all.css',
        // '//fonts.googleapis.com/css?family=Raleway:400,600,700',
        'vendor.css',
        'main.css',
    ];
    public $js = [
        'vendor.js',
        'main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
