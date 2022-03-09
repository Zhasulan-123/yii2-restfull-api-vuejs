<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%blog_tags}}".
 *
 * @property int $id
 * @property int|null $blog_id
 * @property int|null $tags_id
 *
 * @property Blog $blog
 * @property Tags $tags
 */
class BlogTags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%blog_tags}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blog_id', 'tags_id'], 'required'],
            [['blog_id', 'tags_id'], 'integer'],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blog::class, 'targetAttribute' => ['blog_id' => 'id']],
            [['tags_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::class, 'targetAttribute' => ['tags_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[Blog]].
     *
     * @return \yii\db\ActiveQuery|\app\modules\admin\models\query\BlogQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blog::class, ['id' => 'blog_id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery|\app\modules\admin\models\query\TagsQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tags::class, ['id' => 'tags_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\admin\models\query\BlogTagsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\query\BlogTagsQuery(get_called_class());
    }
}
