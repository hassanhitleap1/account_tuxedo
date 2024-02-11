<?php

namespace app\models;

use Carbon\Carbon;
use Yii;

/**
 * This is the model class for table "{{%bonus}}".
 *
 * @property int $id
 * @property float $amount
 * @property int $user_id
 * @property string|null $note
 * @property string $date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Bonus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bonus}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['user_id', 'date'], 'required'],
            [['user_id'], 'integer'],
            [['note'], 'string'],
            [['date', 'created_at', 'updated_at'], 'safe'],
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
            'user_id' => Yii::t('app', 'User ID'),
            'note' => Yii::t('app', 'Note'),
            'date' => Yii::t('app', 'Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BonusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BonusQuery(get_called_class());
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id', 'user_id']);
    }

    public function beforeSave($insert)
    {
        $today = Carbon::now("Asia/Amman");

        if (parent::beforeSave($insert)) {
            // Place your custom code here
            if ($this->isNewRecord) {
                $this->created_at = $today;
                $this->updated_at = $today;
            } else {
                $this->updated_at = $today;
            }

            return true;
        } else {
            return false;
        }
    }
}
