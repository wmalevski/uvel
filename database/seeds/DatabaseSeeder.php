<?php

use Illuminate\Database\Seeder;
use App\StoneSize;
use App\StoneStyle;
use App\StoneContour;
use App\Store;
use App\Material;
use App\Price;
use App\Stone;
use App\Jewel;
use App\User;
use App\RepairType;
use App\Currency;
use App\Product;
use App\Model;
use App\DiscountCode;
use App\ProductOther;
use App\ProductOtherType;
use App\Repair;
use App\MaterialQuantity;
use App\MaterialType;
use App\Nomenclature;
use App\Partner;
use App\PartnerMaterial;
use App\CashGroup;

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

        $merchant = Bouncer::role()->create([
            'name' => 'merchant',
            'title' => 'Магазинер',
        ]);

        $partner = Bouncer::role()->create([
            'name' => 'corporate_partner',
            'title' => 'Kорпоративен Партньор',
        ]);

        $manager = Bouncer::role()->create([
            'name' => 'manager',
            'title' => 'Управител',
        ]);

        $customer = Bouncer::role()->create([
            'name' => 'customer',
            'title' => 'Клиент',
        ]);
        

        $sellingProducts = Bouncer::ability()->create([
            'name' => 'selling-products',
            'title' => 'Извършване на продажби',
        ]);

        $manageOrders = Bouncer::ability()->create([
            'name' => 'manage-orders',
            'title' => 'Пускане и издаване на поръчки',
        ]);

        $manageRepairs = Bouncer::ability()->create([
            'name' => 'manage-repairs',
            'title' => 'Пускане и издаване на поръчки',
        ]);

        $sellingStatus = Bouncer::ability()->create([
            'name' => 'sellings-status',
            'title' => 'Справка за фискални продажби',
        ]);

        $jewelStatus = Bouncer::ability()->create([
            'name' => 'jewels-status',
            'title' => 'Справка за налични бижута',
        ]);

        $cashStatus = Bouncer::ability()->create([
            'name' => 'cash-status',
            'title' => 'Справка за налични пари в касата',
        ]);

        $materialStatus = Bouncer::ability()->create([
            'name' => 'materials-status',
            'title' => 'Справка за наличен материал',
        ]);

        $transferJewels = Bouncer::ability()->create([
            'name' => 'transfer-jewels',
            'title' => 'Tрансфер на бижута м/у обекти',
        ]);

        $editProducts = Bouncer::ability()->create([
            'name' => 'edit-products',
            'title' => 'Корекция на готово изделие',
        ]);

        $storeSale = Bouncer::ability()->create([
            'name' => 'store-sale',
            'title' => 'Сторниране на продажби',
        ]);

        $addingSafe = Bouncer::ability()->create([
            'name' => 'adding-safe',
            'title' => 'Въвеждане на разходи в касата',
        ]);

        $deleteProducts = Bouncer::ability()->create([
            'name' => 'delete-products',
            'title' => 'Изтриване на готово изделие',
        ]);

        $accessDashboard = Bouncer::ability()->create([
            'name' => 'access-dashboard',
            'title' => 'Влизане в админ панела',
        ]);

        //Admin permissions
        Bouncer::allow($admin)->to($sellingProducts);
        Bouncer::allow($admin)->to($manageOrders);
        Bouncer::allow($admin)->to($manageRepairs);
        Bouncer::allow($admin)->to($sellingStatus);
        Bouncer::allow($admin)->to($jewelStatus);
        Bouncer::allow($admin)->to($cashStatus);
        Bouncer::allow($admin)->to($materialStatus);
        Bouncer::allow($admin)->to($transferJewels);
        Bouncer::allow($admin)->to($editProducts);
        Bouncer::allow($admin)->to($storeSale);
        Bouncer::allow($admin)->to($addingSafe);
        Bouncer::allow($admin)->to($deleteProducts);
        Bouncer::allow($admin)->to($accessDashboard);

        //Manager permissions
        Bouncer::allow($manager)->to($sellingProducts);
        Bouncer::allow($manager)->to($manageOrders);
        Bouncer::allow($manager)->to($manageRepairs);
        Bouncer::allow($manager)->to($sellingStatus);
        Bouncer::allow($manager)->to($jewelStatus);
        Bouncer::allow($manager)->to($cashStatus);
        Bouncer::allow($manager)->to($materialStatus);
        Bouncer::allow($manager)->to($transferJewels);
        Bouncer::allow($manager)->to($editProducts);
        Bouncer::allow($manager)->to($storeSale);
        Bouncer::allow($manager)->to($addingSafe);
        Bouncer::allow($manager)->to($accessDashboard);

        //Merchant permissions 
        Bouncer::allow($merchant)->to($sellingProducts);
        Bouncer::allow($merchant)->to($manageOrders);
        Bouncer::allow($merchant)->to($manageRepairs);
        Bouncer::allow($merchant)->to($sellingStatus);
        Bouncer::allow($merchant)->to($jewelStatus);
        Bouncer::allow($merchant)->to($accessDashboard);

        $stores = new Store();
        $stores->name = 'Склад';
        $stores->location = 'София'; 
        $stores->phone = '0541587414178';
        $stores->save();

        for($i = 1; $i <= 5; $i++){
            $nomenclature = new Nomenclature();
            $nomenclature->name = 'Тестова '.$i;
            $nomenclature->save();

            $stone_styles = new StoneStyle();
            $stone_styles->name = 'Стил '.$i;
            $stone_styles->save();

            $stone_sizes = new StoneSize();
            $stone_sizes->name = 'Размер '.$i;
            $stone_sizes->save();

            $stone_contour = new StoneContour();
            $stone_contour->name = 'Контур '.$i;
            $stone_contour->save();

            $stores = new Store();
            $stores->name = 'Магазин '.$i;
            $stores->location = 'София'; 
            $stores->phone = '0541587414178';
            $stores->save();


            $stone = new Stone();
            $stone->nomenclature_id = $i;
            $stone->type = rand(1,2);
            $stone->weight = rand(1,5);
            $stone->carat = rand(1,5);
            $stone->size_id = rand(1,1);
            $stone->style_id = rand(1,1);
            $stone->contour_id = rand(1,1);
            $stone->store_id = 2;
            $stone->amount = rand(1,20);
            $stone->price = rand(20,45);
            $stone->save();

            $jewel = new Jewel();
            $jewel->name = 'Бижу '.$i;
            $jewel->save();
        }

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@uvel.com';
        $user->password = bcrypt('administrator');
        $user->store_id = 2;
        $user->save();

        Bouncer::assign('admin')->to($user);

        $merchant = new User();
        $merchant->name = 'Merchant';
        $merchant->email = 'merchant@uvel.com';
        $merchant->password = bcrypt('merchant');
        $merchant->store_id = 3;
        $merchant->save();

        Bouncer::assign('merchant')->to($merchant);

        $corporate_partner = new User();
        $corporate_partner->name = 'Partner';
        $corporate_partner->email = 'Partner@uvel.com';
        $corporate_partner->password = bcrypt('partner');
        $corporate_partner->store_id = 3;
        $corporate_partner->save();

        Bouncer::assign('corporate_partner')->to($corporate_partner);

        $partner = new Partner();
        $partner->user_id = $corporate_partner->id;
        $partner->money = 100;
        $partner->save();

        $material_type = new MaterialType();
        $material_type->name = 'Злато';
        $material_type->save();

        $material = new Material();
        $material->name = 'Злато';
        $material->code = '525';
        $material->color = 'Жълто';
        $material->carat = '14';
        $material->parent_id = 1;
        $material->stock_price = '24';
        $material->cash_group = 1;
        $material->save();

        $material_quantity = new MaterialQuantity();
        $material_quantity->material_id = $material->id;
        $material_quantity->quantity = 500;
        $material_quantity->store_id = 2;
        $material_quantity->save();

        $partner_material = new PartnerMaterial();
        $partner_material->partner_id = $partner->id;
        $partner_material->material_id = 1;
        $partner_material->quantity = 50;
        $partner_material->save();

        $price = new Price();
        $price->material_id = $material->id;
        $price->slug = 'Купува 1';
        $price->price = '30';
        $price->type = 'buy';
        $price->save();
        
        $price = new Price();
        $price->material_id = $material->id;
        $price->slug = 'Продава 1';
        $price->price = '90';
        $price->type = 'sell';
        $price->save();

        $material = new Material();
        $material->name = 'Сребро';
        $material->code = '925';
        $material->color = 'Сив';
        $material->carat = '14';
        $material->parent_id = 1;
        $material->stock_price = '24';
        $material->cash_group = 2;
        $material->save();

        $price = new Price();
        $price->material_id = $material->id;
        $price->slug = 'Купува 1';
        $price->price = '20';
        $price->type = 'buy';
        $price->save();
        
        $price = new Price();
        $price->material_id = $material->id;
        $price->slug = 'Продава 1';
        $price->price = '70';
        $price->type = 'sell';
        $price->save();

        $repairType = new RepairType();
        $repairType->name = 'Залепяне на камък';
        $repairType->price = '30';
        $repairType->save();

        $currency = new Currency();
        $currency->name = 'GBP';
        $currency->currency = '0.44';
        $currency->save();

        $currency = new Currency();
        $currency->name = 'USD';
        $currency->currency = '0.63';
        $currency->save();

        $currency = new Currency();
        $currency->name = 'EUR';
        $currency->currency = '0.51';
        $currency->save();

        $currency = new Currency();
        $currency->name = 'BGN';
        $currency->currency = '1';
        $currency->default = 'yes';
        $currency->save();


        $cashGroup = new CashGroup();
        $cashGroup->label = 'Ремонти';
        $cashGroup->table = 'repairs';
        $cashGroup->cash_group = 3;
        $cashGroup->save();

        $cashGroup = new CashGroup();
        $cashGroup->label = 'Поръчки';
        $cashGroup->table = 'orders';
        $cashGroup->cash_group = 4;
        $cashGroup->save();

        $cashGroup = new CashGroup();
        $cashGroup->label = 'Кутии';
        $cashGroup->table = 'products_others';
        $cashGroup->cash_group = 5;
        $cashGroup->save();
        
        // $model = new Model();
        // $model->name = 'Модел 1';
        // $model->jewel = 1;
        // $model->weight = 56;
        // $model->size = 56;
        // $model->workmanship = 3920;
        // $model->price = 5040;
        // $model->save();

        // $product = new Products();
        // $product->id = Uuid::generate()->string;
        // $product->name = 'Продукт 1';
        // $product->model = 1;
        // $product->jewel_type = 1;
        // $product->type = 1;
        // $product->retail_price = 2;
        // $product->weight = 56;
        // $product->size = 56;
        // $product->workmanship = 120;
        // $product->price = 210;
        // $product->code = 'PE0NM23K';
        // $product->barcode = 3807260069719;
        // $product->save();

        // $discount = new DiscountCode();
        // $discount->discount = 20;
        // $discount->lifetime = 'no';
        // $discount->code = '4RFI';
        // $discount->barcode = '3801863488922';
        // $discount->save();

        // $products_others_types = new ProductOtherType();
        // $products_others_types->name = 'Кутия';
        // $products_others_types->save();

        // $products_others = new ProductOther();
        // $products_others->name = 'Синя кутия';
        // $products_others->type = 1;
        // $products_others->price = 0.10;
        // $products_others->quantity = 200;
        // $products_others->store = 1;
        // $products_others->barcode = 3808345766226;
        // $products_others->code = 'BWGKIDKA';
        // $products_others->save();



        // $repair = new Repair();
        // $repair->type = 1;
        // $repair->barcode = 3806510024218;
        // $repair->repair_description = 'sadsd';
        // $repair->deposit = 10;
        // $repair->price = 20;
        // $repair->weight = 2.00;
        // $repair->code = 'RGV3IZPN';
        // $repair->status = 'repairing';
        // $repair->date_recieved = '30-04-2018'; 
        // $repair->date_returned = '24-05-2018';
        // $repair->customer_phone = '862589845';
        // $repair->customer_name = 'George Vasilev';
        // $repair->save();

        // $repair = new Repair();
        // $repair->type = 1;
        // $repair->barcode = 3805183846417;
        // $repair->repair_description = 'sadsd';
        // $repair->deposit = 10;
        // $repair->price = 20;
        // $repair->weight = 2.00;
        // $repair->code = 'RBPTA4YZ';
        // $repair->status = 'repairing';
        // $repair->date_recieved = '30-04-2018';
        // $repair->date_returned = '24-05-2018';
        // $repair->customer_phone = '862589845';
        // $repair->customer_name = 'George Vasilev';
        // $repair->save();

        // $repair = new Repair();
        // $repair->type = 1;
        // $repair->barcode = 3805926394014;
        // $repair->repair_description = 'sadsd';
        // $repair->deposit = 10;
        // $repair->price = 20;
        // $repair->weight = 2.00;
        // $repair->code = 'R8PAZKXM';
        // $repair->status = 'repairing';
        // $repair->date_recieved = '30-04-2018'; 
        // $repair->date_returned = '24-05-2018';
        // $repair->customer_phone = '862589845';
        // $repair->customer_name = 'George Vasilev';
        // $repair->save();
    }
}
