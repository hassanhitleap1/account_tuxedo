<?php

use yii\db\Migration;

/**
 * Class m230816_010216_create_tiger
 */
class m230816_010216_create_tiger extends Migration
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

        $this->createTable('{{%tiger}}', [
            'id' => $this->primaryKey(),
            'amount' => $this->double()->notNull()->defaultValue(0),
            'user_id' => $this->integer()->notNull(),
            'note' => $this->text()->null(),
            'date' => $this->date()->notNull()->defaultValue(null),
            'sales_employees_id' => $this->integer()->null(),
            'created_at' => $this->dateTime()->notNull()->defaultValue(null),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(null),
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tiger');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230816_010216_create_tiger cannot be reverted.\n";

        return false;
    }
    */
}
