<?php

use yii\helpers\Html;
use backend\assets\ThemeAsset;
$assets = ThemeAsset::register($this);

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VehicleTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tipos de vehículos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-type-index">

    <div class="page-title">
        <div class="title_left">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="title_right text-right">
            <?= Html::a('<i class="fa fa-chevron-left"></i> Regresar', 'javascript:history.back();', ['btn btn-link']); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="x_panel">
            <div class="x_title">

            </div>
            <div class="x_content">
                <p class="text-left">
                    <?= Html::a(Yii::t('app', 'Agregar'), ['create'], ['class' => 'btn btn-info pull-right']) ?>
                </p>

                                                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                
                                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
        'columns' => [
                            // ['class' => 'yii\grid\SerialColumn'],

                            // 'id',
            'name',
            'max_passangers',
            'max_bags',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}',
                            ],
                        ],
                    ]); ?>
                
                
            </div>
        </div>
    </div>

</div>
