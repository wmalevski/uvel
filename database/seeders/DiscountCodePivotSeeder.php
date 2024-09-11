<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\DiscountCode;
use Illuminate\Support\Facades\DB;

class DiscountCodePivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discountCodes = DiscountCode::select('id', 'user_id')->get();
        $data = [];
        foreach ($discountCodes as $key => $code) {
            $data[$key]['discount_code_id'] = $code->id;
            $data[$key]['user_id'] = $code->user_id;
        }

        DB::table('discountcode_user')->insert($data);
    }
}
