<?php

use yii\db\Migration;

/**
 * Class m230816_010133_create_commission
 */
class m230816_010133_create_commission extends Migration
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

        $this->createTable('{{%commission}}', [
            'id' => $this->primaryKey(),
            'amount'=>$this->double()->notNull()->defaultValue(0),
            'employee_id'=>$this->integer()->notNull(),
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
        $this->dropTable('commission');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230816_010133_create_commission cannot be reverted.\n";

        return false;
    }
    */
}
