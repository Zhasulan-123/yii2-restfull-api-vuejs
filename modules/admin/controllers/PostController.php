<?php

namespace app\modules\admin\controllers;


use app\modules\admin\resources\PostResource;
use yii\data\ActiveDataProvider;

/**
 * Class PostController
 *
 * @author Zhasulan Moldakulov <87028987788@mail.ru>
 * @package app\modules\admin\controllers
 */

class PostController extends AuthController
{
    public $modelClass = PostResource::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => $this->modelClass::find()->andWhere(['created_by' => \Yii::$app->user->id])
        ]);
    }
}