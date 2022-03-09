<?php

namespace app\modules\admin\resources;


use app\modules\admin\models\Page;

/**
 * Class PageResource
 *
 * @author Zhasulan Moldakulov <87028987788@mail.ru>
 * @package app\modules\admin\resources
 */
class PageResource extends Page
{

    public function fields(){
        return [
                'id',
                'title',
                'description',
                'text',
                'status',
                'categories'
        ];
    }

}