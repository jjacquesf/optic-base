<?php

use yii\helpers\Html;
use backend\assets\ThemeAsset;
$assets = ThemeAsset::register($this);

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Amenidades');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-index">

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
                        // 'filterModel' => $searchModel,
                        'columns' => [
                            // ['class' => 'yii\grid\SerialColumn'],
                            // 'id',
                            [
                                'class' => 'yii\grid\DataColumn',
                                'header' => 'Nombre',
                                'format' => 'raw',
                                'value' => function($model, $key, $index, $column){
                                  return $model->getFormatted('name');
                                },
                            ],
                            [
                                'class' => 'yii\grid\DataColumn',
                                'header' => 'Descripción',
                                'format' => 'raw',
                                'value' => function($model, $key, $index, $column){
                                  return $model->getFormatted('description');
                                },
                            ],
                            'price',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'delete' => function ($url, $model, $key) {
                                        if(empty($model->travels)) {
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                                'data-method' => 'post',
                                                'confirm' => Yii::t('app', '¿Está seguro de eliminar este elemento?')
                                            ]);
                                        }
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                
                
            </div>
        </div>
    </div>

</div>
