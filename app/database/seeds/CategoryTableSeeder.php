<?php

use Backend\Model\Category;
use Backend\Model\SubCategory;
class CategoryTableSeeder extends Seeder {

	public function run()
	{

        $categories = [
            //Multi - Team
            'Calcio',
            'Hockey',
            'Rugby',
            'NBA',

            //Single
            'Concerti',
            'Show',

            //No-Team
            'Moto GP',
            'Formula 1'
        ];

        $calcio_subcategories = [
            new SubCategory(['name' => 'Italia']),
            new SubCategory(['name' => 'Champions Leageue']),
            new SubCategory(['name' => 'Europa League']),
            new SubCategory(['name' => 'Mondiali'])
        ];

        $motogp_subcategories = [
            new SubCategory(['name' => 'Grand Prix'])
        ];

		foreach($categories as $category)
		{
			$cat = Category::create([
                'name'  =>  $category
			]);

                switch($category){
                    case 'Calcio':
                        $cat->subcategories()->saveMany($calcio_subcategories);
                        break;
                    case 'Moto GP':
                        $cat->subcategories()->saveMany($motogp_subcategories);
                        break;
                }

		}
	}

}