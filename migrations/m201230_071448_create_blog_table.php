<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog}}`.
 */
class m201230_071448_create_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(20)->notNull(),
            'description' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
        ]);

        $this->createIndex(
            '{{%idx-blog-created_by}}',
            '{{%blog}}',
            'created_by'
        );

        $this->addForeignKey(
            '{{%fk-blog-created_by}}',
            '{{%blog}}',
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
            '{{%fk-blog-created_by}}',
            '{{%blog}}'
        );

        $this->dropIndex(
            '{{%idx-blog-created_by}}',
            '{{%blog}}'
        );

        $this->dropTable('{{%blog}}');
    }
}
