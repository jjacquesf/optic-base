<?php

namespace backend\assets;

use yii\web\AssetBundle;

class GentelellaPlugins extends AssetBundle
{
    public $sourcePath = '@bower/gentelella/vendors/';

    public $css = [
    	'bootstrap-daterangepicker/daterangepicker.css',
    ];
    
    public $js = [
        'moment/min/moment.min.js',
        'moment/locale/es.js',
        'bootstrap-daterangepicker/daterangepicker.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}