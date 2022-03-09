<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\admin\resources\UserResource;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends \app\models\LoginForm
{
	private $_user = false;

    /**
     * @return \app\models\User|UserResource|bool|null
     * @author Zhasulan Moldakulov <87028987788@mail.ru>
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = UserResource::findByUsername($this->email);
        }

        return $this->_user;
    }
}
