<?php

namespace app\models;

use Yii;
use Carbon\Carbon;
use app\components\Calculator;

/**
 * This is the model class for table "{{%sales}}".
 *
 * @property int $id
 * @property float $amount
 * @property string|null $note
 * @property string|null $date
 *  @property string|null $payment_method
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Sales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sales}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['payment_method','amount','date'], 'required'],
            [['amount'], 'number'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['note','payment_method'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'amount' => Yii::t('app', 'Amount'),
            'note' => Yii::t('app', 'Note'),
            'date' => Yii::t('app', 'Date'),
            'payment_method'=> Yii::t('app', 'Payment Method'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SalesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SalesQuery(get_called_class());
    }



    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            // $this->amount=trim($this->amount);
            // $this->amount= Calculator::faTOen($this->amount);
            return true;
        }
        return false;
    }

    public function beforeDelete()
    {
        return parent::beforeDelete();
    }

    public function beforeSave($insert)
    {
        $today=Carbon::now("Asia/Amman");
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            if ($this->isNewRecord) {
                $this->created_at = $today;
                $this->updated_at = $today;
            } else {
                $this->updated_at =$today;
            }

            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
    }
}
