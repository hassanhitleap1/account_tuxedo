<?php

use yii\db\Migration;

/**
 * Class m230816_080225_create_expenses
 */
class m230816_080225_create_expenses extends Migration
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
        $this->createTable('{{%expenses}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'employee_id' => $this->integer()->null(),
            'amount' => $this->double()->notNull(),
            'note' => $this->text()->null(),
            'date' => $this->dateTime()->notNull()->defaultValue(null),
            'created_at' => $this->dateTime()->notNull()->defaultValue(null),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(null),
        ], $tableOptions);

        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230816_080225_create_expenses cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230816_080225_create_expenses cannot be reverted.\n";

        return false;
    }
    */
}
