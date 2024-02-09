<?php

namespace app\models;

use app\models\user\User;
use Yii;
use Carbon\Carbon;


/**
 * This is the model class for table "{{%sales_employees}}".
 *
 * @property int $id
 * @property float $amount
 * @property int $user_id
 * @property string|null $note
 * @property string|null $date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class SalesEmployees extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sales_employees}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'tiger'], 'number'],
            [['user_id', 'payment_method', 'tiger', 'amount'], 'required'],
            [['user_id'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['note', 'payment_method'], 'string', 'max' => 255],
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
            'user_id' => Yii::t('app', 'User'),
            'note' => Yii::t('app', 'Note'),
            'payment_method' => Yii::t('app', 'Payment Method'),
            'tiger' => Yii::t('app', 'Tiger'),
            'date' => Yii::t('app', 'Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return SalesEmployeesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SalesEmployeesQuery(get_called_class());
    }


    public function beforeValidate()
    {
        if (parent::beforeValidate()) {

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

    public function afterSave($insert, $changedAttributes)
    {

        // $expenses = new Expenses::find()->where(['sales_employees_id' => $this->id ])->one();
        // if(is_null($expenses) ){

        //     $expenses = new Expenses():
        //     Tiger::TYPE_EXPENSES)


        // }
        $tiger = Tiger::find()->where(['sales_employees_id' => $this->id])->one();
        if (is_null($tiger)) {
            $tiger = new Tiger();
            $tiger->user_id = $this->user_id;
            $tiger->amount = $this->tiger;
            $tiger->date = $this->date;
            $tiger->note = $this->note;
            $tiger->sales_employees_id = $this->id;

        } else {
            $tiger->user_id = $this->user_id;
            $tiger->amount = $this->tiger;
            $tiger->date = $this->date;
            $tiger->note = $this->note;
        }


        $tiger->save();

        parent::afterSave($insert, $changedAttributes);
    }
}
