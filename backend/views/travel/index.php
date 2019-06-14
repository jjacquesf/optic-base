<?php

use yii\helpers\Html;
use backend\assets\AppAsset;
use common\models\Travel;

use yii\grid\GridView;
use yii\widgets\ActiveForm;

$assets = AppAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TravelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Consulta de servicios registrados.');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('

    $("#reportrange_right").on("apply.daterangepicker", function(ev, picker) {
        $("#travelsearch-from_date").val(picker.startDate.format("YYYY-MM-DD"));
        $("#travelsearch-to_date").val(picker.endDate.format("YYYY-MM-DD"));
    });

');

?>
<div class="travel-index">

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
            <div class="x_title" style="overflow: auto;">
                <h2>Filtra los resultados <small>Utiliza las pestañas para reducir los resultados</small></h2>
            </div>
            <div class="x_content">

                <div class="well" style="overflow: auto;">
                    <div class="col-xs-6">
                        <?php $form = ActiveForm::begin(['method' => 'get']); ?>
                            <div id="reportrange_right" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                            </div>
                        <?= Html::activeHiddenInput($searchModel, 'from_date'); ?>
                        <?= Html::activeHiddenInput($searchModel, 'to_date'); ?>
                        &nbsp;<?= Html::submitButton('Filtrar', ['class' => 'btn btn-sm btn-success']); ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <div class="col-xs-6 text-right">
                        <?= Html::a('Agregar nuevo', ['create'], ['class' => 'btn btn-success']); ?> 
                    </div>
                </div>

                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                  <ul id="myTab1" class="nav nav-tabs bar_tabs left" role="tablist">
                    <li role="presentation" class="<?= is_null($type) ? 'active' : ''; ?>">
                        <?= Html::a('Todos', ['index'], []); ?>
                    </li>
                    <li role="presentation" class="<?= $type == Travel::TYPE_ARRIVAL ? 'active' : ''; ?>">
                        <?= Html::a('Llegadas', ['index', 'type' => Travel::TYPE_ARRIVAL], []); ?>
                    </li>
                    <li role="presentation" class="<?= $type == Travel::TYPE_DEPARTURE ? 'active' : ''; ?>">
                        <?= Html::a('Salidas', ['index', 'type' => Travel::TYPE_DEPARTURE], []); ?>
                    </li>
                    <li role="presentation" class="<?= $type == Travel::TYPE_SPECIAL ? 'active' : ''; ?>">
                        <?= Html::a('Servicios especiales', ['index', 'type' => Travel::TYPE_SPECIAL], []); ?>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active in" aria-labelledby="main-tab">

                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                        
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    // 'id',
                                    'reference',
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
                                        'attribute' => 'type',
                                        'format' => 'raw',
                                        'value' => function($model, $key, $index, $column){
                                          return $model->getFormatted('type');
                                        },
                                        // 'filter'
                                    ],
                                    [
                                        'class' => 'yii\grid\DataColumn',
                                        'attribute' => 'client_id',
                                        'format' => 'raw',
                                        'value' => function($model, $key, $index, $column){
                                          return $model->getFormatted('client.name');
                                        },
                                        // 'filter'
                                    ],
                                    // 'type',
                                    // 'payed_status',
                                    // 'client_id',
                                    //'user_id',
                                    //'created_at',
                                    //'previous_travel_id',
                                    //'service_id',
                                    //'from_zone_id',
                                    //'from_location',
                                    //'from_address',
                                    //'to_zone_id',
                                    //'to_location',
                                    //'to_address',
                                    //'passanger_name',
                                    //'pickup',
                                    //'total',
                                    [
                                        'class' => 'yii\grid\DataColumn',
                                        'attribute' => 'total',
                                        'format' => 'raw',
                                        'value' => function($model, $key, $index, $column){
                                          return sprintf('$%s', number_format($model->total, 2));
                                        },
                                        // 'filter'
                                    ],
                                    //'payed',
                                    //'balance',

                                    ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
                                ],
                            ]); 
                        ?>

                    </div>
                  </div>
                </div>
                
            </div>
        </div>
    </div>

</div>
