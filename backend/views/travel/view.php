<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\assets\ThemeAsset;
$assets = ThemeAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Travel */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Travels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="travel-view">

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
            <div class="x_title"></div>
            <div class="x_content">
                <p>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                                    'id',
            'status',
            'type',
            'payed_status',
            'client_id',
            'user_id',
            'created_at',
            'previous_travel_id',
            'service_id',
            'from_zone_id',
            'from_location',
            'from_address',
            'to_zone_id',
            'to_location',
            'to_address',
            'passanger_name',
            'pickup',
            'total',
            'payed',
            'balance',
                    ],
                ]) ?>

            </div>
        </div>
    </div>
</div>
