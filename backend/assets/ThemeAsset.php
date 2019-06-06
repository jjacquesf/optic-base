<?php

namespace backend\assets;

use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle
{
    public $css = [];

    public $js = [];

    public $depends = [
        'yiister\gentelella\assets\Asset',
        'backend\assets\GentelellaPlugins',
    ];

}
