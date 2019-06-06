<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sequence}}".
 *
 * @property int $id
 * @property string $prefix
 * @property int $current
 */
class Sequence extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sequence}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prefix', 'current'], 'required'],
            [['current'], 'integer'],
            [['prefix'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prefix' => 'Prefix',
            'current' => 'Current',
        ];
    }

    public static function getNext($type)
    {

        $query = Sequence::find();

        switch ($type) {
            case Travel::TYPE_DEPARTURE:
                $query->where(['prefix' => 'S']);
                break;
            case Travel::TYPE_SPECIAL:
                $query->where(['prefix' => 'E']);
                break;
            case Travel::TYPE_COLLECTIVE_ARRIVAL:
                $query->where(['prefix' => 'LC']);
                break;
            case Travel::TYPE_COLLECTIVE_ARRIVAL:
                $query->where(['prefix' => 'SC']);
                break;
            default:
            case Travel::TYPE_ARRIVAL:
                $query->where(['prefix' => 'L']);
                break;
        }
        
        $model = $query->one();

        if($model != null) {
            $model->current += 1;
            $model->update(['current']);

            return sprintf('%s%d', $model->prefix , $model->current);
        }

        return false;
    }
}
