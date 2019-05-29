<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar sesión';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>
        <div class="login_wrapper">
            <div class="animate form login_form">
              <section class="login_content">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <h1><?= Html::encode($this->title) ?></h1>

                    <?= $form->field($model, 'username', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('username')]])->textInput(['autofocus' => true])->label(false); ?>

                    <?= $form->field($model, 'password', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('password')]])->passwordInput()->label(false); ?>

                    <div class="form-group">
                        <?= Html::submitButton('Entrar', ['class' => 'btn btn-default submit', 'name' => 'login-button']) ?>
                        <!-- <a class="reset_pass" href="#">Lost your password?</a> -->
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />

                        <div>
                          <h1><i class="fa fa-users"></i> <?= Yii::$app->name; ?></h1>
                          <p>&copy;<?= date('Y'); ?> Eskalon Network</p>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
              </section>
            </div>
        </div>
    </div>
</div>
