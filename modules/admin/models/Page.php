<?php

namespace app\modules\admin\models;

use Yii;
use app\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property int $status
 * @property string|null $text
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 */
class Page extends \yii\db\ActiveRecord
{
    public $newcategory;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

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
            [['title', 'description', 'text', 'newcategory'], 'required'],
            [['status', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['newcategory'], 'safe'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 200],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPageCategorys()
    {
        return $this->hasMany(PageCategory::class, ['page_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('pageCategorys');
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        $this->newcategory = ArrayHelper::map($this->categories, 'id', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            PageCategory::deleteAll(['page_id' => $this->id]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if(is_array($this->newcategory)){

           $category = ArrayHelper::map($this->categories, 'id', 'id');

            foreach ($this->newcategory as $item) {
	            if (!in_array($item, $category)) {
	                $model = new PageCategory();
	                $model->page_id = $this->id;
	                $model->category_id = $item;
	                $model->save();
	            }
	            if (isset($category[$item])) {
	                unset($category[$item]);
	            }
	         }
           

           PageCategory::deleteAll(['and', ['page_id' => $this->id],['category_id' => $category]]);
           
        }else{
            PageCategory::deleteAll(['page_id' => $this->id]);
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
     * @return \app\modules\admin\models\query\PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\admin\models\query\PageQuery(get_called_class());
    }
}
