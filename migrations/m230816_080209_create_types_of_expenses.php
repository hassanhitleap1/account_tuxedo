<?php

use yii\db\Migration;

/**
 * Class m230816_080209_create_types_of_expenses
 */
class m230816_080209_create_types_of_expenses extends Migration
{


    public $data=[
      ['name' => 'النمر'],
      ['name' => 'العمولة'],
      ['name' => 'سلفة'],
      ['name' => 'السحوبات'],
      ['name' => 'نثريات']
    ];
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
        $this->createTable('{{%types_of_expenses}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultValue(null),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(null),
        ], $tableOptions);

        Yii::$app->db
        ->createCommand()
        ->batchInsert('types_of_expenses', ['name'], $this->data)
        ->execute();



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('types_of_expenses');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230816_080209_create_types_of_expenses cannot be reverted.\n";

        return false;
    }
    */
}
