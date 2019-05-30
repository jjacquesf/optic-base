<?php

namespace common\models;

use Yii;
use yii\helpers\JSON;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "optic_zone".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $polygon
 */
class Zone extends EActiveRecord
{
    public $default_polygon = [
      [ 'lat' => 23.158912, 'lng' => -109.734570 ],
      [ 'lat' => 23.124814, 'lng' => -109.717411 ],
      [ 'lat' => 23.117133, 'lng' => -109.679889 ],
      [ 'lat' => 23.152883, 'lng' => -109.67775 ]
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'optic_zone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'polygon'], 'required'],
            [['polygon'], 'string'],
            [['name', 'description'], 'string', 'max' => 60],
            [
                'polygon', 
                'default', 
                'value' => JSON::encode($this->default_polygon),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Nombre'),
            'description' => Yii::t('app', 'Descripción'),
            'polygon' => Yii::t('app', 'Puntos'),
        ];
    }

    public function getFormatted($attr, $lang = 'es')
    {
        switch($attr)
        {
            case 'polygon':

                $polygon = $this->polygon;
                if($this->isNewRecord) {
                    $polygon = JSON::encode($this->default_polygon);
                }

                return $polygon;

                break;
            default:
                return parent::getFormatted($attr, $lang);
                break;
        }
    }

    public function getTravelsFrom()
    {
        return $this->hasOne(Travel::clasName(), ['from_zone_id' => 'id']);
    }

    public function getTravelsTo()
    {
        return $this->hasOne(Travel::clasName(), ['to_zone_id' => 'id']);
    }

    public static function getPolygonsExcept($id = null)
    {
        return array_values(ArrayHelper::map(self::find()->filterWhere(['<>', 'id', $id])->all(), 'id', function($model) {
            return $model->getFormatted('polygon');
        }));
    }
}
