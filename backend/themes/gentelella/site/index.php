<?php

/**
 * @var $this yii\web\View
 * @var $name string
 * @var $message string
 * @var $exception \yii\web\HttpException
 */

use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Json;
use common\models\Zone;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;

$this->title = 'Index';

/* @var $this yii\web\View */
/* @var $model common\models\Zone */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-middle">
    <div class="text-left">

    	<div class="row">
    		<div class="col-sm-6">
		        <h2>Bienvenido</h2>
		        <p>Selecciona una opción del menu para continuar.</p>

    		</div>
    	</div>
    </div>
</div>
