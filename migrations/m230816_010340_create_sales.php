<?php

use yii\db\Migration;

/**
 * Class m230816_010340_create_sales
 */
class m230816_010340_create_sales extends Migration
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

        $this->createTable('{{%sales}}', [
            'id' => $this->primaryKey(),
            'amount'=>$this->double()->notNull()->defaultValue(0),
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
        $this->dropTable('sales');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230816_010340_create_sales cannot be reverted.\n";

        return false;
    }
    */
}
