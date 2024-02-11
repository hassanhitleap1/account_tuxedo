<?php

namespace app\models\user;

use Carbon\Carbon;
use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $phone
 * @property string|null $auth_key
 * @property string|null $password_hash
 * @property string|null $password_reset_token
 * @property string|null $email
 * @property int|null $type
 * @property int $status
 * @property string|null $access_token
 * @property float $salary
 * @property float $commission
 * @property float $round_balance
 * @property string|null $start_date
 * @property string|null $work_start_time
 * @property string|null $work_end_time
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property  string|null $deleted_at
 */
class User extends \yii\db\ActiveRecord
{

    public $password;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'status', 'created_at', 'updated_at'], 'integer'],
            [['access_token'], 'string'],
            [['salary'], 'required'],
            [['salary', 'commission', 'round_balance'], 'number'],
            [['start_date', 'work_start_time', 'work_end_time', 'deleted_at'], 'safe'],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['phone', 'auth_key'], 'string', 'max' => 32],
            [['phone'], 'unique'],
            [['password_reset_token'], 'unique'],

        ];
    }


    public function delete()
    {
        $this->deleted_at = Carbon::now("Asia/Amman");

        return $this->save(false); // Skip validation to perform soft delete
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone' => Yii::t('app', 'Phone'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'access_token' => Yii::t('app', 'Access Token'),
            'salary' => Yii::t('app', 'Salary'),
            'commission' => Yii::t('app', 'Commission'),
            'round_balance' => Yii::t('app', 'Round Balance'),
            'start_date' => Yii::t('app', 'Start Date'),
            'work_start_time' => Yii::t('app', 'Work Start Time'),
            'work_end_time' => Yii::t('app', 'Work End Time'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }


}
