<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class UserController extends Controller{

   public function actionAdd($email, $password, $username, $fullname, $phone)
   {
        $security = Yii::$app->security;

        $user = new User();
        $user->email = $email;
        $user->password = $security->generatePasswordHash($password);
        $user->access_token = $security->generateRandomString(256);
        $user->username = $username;
        $user->fullname = $fullname;
        $user->phone = $phone;
        // $user->created_at = $created_at;
        if ($user->save()) {
            Console::output('saved');
        } else {
            var_dump($user->errors);
            Console::output("not saved");
        }
   }

}