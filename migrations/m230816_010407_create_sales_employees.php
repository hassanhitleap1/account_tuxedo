<?php

use yii\db\Migration;

/**
 * Class m230816_010407_create_sales_employees
 */
class m230816_010407_create_sales_employees extends Migration
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

        $this->createTable('{{%sales_employees}}', [
            'id' => $this->primaryKey(),
            'amount'=>$this->double()->notNull()->defaultValue(0),
            'tiger'=>$this->double()->notNull()->defaultValue(0),
            'employee_id'=>$this->integer()->notNull(),
            "payment_method"=>"enum('cash','visa')",
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
        $this->dropTable('sales_employees');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230816_010407_create_sales_employees cannot be reverted.\n";

        return false;
    }
    */
}
