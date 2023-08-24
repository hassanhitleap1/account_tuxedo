<?php

namespace app\models;

use Yii;
use Carbon\Carbon;
use app\components\Calculator;

/**
 * This is the model class for table "{{%tiger}}".
 *
 * @property int $id
 * @property float $amount
 * @property int $employee_id
 * @property string|null $note
 * @property string|null $date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Tiger extends \yii\db\ActiveRecord
{

    const  TYPE_EXPENSES=1; 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tiger}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount','sales_employees_id'], 'number'],
            [['employee_id'], 'required'],
            [['employee_id'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['note'], 'string', 'max' => 255],
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
            'employee_id' => Yii::t('app', 'Employee ID'),
            'note' => Yii::t('app', 'Note'),
            'date' => Yii::t('app', 'Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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

    public function getEmployee(){
        return $this->hasOne(Employees::className(), ['id'=>'employee_id']);
    }

    /**
     * {@inheritdoc}
     * @return TigerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TigerQuery(get_called_class());
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
