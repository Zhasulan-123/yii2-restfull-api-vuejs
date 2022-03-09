<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%page_category}}".
 *
 * @property int $id
 * @property int|null $page_id
 * @property int|null $category_id
 *
 * @property Category $category
 * @property Page $page
 */
class PageCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%page_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id', 'category_id'], 'required'],
            [['page_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::class, 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|\app\modules\admin\models\query\CategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery|\app\modules\admin\models\query\PageQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::class, ['id' => 'page_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\admin\models\query\PageCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\query\PageCategoryQuery(get_called_class());
    }
}
