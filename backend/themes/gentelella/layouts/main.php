<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use common\modules\store\models\Order;
use yii\helpers\Html;

$bundle = yiister\gentelella\assets\Asset::register($this);

$this->registerCss('@media print { a:after { content: "" !important;  } }');

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style type="text/css">
        .d-none {
            display: none;
        }
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >
<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">

        <?php if(!Yii::$app->user->isGuest): ?>
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="/" class="site_title">
                            <i class="fa fa-users"></i>
                            <span><?= Yii::$app->name; ?></span>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3>General</h3>
                            <?php

                            ?>
                            <?=
                            \yiister\gentelella\widgets\Menu::widget(
                                [
                                    'items' => [
                                        [
                                            'label' => Yii::t('app', 'Home'), 
                                            'url' => '/', 'icon' => 'home'
                                        ],
                                        
                                        [
                                            'label' => Yii::t('app', 'Zonas'), 
                                            'url' => ['/zone/index'], 'icon' => 'home'
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Vehículos'), 
                                            'url' => ['/vehicle/index'], 'icon' => 'home'
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Tipos de vehículos'), 
                                            'url' => ['/vehicle-type/index'], 'icon' => 'home'
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Amenidades'), 
                                            'url' => ['/service/index'], 'icon' => 'home'
                                        ],
                                    ],
                                ]
                            )
                            ?>
                        </div>

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <?= Html::a('<span class="glyphicon glyphicon-off" aria-hidden="true"></span>', ['site/logout'], [
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data-method' => 'post',
                                'title' => 'Salir',
                                'style' => 'width: 100%;',
                                'class' => 'text-right',
                            ]); ?>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav hidden-print">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                    </nav>
                </div>
            </div>
            <!-- /top navigation -->
        <?php endif; ?>

        <!-- page content -->
        <div class="right_col" role="main">
            <?php if (isset($this->params['h1'])): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="clearfix"></div>
            <?= $content ?>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Panel adminsitrativo.<br />
                Creado por <a href="https://www.eskalon.com" rel="nofollow" target="_blank">Eskalon Network</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>