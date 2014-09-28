<?php

use Backend\Model\Category;
use Backend\Model\SubCategory;
class CategoryTableSeeder extends Seeder {

	public function run()
	{

        $categories = [
            'Calcio',
            'Concerti',     'Hockey'    ,'Rugby',    'NBA',
            'Show',     'Moto GP',      'Formula 1'
        ];

        $calcio_subcategories = [
            new SubCategory(['name' => 'Italia']),
            new SubCategory(['name' => 'Champions Leageue']),
            new SubCategory(['name' => 'Europa League']),
            new SubCategory(['name' => 'Mondiali'])
        ];

		foreach($categories as $category)
		{
			$cat = Category::create([
                'name'  =>  $category
			]);

            if($category == "Calcio")
                $cat->subcategories()->saveMany($calcio_subcategories);

		}
	}

}