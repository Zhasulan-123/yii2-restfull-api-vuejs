<?php

namespace app\modules\admin\models;

use app\models\User;
use app\modules\admin\resources\UserResource;
use Yii;
use yii\base\Model;

/**
 * RegisterForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $fullname;
    public $phone;
    public $email;
    public $password;
    public $password_repeat;
    public $access_token;

    public $user = null;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password', 'password_repeat', 'username', 'fullname', 'phone'], 'required'],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
            ['email', 'unique',
                'targetClass' => '\app\modules\admin\resources\UserResource',
                'message' => 'This email has already been taken.'
            ],
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            $user = new UserResource();
            $user->username = $this->username;
            $user->fullname = $this->fullname;
            $user->phone = $this->phone;
            $user->email = $this->email;
            $user->password = Yii::$app->security->generatePasswordHash($this->password);
            $user->access_token = Yii::$app->security->generateRandomString(256);
            $this->user = $user;
            if ($user->save()) {
                return Yii::$app->user->login($user, 0);
            }
            return false;
        }
        return false;
    }

}