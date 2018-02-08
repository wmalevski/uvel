<?php

use Illuminate\Database\Seeder;
use App\Stone_sizes;
use App\Stone_styles;
use App\Stone_contours;
use App\Stores;
use App\Materials;
use App\Prices;
use App\Stones;
use App\Jewels;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        // $owner = new Role();
        // $owner->name         = 'admin';
        // $owner->display_name = 'Админ'; // optional
        // $owner->description  = 'Пълни права в сайта'; // optional
        // $owner->save();
        
        // $admin = new Role();
        // $admin->name         = 'employee';
        // $admin->display_name = 'Служител'; // optional
        // $admin->description  = 'Ограничени права в сайта'; // optional
        // $admin->save();

        for($i = 1; $i <= 5; $i++){
            $stone_styles = new Stone_styles();
            $stone_styles->name = 'Стил '.$i;
            $stone_styles->save();

            $stone_sizes = new Stone_sizes();
            $stone_sizes->name = 'Размер '.$i;
            $stone_sizes->save();

            $stone_contour = new Stone_contours();
            $stone_contour->name = 'Контур '.$i;
            $stone_contour->save();

            $stores = new Stores();
            $stores->name = 'Магазин '.$i;
            $stores->location = 'София'; 
            $stores->phone = '0541587414178';
            $stores->save();


            $stone = new Stones();
            $stone->name = 'Камък '.$i;
            $stone->type = rand(1,2);
            $stone->weight = rand(1,5);
            $stone->carat = rand(1,5);
            $stone->size = rand(1,5);
            $stone->style = rand(1,5);
            $stone->contour = rand(1,5);
            $stone->amount = rand(1,20);
            $stone->price = rand(20,45);
            $stone->save();

            $jewel = new Jewels();
            $jewel->name = 'Бижу '.$i;
            $jewel->material = rand(1,2);
            $jewel->save();
        }

        $material = new Materials();
        $material->name = 'Злато';
        $material->code = '525';
        $material->color = 'Жълто';
        $material->save();

        $price = new Prices();
        $price->material = $material->id;
        $price->slug = 'Купува 1';
        $price->price = '30';
        $price->type = 'buy';
        $price->save();
        
        $price = new Prices();
        $price->material = $material->id;
        $price->slug = 'Продава 1';
        $price->price = '90';
        $price->type = 'sell';
        $price->save();

        $material = new Materials();
        $material->name = 'Сребро';
        $material->code = '925';
        $material->color = 'Сив';
        $material->save();

        $price = new Prices();
        $price->material = $material->id;
        $price->slug = 'Купува 1';
        $price->price = '20';
        $price->type = 'buy';
        $price->save();
        
        $price = new Prices();
        $price->material = $material->id;
        $price->slug = 'Продава 1';
        $price->price = '70';
        $price->type = 'sell';
        $price->save();
    }
}
