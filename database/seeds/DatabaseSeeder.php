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
use App\Role;
use App\Permission;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(LaratrustSeeder::class);
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

        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Администратор'; // optional
        $admin->description  = 'Собственик'; // optional
        $admin->save();
        
        $merchant = new Role();
        $merchant->name         = 'merchant';
        $merchant->display_name = 'Магазинер'; // optional
        $merchant->description  = 'Продажби в магазин.'; // optional
        $merchant->save();

        $manager = new Role();
        $manager->name         = 'manager';
        $manager->display_name = 'Управител'; // optional
        $manager->description  = 'Управител на магазин'; // optional
        $manager->save();

        $sellingProducts = new Permission();
        $sellingProducts->name         = 'selling-products';
        $sellingProducts->display_name = 'Извършване на продажби'; // optional
        // Allow a user to...
        $sellingProducts->description  = 'извършване на продажби'; // optional
        $sellingProducts->save();
        
        $manageOrders = new Permission();
        $manageOrders->name         = 'manage-orders';
        $manageOrders->display_name = 'Пускане и издаване на поръчки'; // optional
        // Allow a user to...
        $manageOrders->description  = 'пускане и издаване на поръчки'; // optional
        $manageOrders->save();

        $manageRepairs = new Permission();
        $manageRepairs->name         = 'manage-repairs';
        $manageRepairs->display_name = 'Пускане и издаване на ремонти'; // optional
        // Allow a user to...
        $manageRepairs->description  = 'пускане и издаване на ремонти'; // optional
        $manageRepairs->save();

        $sellingsStatus = new Permission();
        $sellingsStatus->name         = 'sellings-status';
        $sellingsStatus->display_name = 'Справка за фискални продажби'; // optional
        // Allow a user to...
        $sellingsStatus->description  = 'справка за фискални продажби'; // optional
        $sellingsStatus->save();

        $jewelsStatus = new Permission();
        $jewelsStatus->name         = 'jewels-status';
        $jewelsStatus->display_name = 'Справка за налични бижута'; // optional
        // Allow a user to...
        $jewelsStatus->description  = 'справка за налични бижута'; // optional
        $jewelsStatus->save();

        $cashStatus = new Permission();
        $cashStatus->name         = 'cash-status';
        $cashStatus->display_name = 'Справка за налични пари в касата'; // optional
        // Allow a user to...
        $cashStatus->description  = 'справка за налични пари в касата'; // optional
        $cashStatus->save();

        $materialsStatus = new Permission();
        $materialsStatus->name         = 'materials-status';
        $materialsStatus->display_name = 'Справка за наличен материал'; // optional
        // Allow a user to...
        $materialsStatus->description  = 'справка за наличен материал'; // optional
        $materialsStatus->save();

        $transferJewels = new Permission();
        $transferJewels->name         = 'transfer-jewels';
        $transferJewels->display_name = 'Tрансфер на бижута м/у обекти'; // optional
        // Allow a user to...
        $transferJewels->description  = 'трансфер на бижута м/у обекти'; // optional
        $transferJewels->save();

        $editProducts = new Permission();
        $editProducts->name         = 'edit-products';
        $editProducts->display_name = 'Корекция на готово изделие'; // optional
        // Allow a user to...
        $editProducts->description  = 'корекция на готово изделие'; // optional
        $editProducts->save();

        $storeSale = new Permission();
        $storeSale->name         = 'store-sale';
        $storeSale->display_name = 'Сторниране на продажби'; // optional
        // Allow a user to...
        $storeSale->description  = 'сторниране на продажби'; // optional
        $storeSale->save();

        $addingSafe = new Permission();
        $addingSafe->name         = 'adding-safe';
        $addingSafe->display_name = 'Въвеждане на разходи в касата'; // optional
        // Allow a user to...
        $addingSafe->description  = 'въвеждане на разходи в касата'; // optional
        $addingSafe->save();

        $deleteProducts = new Permission();
        $deleteProducts->name         = 'delete-products';
        $deleteProducts->display_name = 'Изтриване на готово изделие'; // optional
        // Allow a user to...
        $deleteProducts->description  = 'Изтриване на готово изделие'; // optional
        $deleteProducts->save();

        $admin->attachPermissions([
            $sellingProducts, 
            $manageOrders,
            $manageRepairs,
            $sellingsStatus,
            $jewelsStatus,
            $cashStatus,
            $materialsStatus,
            $transferJewels,
            $editProducts,
            $storeSale,
            $addingSafe,
            $deleteProducts
        ]);

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@uvel.com';
        $user->password = bcrypt('administrator');
        $user->store = 1;
        $user->save();

        $user->attachRole($admin);

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
    }
}
