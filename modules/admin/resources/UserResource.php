<?php

namespace app\modules\admin\resources;


use app\models\User;

/**
 * Class UserResource
 *
 * @author Zhasulan Moldakulov <87028987788@mail.ru>
 * @package app\modules\admin\resources
 */
class UserResource extends User
{
    public function fields()
    {
        return [
            'id', 'username', 'access_token', 'fullname'
        ];
    }
}