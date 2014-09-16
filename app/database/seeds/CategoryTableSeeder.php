<?php

use Backend\Model\Category;

class CategoryTableSeeder extends Seeder {

	public function run()
	{

        $categories = [
            'Calcio',   'Concerti',     'Hockey'    ,'Rugby',    'NBA',
            'Show'
        ];

		foreach($categories as $category)
		{
			Category::create([
                'name'  =>  $category
			]);
		}
	}

}