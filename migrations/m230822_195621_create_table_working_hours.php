<?php

use yii\db\Migration;

/**
 * Class m230822_195621_create_table_working_hours
 */
class m230822_195621_create_table_working_hours extends Migration
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

        $this->createTable('{{%working_hours}}', [
            'id' => $this->primaryKey(),
            'employee_id'=>$this->integer()->notNull(),
            'start_time'=>$this->time()->null(),
            'end_time'=>$this->time()->null(),
            'note' => $this->text()->null(),
            'date' => $this->date()->notNull()->defaultValue(null),
            'created_at' => $this->dateTime()->notNull()->defaultValue(null),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(null),
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('working_hours');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230822_195621_create_table_working_hours cannot be reverted.\n";

        return false;
    }
    */
}
