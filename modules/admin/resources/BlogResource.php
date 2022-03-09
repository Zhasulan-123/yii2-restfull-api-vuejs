<?php

namespace app\modules\admin\resources;


use app\modules\admin\models\Blog;


/**
 * Class BlogResource
 *
 * @author Zhasulan Moldakulov <87028987788@mail.ru>
 * @package app\modules\admin\resources
 */
class BlogResource extends Blog
{
    public function fields(){
        return [
                'id',
                'title',
                'description',
                'text',
                'status',
                'tags'
        ];
    }
}