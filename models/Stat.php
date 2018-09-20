<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stat".
 *
 * @property integer $id
 * @property string $date
 * @property integer $accidents_count
 * @property integer $loss_count
 * @property integer $loss_child_count
 * @property integer $suffer_count
 * @property integer $suffer_child_count
 */
class Stat extends \yii\db\ActiveRecord implements \JsonSerializable
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'accidents_count', 'loss_count', 'loss_child_count', 'suffer_count', 'suffer_child_count'], 'required'],
            [['accidents_count', 'loss_count', 'loss_child_count', 'suffer_count', 'suffer_child_count'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Дата',
            'accidents_count' => 'Кол-во ДТП',
            'loss_count' => 'Погибшие',
            'loss_child_count' => 'Погибло детей',
            'suffer_count' => 'Ранены',
            'suffer_child_count' => 'Ранено детей',
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $out = [];
        foreach ($this->attributeLabels() as $attr => $label) {
            $out[$label] = $this->$attr;
        }
        return $out;
    }
}
