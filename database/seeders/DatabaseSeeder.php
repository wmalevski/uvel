<?php
namespace Database\Seeders;

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
use App\ExpenseType;
use Database\Seeders\MaterialQuantitiesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([
            // MaterialQuantitiesSeeder::class,
            // DiscountCodePivotSeeder::class,
        // ]);

        // $admin = Bouncer::role()->create([
        //     'name' => 'admin',
        //     'title' => 'Админ',
        // ]);

        // $cashier = Bouncer::role()->create([
        //     'name' => 'cashier',
        //     'title' => 'Касиер',
        // ]);

        // $partner = Bouncer::role()->create([
        //     'name' => 'corporate_partner',
        //     'title' => 'Корпоративен Партньор',
        // ]);

        // $manager = Bouncer::role()->create([
        //     'name' => 'manager',
        //     'title' => 'Управител',
        // ]);

        // $customer = Bouncer::role()->create([
        //     'name' => 'customer',
        //     'title' => 'Клиент',
        // ]);

        // $storehouse = Bouncer::role()->create([
        //     'name' => 'storehouse',
        //     'title' => 'Склад',
        // ]);


        // $sellingProducts = Bouncer::ability()->create([
        //     'name' => 'selling-products',
        //     'title' => 'Извършване на продажби',
        // ]);

        // $manageOrders = Bouncer::ability()->create([
        //     'name' => 'manage-orders',
        //     'title' => 'Пускане и издаване на поръчки',
        // ]);

        // $manageRepairs = Bouncer::ability()->create([
        //     'name' => 'manage-repairs',
        //     'title' => 'Пускане и издаване на поръчки',
        // ]);

        // $sellingStatus = Bouncer::ability()->create([
        //     'name' => 'sellings-status',
        //     'title' => 'Справка за фискални продажби',
        // ]);

        // $jewelStatus = Bouncer::ability()->create([
        //     'name' => 'jewels-status',
        //     'title' => 'Справка за налични бижута',
        // ]);

        // $cashStatus = Bouncer::ability()->create([
        //     'name' => 'cash-status',
        //     'title' => 'Справка за налични пари в касата',
        // ]);

        // $materialStatus = Bouncer::ability()->create([
        //     'name' => 'materials-status',
        //     'title' => 'Справка за наличен материал',
        // ]);

        // $transferJewels = Bouncer::ability()->create([
        //     'name' => 'transfer-jewels',
        //     'title' => 'Tрансфер на бижута м/у обекти',
        // ]);

        // $editProducts = Bouncer::ability()->create([
        //     'name' => 'edit-products',
        //     'title' => 'Корекция на готово изделие',
        // ]);

        // $storeSale = Bouncer::ability()->create([
        //     'name' => 'store-sale',
        //     'title' => 'Сторниране на продажби',
        // ]);

        // $addingSafe = Bouncer::ability()->create([
        //     'name' => 'adding-safe',
        //     'title' => 'Въвеждане на разходи в касата',
        // ]);

        // $deleteProducts = Bouncer::ability()->create([
        //     'name' => 'delete-products',
        //     'title' => 'Изтриване на готово изделие',
        // ]);

        // $accessDashboard = Bouncer::ability()->create([
        //     'name' => 'access-dashboard',
        //     'title' => 'Влизане в админ панела',
        // ]);

        // //Admin permissions
        // Bouncer::allow($admin)->to($sellingProducts);
        // Bouncer::allow($admin)->to($manageOrders);
        // Bouncer::allow($admin)->to($manageRepairs);
        // Bouncer::allow($admin)->to($sellingStatus);
        // Bouncer::allow($admin)->to($jewelStatus);
        // Bouncer::allow($admin)->to($cashStatus);
        // Bouncer::allow($admin)->to($materialStatus);
        // Bouncer::allow($admin)->to($transferJewels);
        // Bouncer::allow($admin)->to($editProducts);
        // Bouncer::allow($admin)->to($storeSale);
        // Bouncer::allow($admin)->to($addingSafe);
        // Bouncer::allow($admin)->to($deleteProducts);
        // Bouncer::allow($admin)->to($accessDashboard);

        // //Manager permissions
        // Bouncer::allow($manager)->to($sellingProducts);
        // Bouncer::allow($manager)->to($manageOrders);
        // Bouncer::allow($manager)->to($manageRepairs);
        // Bouncer::allow($manager)->to($sellingStatus);
        // Bouncer::allow($manager)->to($jewelStatus);
        // Bouncer::allow($manager)->to($cashStatus);
        // Bouncer::allow($manager)->to($materialStatus);
        // Bouncer::allow($manager)->to($transferJewels);
        // Bouncer::allow($manager)->to($editProducts);
        // Bouncer::allow($manager)->to($storeSale);
        // Bouncer::allow($manager)->to($addingSafe);
        // Bouncer::allow($manager)->to($accessDashboard);

        // //Cashier permissions
        // Bouncer::allow($cashier)->to($sellingProducts);
        // Bouncer::allow($cashier)->to($manageOrders);
        // Bouncer::allow($cashier)->to($manageRepairs);
        // Bouncer::allow($cashier)->to($sellingStatus);
        // Bouncer::allow($cashier)->to($jewelStatus);
        // Bouncer::allow($cashier)->to($accessDashboard);

        // $stores = new Store();
        // $stores->name = 'Склад';
        // $stores->location = 'София';
        // $stores->phone = '0541587414178';
        // $stores->save();


        // $nomenclature = new Nomenclature();
        // $nomenclature->name = 'циркон';
        // $nomenclature->save();

        // $nomenclature = new Nomenclature();
        // $nomenclature->name = 'рубин';
        // $nomenclature->save();

        // $nomenclature = new Nomenclature();
        // $nomenclature->name = 'оникс';
        // $nomenclature->save();

        // $nomenclature = new Nomenclature();
        // $nomenclature->name = 'диамант';
        // $nomenclature->save();

        // $nomenclature = new Nomenclature();
        // $nomenclature->name = 'сапфир';
        // $nomenclature->save();

        // $nomenclature = new Nomenclature();
        // $nomenclature->name = 'смарагд';
        // $nomenclature->save();

        // $stone_styles = new StoneStyle();
        // $stone_styles->name = 'фасет';
        // $stone_styles->save();

        // $stone_styles = new StoneStyle();
        // $stone_styles->name = 'кабошон';
        // $stone_styles->save();

        // $stone_styles = new StoneStyle();
        // $stone_styles->name = 'плочка';
        // $stone_styles->save();

        // $stone_sizes = new StoneSize();
        // $stone_sizes->name = 'Размер';
        // $stone_sizes->save();

        // $stone_contour = new StoneContour();
        // $stone_contour->name = 'кръг';
        // $stone_contour->save();

        // $stone_contour = new StoneContour();
        // $stone_contour->name = 'овал';
        // $stone_contour->save();

        // $stone_contour = new StoneContour();
        // $stone_contour->name = 'квадрат';
        // $stone_contour->save();

        // $stone = new Stone();
        // $stone->nomenclature_id = 1;
        // $stone->type = rand(1,2);
        // $stone->weight = rand(1,5);
        // $stone->carat = rand(1,5);
        // $stone->size_id = rand(1,1);
        // $stone->style_id = rand(1,1);
        // $stone->contour_id = rand(1,1);
        // $stone->store_id = 2;
        // $stone->amount = rand(1,20);
        // $stone->price = rand(20,45);
        // $stone->save();


        // $stores = new Store();
        // $stores->name = 'Ювел';
        // $stores->location = 'София';
        // $stores->phone = '0541587414178';
        // $stores->save();

        // $stores = new Store();
        // $stores->name = 'Росица';
        // $stores->location = 'Пазарджик';
        // $stores->phone = '0541587414178';
        // $stores->save();

        // $stores = new Store();
        // $stores->name =  'Ювел';
        // $stores->location = 'Пазарджик';
        // $stores->phone = '0541587414178';
        // $stores->save();

        // $jewel = new Jewel();
        // $jewel->name = 'Дамски пръстен';
        // $jewel->save();

        // $jewel = new Jewel();
        // $jewel->name = 'Мъжки пръстен';
        // $jewel->save();

        // $jewel = new Jewel();
        // $jewel->name = 'Синджир';
        // $jewel->save();

        // $jewel = new Jewel();
        // $jewel->name = 'Гривна';
        // $jewel->save();

        // $jewel = new Jewel();
        // $jewel->name = 'Обици';
        // $jewel->save();

        // $jewel = new Jewel();
        // $jewel->name = 'Кръст';
        // $jewel->save();

        // $jewel = new Jewel();
        // $jewel->name = 'Медальон';
        // $jewel->save();

        // $jewel = new Jewel();
        // $jewel->name = 'Колие';
        // $jewel->save();

        // $user = new User();
        // $user->email = 'admin@uvel.com';
        // $user->role = 'admin';
        // $user->password = bcrypt('administrator');
        // $user->store_id = 2;
        // $user->save();

        // Bouncer::assign('admin')->to($user);

        // $cashier = new User();
        // $cashier->email = 'cashier@uvel.com';
        // $cashier->role = 'cashier';
        // $cashier->password = bcrypt('cashier');
        // $cashier->store_id = 3;
        // $cashier->save();

        // Bouncer::assign('cashier')->to($cashier);

        // $corporate_partner = new User();
        // $corporate_partner->email = 'Partner@uvel.com';
        // $corporate_partner->role = 'corporate_partner';
        // $corporate_partner->password = bcrypt('partner');
        // $corporate_partner->store_id = 3;
        // $corporate_partner->save();

        // Bouncer::assign('corporate_partner')->to($corporate_partner);

        // $partner = new Partner();
        // $partner->user_id = $corporate_partner->id;
        // $partner->money = 100;
        // $partner->save();

        // $material_type = new MaterialType();
        // $material_type->name = 'Злато';
        // $material_type->save();

        // $material = new Material();
        // $material->name = 'Злато';
        // $material->code = '585';
        // $material->color = 'Жълто';
        // $material->carat = '14';
        // $material->parent_id = 1;
        // $material->stock_price = '24';
        // $material->cash_group = 1;
        // $material->save();

        // $material_quantity = new MaterialQuantity();
        // $material_quantity->material_id = $material->id;
        // $material_quantity->quantity = 0;
        // $material_quantity->store_id = 1;
        // $material_quantity->save();

        // $material = new Material();
        // $material->name = 'Злато';
        // $material->code = '585';
        // $material->color = 'Бяло';
        // $material->carat = '14';
        // $material->parent_id = 1;
        // $material->stock_price = '24';
        // $material->cash_group = 1;
        // $material->save();

        // $material_quantity = new MaterialQuantity();
        // $material_quantity->material_id = $material->id;
        // $material_quantity->quantity = 0;
        // $material_quantity->store_id = 1;
        // $material_quantity->save();

        // $material_type = new MaterialType();
        // $material_type->name = 'Сребро';
        // $material_type->save();

        // $material = new Material();
        // $material->name = 'Сребро';
        // $material->code = '925';
        // $material->color = 'Бяло';
        // $material->parent_id = 2;
        // $material->stock_price = '24';
        // $material->cash_group = 1;
        // $material->save();

        // $material_quantity = new MaterialQuantity();
        // $material_quantity->material_id = $material->id;
        // $material_quantity->quantity = 0;
        // $material_quantity->store_id = 1;
        // $material_quantity->save();

        // $material = new Material();
        // $material->name = 'Злато';
        // $material->code = '750';
        // $material->color = 'Жълто';
        // $material->carat = '14';
        // $material->parent_id = 1;
        // $material->stock_price = '24';
        // $material->cash_group = 1;
        // $material->save();

        // $material_quantity = new MaterialQuantity();
        // $material_quantity->material_id = $material->id;
        // $material_quantity->quantity = 0;
        // $material_quantity->store_id = 1;
        // $material_quantity->save();

        // $material = new Material();
        // $material->name = 'Злато';
        // $material->code = '750';
        // $material->color = 'Бяло';
        // $material->carat = '14';
        // $material->parent_id = 1;
        // $material->stock_price = '24';
        // $material->cash_group = 1;
        // $material->save();

        // $material_quantity = new MaterialQuantity();
        // $material_quantity->material_id = $material->id;
        // $material_quantity->quantity = 500;
        // $material_quantity->store_id = 2;
        // $material_quantity->save();

        // $partner_material = new PartnerMaterial();
        // $partner_material->partner_id = $partner->id;
        // $partner_material->material_id = 1;
        // $partner_material->quantity = 50;
        // $partner_material->save();

        // $price = new Price();
        // $price->material_id = 1;
        // $price->slug = 'Купува 1';
        // $price->price = '56';
        // $price->type = 'buy';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 1;
        // $price->slug = 'Купува 2';
        // $price->price = '46';
        // $price->type = 'buy';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 1;
        // $price->slug = 'Продава 1';
        // $price->price = '80';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 1;
        // $price->slug = 'Продава 2';
        // $price->price = '86';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 1;
        // $price->slug = 'Продава 3';
        // $price->price = '90';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 2;
        // $price->slug = 'Купува 1';
        // $price->price = '56';
        // $price->type = 'buy';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 2;
        // $price->slug = 'Купува 2';
        // $price->price = '46';
        // $price->type = 'buy';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 2;
        // $price->slug = 'Продава 1';
        // $price->price = '80';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 2;
        // $price->slug = 'Продава 2';
        // $price->price = '86';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 2;
        // $price->slug = 'Продава 3';
        // $price->price = '90';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 3;
        // $price->slug = 'Купува 1';
        // $price->price = '1';
        // $price->type = 'buy';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 3;
        // $price->slug = 'Купува 2';
        // $price->price = '1';
        // $price->type = 'buy';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 3;
        // $price->slug = 'Продава 1';
        // $price->price = '10';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 3;
        // $price->slug = 'Продава 2';
        // $price->price = '15';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 3;
        // $price->slug = 'Продава 3';
        // $price->price = '20';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 4;
        // $price->slug = 'Купува 1';
        // $price->price = '72';
        // $price->type = 'buy';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 4;
        // $price->slug = 'Купува 2';
        // $price->price = '59';
        // $price->type = 'buy';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 4;
        // $price->slug = 'Продава 1';
        // $price->price = '103';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 4;
        // $price->slug = 'Продава 2';
        // $price->price = '110';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 4;
        // $price->slug = 'Продава 3';
        // $price->price = '115';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 5;
        // $price->slug = 'Купува 1';
        // $price->price = '72';
        // $price->type = 'buy';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 5;
        // $price->slug = 'Купува 2';
        // $price->price = '59';
        // $price->type = 'buy';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 5;
        // $price->slug = 'Продава 1';
        // $price->price = '103';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 5;
        // $price->slug = 'Продава 2';
        // $price->price = '110';
        // $price->type = 'sell';
        // $price->save();

        // $price = new Price();
        // $price->material_id = 5;
        // $price->slug = 'Продава 3';
        // $price->price = '115';
        // $price->type = 'sell';
        // $price->save();

        // $repairType = new RepairType();
        // $repairType->name = 'Залепяне на камък';
        // $repairType->price = '30';
        // $repairType->save();

        // $currency = new Currency();
        // $currency->name = 'GBP';
        // $currency->currency = '0.44';
        // $currency->save();

        // $currency = new Currency();
        // $currency->name = 'USD';
        // $currency->currency = '0.63';
        // $currency->save();

        // $currency = new Currency();
        // $currency->name = 'EUR';
        // $currency->currency = '0.51';
        // $currency->save();

        // $currency = new Currency();
        // $currency->name = 'BGN';
        // $currency->currency = '1';
        // $currency->default = 'yes';
        // $currency->save();


        // $cashGroup = new CashGroup();
        // $cashGroup->label = 'Ремонти';
        // $cashGroup->cash_group = 3;
        // $cashGroup->save();

        // $cashGroup = new CashGroup();
        // $cashGroup->label = 'Поръчки';
        // $cashGroup->cash_group = 4;
        // $cashGroup->save();

        // $cashGroup = new CashGroup();
        // $cashGroup->label = 'Кутии';
        // $cashGroup->cash_group = 5;
        // $cashGroup->save();

        // $expense_type = new ExpenseType();
        // $expense_type->name = 'Други';
        // $expense_type->save();

    }
}
