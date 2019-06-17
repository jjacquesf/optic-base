<?php

namespace common\models;

use Yii;
use yii\helpers\Html;

class EActiveRecord extends \yii\db\ActiveRecord
{
    public $translated_content = [];

    public function getFormatted($attr, $lang = 'es')
    {
        switch ($attr) {
            case 'status':
                if(isset($this->status)) {
                    if(isset($this->status_options[$this->status])) {
                        return $this->status_options[$this->status];
                    }

                    return $this->status;
                }
                break;
            default:
                if(isset($this->{$attr})) {
                    return $this->{$attr};
                }
                break;
        }

        return '';
    }

    public function setTranslate($code, $lang, $content)
    {
        if(!$this->isNewRecord) {
            return Translate::setTranlatedContent($this->id, $code, $lang, $content);
        }
        
        return false;
    }

    public function getTranslate($code, $lang)
    {
        return $this->isNewRecord ? '' : Translate::getContent($this->id, $code, $lang);
    }

    public function translateContent()
    {
        $content = [];
        foreach(Config::getLangs() as $lang) {
            foreach($this->translated_content as $tc_name => $tc_code) {

                // $content[] = Html::beginTag('div', ['class' => 'col-sm-4']);
                $content[] = Html::beginTag('div', ['class' => 'form-group col-sm-4']);
                $content[] = Html::label(Yii::t('app', sprintf('%s (%s)', $this->getAttributeLabel($tc_name), ucfirst($lang))), '');
                $content[] = Html::textInput("Translate[{$lang}][{$tc_code}]", $this->getTranslate($tc_code, $lang), [
                    'class' => 'form-control'
                ]);
                $content[] = Html::endTag('div');
                // $content[] = Html::endTag('div');
            }
        }

        return implode('', $content);
    }

    public function saveTranslations($data)
    {
        if(!$this->isNewRecord && isset($data['Translate'])) {

            foreach($data['Translate'] as $lang => $translation) {
                foreach($translation as $code => $content) {
                    $this->setTranslate($code, $lang, $content);
                }
            }            

            return true;
        }

        return false;
    }
}
