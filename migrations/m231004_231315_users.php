<?php

use app\models\User;
use Carbon\Carbon;
use yii\db\Migration;

/**
 * Class m231004_231315_users
 */
class m231004_231315_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {


        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'phone' => $this->string(32)->unique()->notNull()->defaultValue(null),
            'auth_key' => $this->string(32)->notNull()->defaultValue(null),
            'password_hash' => $this->string()->notNull()->defaultValue(null),
            'password_reset_token' => $this->string()->unique()->defaultValue(null),
            'type' => $this->smallInteger()->defaultValue(1),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'access_token' => $this->text()->null(),
            'salary' => $this->double()->notNull(),
            'commission' => $this->double()->notNull()->defaultValue(0),
            'round_balance' => $this->double()->notNull()->defaultValue(0),
            'start_date' => $this->date()->null(),
            'work_start_time' => $this->time()->null(),
            'work_end_time' => $this->time()->null(),
            'created_at' => $this->integer()->notNull()->defaultValue(null),
            'updated_at' => $this->integer()->notNull()->defaultValue(null),
            'deleted_at' => $this->dateTime()->null()->defaultValue(null),
        ], $tableOptions);


        $user = new User();

        $user->name = "حسن كيوان";
        $user->phone = '0799263494';

        $user->salary = 0;
        $user->type = \app\models\User::SUPER_ADMIN;
        $user->status = \app\models\User::STATUS_ACTIVE;
        $user->password_reset_token = null;
        $user->password_hash = Yii::$app->security->generatePasswordHash("22540535");
        $user->auth_key = 'dddddddsdfewpdsfopjsofjsdof';
        $user->access_token = null;
        $user->save();






    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231004_231315_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231004_231315_users cannot be reverted.\n";

        return false;
    }
    */
}
