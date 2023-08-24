<?php

use yii\db\Migration;

/**
 * Class m230816_005408_create_employees_tables
 */
class m230816_005408_create_employees_tables extends Migration
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
        $this->createTable('{{%employees}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'salary'=>$this->double()->notNull(),
            'commission'=>$this->double()->notNull()->defaultValue(0),
            'round_balance'=>$this->double()->notNull()->defaultValue(0),
            'start_date'=>$this->date()->null(),
            'work_start_time'=>$this->time(),
            'work_end_time'=>$this->time(),
            'created_at' => $this->dateTime()->notNull()->defaultValue(null),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(null),
        ], $tableOptions);

    

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('employees');
    }

   
}
