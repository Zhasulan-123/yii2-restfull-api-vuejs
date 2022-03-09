<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m201225_093809_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(20)->notNull(),
            'category_id' => $this->integer(11)->defaultValue(0),
            'description' => $this->string(200),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
        ]);

        $this->createIndex(
            '{{%idx-category-created_by}}',
            '{{%category}}',
            'created_by'
        );

        $this->addForeignKey(
            '{{%fk-category-created_by}}',
            '{{%category}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-category-created_by}}',
            '{{%category}}'
        );

        $this->dropIndex(
            '{{%idx-category-created_by}}',
            '{{%category}}'
        );

        $this->dropTable('{{%category}}');
    }
}
