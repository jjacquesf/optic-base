<?php

use yii\helpers\Html;
use backend\assets\ThemeAsset;
$assets = ThemeAsset::register($this);

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VehicleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Vehículos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicle-index">

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
                            // 'status',
                            [
                                'class' => 'yii\grid\DataColumn',
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => function($model, $key, $index, $column){
                                  return $model->getFormatted('status');
                                },
                            ],
                            [
                                'class' => 'yii\grid\DataColumn',
                                'attribute' => 'vehicle_type_id',
                                'format' => 'raw',
                                'value' => function($model, $key, $index, $column){
                                  return $model->getFormatted('vehicle_type');
                                },
                            ],
                            // 'vehicle_type_id',
                            'plate',
                            'model',
                            //'color',
                            //'default_operator_id',
                            [
                                'class' => 'yii\grid\DataColumn',
                                'attribute' => 'default_operator_id',
                                'format' => 'raw',
                                'value' => function($model, $key, $index, $column){
                                  return $model->getFormatted('default_operator');
                                },
                            ],
                            
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}'
                            ],
                        ],
                    ]); ?>
                
                
            </div>
        </div>
    </div>

</div>
