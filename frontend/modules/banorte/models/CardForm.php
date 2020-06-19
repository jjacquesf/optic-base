<?php
namespace frontend\modules\banorte\models;

use Yii;
use yii\base\Model;

/**
 * Card form
 */
class CardForm extends Model
{
    const CT_VISA = 'VISA';
    const CT_MC = 'MC';

    public $card_holder;
    public $card;
    public $expires;
    public $card_type;
    public $cvv;

    public $card_type_options = [
        self::CT_VISA => 'VISA',
        self::CT_MC => 'MC',
    ];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card', 'card_holder', 'expires', 'card_type', 'cvv'], 'required'],
            [['expires'], 'string', 'length' => 5],
            [['card_holder'], 'string', 'max' => 50],
            [['cvv'], 'string', 'length' => [3, 4]],
            [['expires'], 'match', 'pattern' => '/^(0[1-9]|1[0-2])\/?([0-9]{2})$/'],
            [['card_type'], 'in', 'range' => [self::CT_VISA, self::CT_MC], 'strict' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'card_holder' => Yii::t('app', 'Titular de la tarjeta'),
            'card' => Yii::t('app', 'Tarjeta'),
            'expires' => Yii::t('app', 'Expira'),
            'card_type' => Yii::t('app', 'Tipo'),
            'cvv' => Yii::t('app', 'CVV'),
        ];
    }

    public function getYearOptions() {
        $current = intval(date('Y'));
        $years = [];
        foreach(range($start, $current + 10) as $year) {
            $years[$year] = $year;
        }

        return $years;
    }
}
