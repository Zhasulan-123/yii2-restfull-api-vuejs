<?php

namespace app\modules\admin\models;

use Yii;
use app\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use app\modules\admin\models\BlogTags;
use app\modules\admin\models\Tags;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "{{%blog}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property int $status
 * @property string $newtags
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 * @property BlogTags $newtags
 */
class Blog extends \yii\db\ActiveRecord
{
    public $newtags;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%blog}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'text', 'newtags'], 'required'],
            [['newtags'], 'safe'],
            [['text'], 'string'],
            [['status', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['title'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    public function getBlogTag()
    {
        return $this->hasMany(BlogTags::class, ['blog_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tags::class, ['id' => 'tags_id'])->via('blogTag');
    }

    public function afterFind()
    {
        $this->newtags = ArrayHelper::map($this->tags, 'id', 'title');
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            BlogTags::deleteAll(['blog_id' => $this->id]);
            return true;
        } else {
            return false;
        }
    }

   public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if(is_array($this->newtags)){
           $tag = ArrayHelper::map($this->tags, 'id', 'id');

           foreach ($this->newtags as $item) {
               if(isset($tag[$item['id']])){
                  unset($tag[$item['id']]);
               }else{
                   $model = new BlogTags();
                   $model->blog_id = $this->id;
                   $model->tags_id = $item['id'];
                   $model->save();
               }
           }

           BlogTags::deleteAll(['and', ['blog_id' => $this->id],['tags_id' => $tag]]);
           
        }else{
            BlogTags::deleteAll(['blog_id' => $this->id]);
        }

    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\app\modules\admin\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\admin\models\query\BlogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\query\BlogQuery(get_called_class());
    }
}
