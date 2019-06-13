<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'js/clockpicker/jquery-clockpicker.min.css',
    ];
    public $js = [
        // '//cdn.jsdelivr.net/npm/vue/dist/vue.js',
        // '//cdn.jsdelivr.net/npm/vue-resource@1.5.1',
        '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/es.js',
        '//cdnjs.cloudflare.com/ajax/libs/mustache.js/3.0.1/mustache.min.js',
        'js/clockpicker/jquery-clockpicker.min.js',
        'js/followWhen.js',
        'js/jquery.blockUI.js',
        'js/nano.js',
        'js/main.js'
    ];
    public $depends = [
        'backend\assets\ThemeAsset',
    ];
}
