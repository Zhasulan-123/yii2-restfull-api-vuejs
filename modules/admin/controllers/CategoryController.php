<?php

namespace app\modules\admin\controllers;


use app\modules\admin\resources\CategoryResource;
use yii\data\ActiveDataProvider;

/**
 * Class CategoryController
 *
 * @author Zhasulan Moldakulov <87028987788@mail.ru>
 * @package app\modules\admin\controllers
 */

class CategoryController extends AuthController
{
    public $modelClass = CategoryResource::class;

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