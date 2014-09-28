<?php
/**
 * Created by PhpStorm.
 * User: Loris
 * Date: 28/09/14
 * Time: 10:04
 */

namespace Backend\Controller;

use Backend\Model\SubCategory;
use Input;

class CategoriesController extends BaseController{

    public function findSubCategories(){
        $id_category= Input::get('id_category');
        return SubCategory::where('category_id','=',$id_category)->get();
    }

} 