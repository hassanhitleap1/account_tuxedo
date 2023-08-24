<?php

namespace app\models;

use Yii;
use Carbon\Carbon;
use app\components\Calculator;

/**
 * This is the model class for table "{{%expenses}}".
 *
 * @property int $id
 * @property string $name
 * @property int $type_id
 * @property int|null $employee_id
 * @property float $amount
 * @property string|null $note
 * @property string|null $date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Expenses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%expenses}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type_id', 'amount'], 'required'],
            [['type_id', 'employee_id'], 'integer'],
            [['amount'], 'number'],
            [['note'], 'string'],
            [['date', 'created_at', 'updated_at'], 'safe'],
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
            'type_id' => Yii::t('app', 'Type ID'),
            'employee_id' => Yii::t('app', 'Employee ID'),
            'amount' => Yii::t('app', 'Amount'),
            'note' => Yii::t('app', 'Note'),
            'date' => Yii::t('app', 'Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ExpensesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExpensesQuery(get_called_class());
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

        if($this->isNewRecord && !is_null($this->employee_id)){
            if($this->type_id == Commission::TYPE_EXPENSES){
                Calculator::addCommission($this);
            }elseif($this->type_id == Tiger::TYPE_EXPENSES){
                Calculator::addTiger($this);
            }elseif($this->type_id == Draws::TYPE_EXPENSES){
                Calculator::addDraws($this);
            }elseif($this->type_id == Debt::TYPE_EXPENSES){
                Calculator::addDebt($this);
            }
           
        }

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


    public function getEmployee(){
        return $this->hasOne(Employees::className(), ['id'=>'employee_id']);
    }
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
    }
}
