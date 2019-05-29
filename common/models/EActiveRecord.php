<?php

namespace common\models;

use Yii;

class EActiveRecord extends \yii\db\ActiveRecord
{
    public function getFormatted($attr, $lang = null)
    {
        switch ($attr) {
            default:
                if(isset($this->{$attr})) {
                    return $this->{$attr};
                }
                break;
        }

        return '';
    }
}
