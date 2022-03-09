<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_tags}}`.
 */
class m201230_072930_create_blog_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog_tags}}', [
            'id' => $this->primaryKey(),
            'blog_id' => $this->integer(11),
            'tags_id' => $this->integer(11),
        ]);

         $this->createIndex(
            '{{%idx-blog_tags-blog_id}}',
            '{{%blog_tags}}',
            'blog_id'
        );

        $this->createIndex(
            '{{%idx-blog_tags-tags_id}}',
            '{{%blog_tags}}',
            'tags_id'
        );

        $this->addForeignKey(
            '{{%fk-blog_tags-blog_id}}',
            '{{%blog_tags}}',
            'blog_id',
            '{{%blog}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-blog_tags-tags_id}}',
            '{{%blog_tags}}',
            'tags_id',
            '{{%tags}}',
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
            '{{%fk-blog_tags-blog_id}}',
            '{{%blog_tags}}'
        );

        $this->dropForeignKey(
            '{{%fk-blog_tags-tags_id}}',
            '{{%blog_tags}}'
        );

        $this->dropIndex(
            '{{%idx-blog_tags-blog_id}}',
            '{{%blog_tags}}'
        );

        $this->dropIndex(
            '{{%idx-blog_tags-tags_id}}',
            '{{%blog_tags}}'
        );

        $this->dropTable('{{%blog_tags}}');
    }
}
