<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Faker\Factory::create();
        $parentid=null;
        for($i = 0; $i < 50; $i++) {
            if (1< $i and $i<5){
                $parentid=1;
            }
            if (10<$i ){
                $parentid=rand(1,11);
            }
            App\Models\category::create([
                'name' => $faker->sentence,
                'parent_id' => $parentid
            ]);
        }
    }
}
