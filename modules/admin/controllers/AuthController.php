<?php

namespace app\modules\admin\controllers;


use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

/**
 * Class AuthController
 *
 * @author Zhasulan Moldakulov <87028987788@mail.ru>
 * @package app\modules\admin\controllers
 */

class AuthController extends ActiveController
{
    public $modelClass = PostResource::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $auth = $behaviors['authenticator'];
        $auth['authMethods'] = [
            HttpBearerAuth::class
        ];
        unset($behaviors['authenticator']);
        $behaviors['cors'] = [
            'class' => Cors::class
        ];
        $behaviors['authenticator'] = $auth;

        return $behaviors;
    }

}