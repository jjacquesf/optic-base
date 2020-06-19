<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class UtilitiesController extends Controller {

    public function action3dSecureRequest() {
        Yii::$app->banorte->setCard('4915663039799581', '10', '22', 'VISA', '834');
        Yii::$app->banorte->make3DSecureRequest();
    }

}