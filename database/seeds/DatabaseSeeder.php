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
use App\User;
use App\Repair_types;
use App\Currencies;
use App\Products;
use App\Models;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Bouncer::role()->create([
            'name' => 'admin',
            'title' => 'Админ',
        ]);

        $admin = Bouncer::role()->create([
            'name' => 'merchant',
            'title' => 'Магазинер',
        ]);

        $admin = Bouncer::role()->create([
            'name' => 'Manager',
            'title' => 'Управител',
        ]);

        $admin = Bouncer::role()->create([
            'name' => 'customer',
            'title' => 'Клиент',
        ]);
        
        $ban = Bouncer::ability()->create([
            'name' => 'selling-products',
            'title' => 'Извършване на продажби',
        ]);

        $sellingProducts = Bouncer::ability()->create([
            'name' => 'selling-products',
            'title' => 'Извършване на продажби',
        ]);

        $manageOrders = Bouncer::ability()->create([
            'name' => 'manage-orders',
            'title' => 'Пускане и издаване на поръчки',
        ]);

        $manageOrders = Bouncer::ability()->create([
            'name' => 'manage-repairs',
            'title' => 'Пускане и издаване на поръчки',
        ]);

        $manageOrders = Bouncer::ability()->create([
            'name' => 'sellings-status',
            'title' => 'Справка за фискални продажби',
        ]);

        $manageOrders = Bouncer::ability()->create([
            'name' => 'jewels-status',
            'title' => 'Справка за налични бижута',
        ]);

        $manageOrders = Bouncer::ability()->create([
            'name' => 'cash-status',
            'title' => 'Справка за налични пари в касата',
        ]);

        $manageOrders = Bouncer::ability()->create([
            'name' => 'materials-status',
            'title' => 'Справка за наличен материал',
        ]);

        $manageOrders = Bouncer::ability()->create([
            'name' => 'transfer-jewels',
            'title' => 'Tрансфер на бижута м/у обекти',
        ]);

        $manageOrders = Bouncer::ability()->create([
            'name' => 'edit-products',
            'title' => 'Корекция на готово изделие',
        ]);

        $manageOrders = Bouncer::ability()->create([
            'name' => 'store-sale',
            'title' => 'Сторниране на продажби',
        ]);

        $manageOrders = Bouncer::ability()->create([
            'name' => 'adding-safe',
            'title' => 'Въвеждане на разходи в касата',
        ]);

        $manageOrders = Bouncer::ability()->create([
            'name' => 'delete-products',
            'title' => 'Изтриване на готово изделие',
        ]);

        //Bouncer::allow('admin')->everything();

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@uvel.com';
        $user->password = bcrypt('administrator');
        $user->store = 1;
        $user->save();

        Bouncer::assign('admin')->to($user);
        Bouncer::allow($user)->to('delete-products');

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
        $material->carat = '14';
        $material->stock_price = '24';
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
        $material->carat = '14';
        $material->stock_price = '24';
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

        $repairType = new Repair_types();
        $repairType->name = 'Залепяне на камък';
        $repairType->price = '30';
        $repairType->save();

        $currency = new Currencies();
        $currency->name = 'GBP';
        $currency->currency = '0.44';
        $currency->save();

        $currency = new Currencies();
        $currency->name = 'USD';
        $currency->currency = '0.63';
        $currency->save();

        $currency = new Currencies();
        $currency->name = 'EUR';
        $currency->currency = '0.51';
        $currency->save();
        
        $model = new Models();
        $model->name = 'Модел 1';
        $model->jewel = 1;
        $model->retail_price = 2;
        $model->wholesale_price = 4;
        $model->weight = 56;
        $model->size = 56;
        $model->workmanship = 3920;
        $model->price = 5040;
        $model->save();

        $product = new Products();
        $product->id = Uuid::generate()->string;
        $product->name = 'Продукт 1';
        $product->model = 1;
        $product->jewel_type = 1;
        $product->type = 1;
        $product->retail_price = 2;
        $product->wholesale_price = 4;
        $product->weight = 56;
        $product->size = 56;
        $product->workmanship = 120;
        $product->price = 210;
        $product->code = 88539905;
        $product->barcode = 3807260069719;
        $product->save();
    }
}
