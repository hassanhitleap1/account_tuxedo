<?php

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
            'username' => $this->string()->unique()->defaultValue(null),
            'phone' => $this->string(32)->unique()->notNull()->defaultValue(null),
            'auth_key' => $this->string(32)->notNull()->defaultValue(null),
            'password_hash' => $this->string()->notNull()->defaultValue(null),
            'password_reset_token' => $this->string()->unique()->defaultValue(null),
            'email' => $this->string()->unique()->defaultValue(null),
            'type'=>$this->smallInteger()->defaultValue(1),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'employee_id'=>$this->integer()->notNull(),       
            'created_at' => $this->integer()->notNull()->defaultValue(null),
            'updated_at' => $this->integer()->notNull()->defaultValue(null),
        ], $tableOptions);
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
