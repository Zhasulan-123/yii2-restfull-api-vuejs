<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page}}`.
 */
class m201221_033437_create_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50),
            'description' => $this->string(200),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
            'text' => $this->text(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'created_by' => $this->integer(11),
        ]);

        $this->createIndex(
            '{{%idx-page-created_by}}',
            '{{%page}}',
            'created_by'
        );

        $this->addForeignKey(
            '{{%fk-page-created_by}}',
            '{{%page}}',
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
            '{{%fk-page-created_by}}',
            '{{%page}}'
        );

        $this->dropIndex(
            '{{%idx-page-created_by}}',
            '{{%page}}'
        );

        $this->dropTable('{{%page}}');
    }
}
