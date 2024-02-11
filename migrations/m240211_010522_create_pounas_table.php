<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pounas}}`.
 */
class m240211_010522_create_pounas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bonus}}', [
            'id' => $this->primaryKey(),
            'amount' => $this->double()->notNull()->defaultValue(0),
            'user_id' => $this->integer()->notNull(),
            'note' => $this->text()->null(),
            'date' => $this->date()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultValue(null),
            'updated_at' => $this->dateTime()->notNull()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bonus}}');
    }
}
