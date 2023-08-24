<?php

namespace app\models;

use Yii;
use Carbon\Carbon;
use app\components\Calculator;

/**
 * This is the model class for table "{{%employees}}".
 *
 * @property int $id
 * @property string $name
 * @property float $salary
 * @property float $commission
 * @property string|null $work_start_time
 * @property string|null  $work_end_time
 * @property string|null  $start_date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Employees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%employees}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'salary','round_balance'], 'required'],
            [['salary', 'commission','round_balance'], 'number'],
            [['created_at', 'updated_at','start_date','work_start_time','work_end_time'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'salary' => Yii::t('app', 'Salary'),
            'start_date' => Yii::t('app', 'Start Date'),
            'round_balance'=> Yii::t('app', 'Round Balance'),
            'work_start_time'=> Yii::t('app', 'Work Start Time'),
            'work_end_time'=> Yii::t('app', 'Work End Time'),
            'commission' => Yii::t('app', 'Commission'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return EmployeesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeesQuery(get_called_class());
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


    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            // $this->salary=trim($this->salary);
            // $this->round_balance=trim($this->round_balance);
            // $this->commission=trim($this->commission);
            // $this->salary= Calculator::faTOen($this->salary);
            // $this->round_balance= Calculator::faTOen($this->round_balance);
            // $this->commission= Calculator::faTOen($this->commission);
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
    }
}
