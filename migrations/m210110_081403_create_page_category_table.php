<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page_category}}`.
 */
class m210110_081403_create_page_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page_category}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer(11),
            'category_id' => $this->integer(11),
        ]);

        $this->createIndex(
            '{{%idx-page_category-page_id}}',
            '{{%page_category}}',
            'page_id'
        );

        $this->createIndex(
            '{{%idx-page_category-category_id}}',
            '{{%page_category}}',
            'category_id'
        );

        $this->addForeignKey(
            '{{%fk-page_category-page_id}}',
            '{{%page_category}}',
            'page_id',
            '{{%page}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-page_category-category_id}}',
            '{{%page_category}}',
            'category_id',
            '{{%category}}',
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
            '{{%fk-page_category-page_id}}',
            '{{%page_category}}'
        );

        $this->dropForeignKey(
            '{{%fk-page_category-category_id}}',
            '{{%page_category}}'
        );

        $this->dropIndex(
            '{{%idx-page_category-page_id}}',
            '{{%page_category}}'
        );

        $this->dropIndex(
            '{{%idx-page_category-category_id}}',
            '{{%page_category}}'
        );

        $this->dropTable('{{%page_category}}');
    }
}
