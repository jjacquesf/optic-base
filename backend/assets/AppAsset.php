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
        '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css',
    ];
    public $js = [
        // '//cdn.jsdelivr.net/npm/vue/dist/vue.js',
        // '//cdn.jsdelivr.net/npm/vue-resource@1.5.1',
        '//cdnjs.cloudflare.com/ajax/libs/mustache.js/3.0.1/mustache.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js',
        'js/nano.js',
        'js/main.js'
    ];
    public $depends = [
        'backend\assets\ThemeAsset',
    ];
}
