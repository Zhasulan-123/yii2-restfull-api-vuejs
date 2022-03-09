<?php

namespace app\modules\admin\resources;

use app\modules\admin\models\Category;

/**
 * Class CategoryResource
 *
 * @author Zhasulan Moldakulov <87028987788@mail.ru>
 * @package app\modules\admin\resources
 */
class CategoryResource extends Category
{

    public function fields(){
		return [
			    'id' => 'id',
			    'text' => 'title',
			    'category' => 'category_id',
			    'description' => 'description',
			    'status' => 'status',
		];
    }

}