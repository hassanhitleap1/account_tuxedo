<?php

use yii\db\Migration;

/**
 * Class m230902_235706_add_month_column_to_expenses
 */
class m230902_235706_add_month_column_to_expenses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%expenses}}', 'month', $this->integer()->notNull(9));

        // Add a foreign key constraint if needed
        // $this->addForeignKey('fk_expenses_month', '{{%expenses}}', 'month', '{{%months}}', 'id', 'CASCADE', 'CASCADE');
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%expenses}}', 'month');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230902_235706_add_month_column_to_expenses cannot be reverted.\n";

        return false;
    }
    */
}
