<?php

namespace app\models;

use Yii;
use Carbon\Carbon;

/**
 * This is the model class for table "{{%working_hours}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $note
 * @property string|null $date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class WorkingHours extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%working_hours}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'start_time', 'end_time'], 'required'],
            [['user_id'], 'integer'],
            [['start_time', 'end_time', 'date', 'created_at', 'updated_at'], 'safe'],
            [['note'], 'string'],
            [['date'], 'validateDate'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Employee ID'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'note' => Yii::t('app', 'Note'),
            'date' => Yii::t('app', 'Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return WorkingHoursQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WorkingHoursQuery(get_called_class());
    }



    public function validateDate($attribute)
    {


        if ($this->isNewRecord) {
            $workingHours = self::find()->where(['date' => $this->$attribute, 'user_id' => $this->user_id])->all();
            if (count($workingHours)) {
                $this->addError($attribute, Yii::t('app', 'This employee has registered his shift on this date'));
            }
        }



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
