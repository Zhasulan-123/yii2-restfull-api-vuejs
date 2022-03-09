<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tags}}`.
 */
class m201230_070423_create_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(20)->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
        ]);

        $this->createIndex(
            '{{%idx-tags-created_by}}',
            '{{%tags}}',
            'created_by'
        );

        $this->addForeignKey(
            '{{%fk-tags-created_by}}',
            '{{%tags}}',
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
            '{{%fk-tags-created_by}}',
            '{{%tags}}'
        );

        $this->dropIndex(
            '{{%idx-tags-created_by}}',
            '{{%tags}}'
        );

        $this->dropTable('{{%tags}}');
    }
}
