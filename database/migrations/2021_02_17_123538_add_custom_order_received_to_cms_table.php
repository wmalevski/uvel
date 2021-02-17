<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\CMS;

class AddCustomOrderReceivedToCmsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		$cms = new CMS();
		$cms::insert(array(array(
			'key' => 'customOrderReceived',
				'value' => 'PGgyIHN0eWxlPSJ0ZXh0LWFsaWduOiBjZW50ZXI7Zm9udC13ZWlnaHQ6IGJvbGQiPtCS0LDRiNCw0YLQsCDQv9C+0YDRitGH0LrQsCDQsdC1INGD0YHQv9C10YjQvdC+INC40LfQv9GA0LDRgtC10L3QsCE8L2gyPjxwIHN0eWxlPSJ0ZXh0LWFsaWduOiBsZWZ0OyI+0JHQu9Cw0LPQvtC00LDRgNC40Lwg0JLQuCDQt9CwINC/0L7RgNGK0YfQutCw0YLQsCEg0J3QsNGIINC/0YDQtdC00YHRgtCw0LLQuNGC0LXQuyDRidC1INGB0LUg0YHQstGK0YDQttC1INGBINCy0LDRgSDQv9GA0Lgg0L/RitGA0LLQsCDQstGK0LfQvNC+0LbQvdC+0YHRgiDQt9CwINC/0L7RgtCy0YrRgNC20LTQtdC90LjQtS48L3A+',
				'friendly_name' => 'Съобщение "По Ваш Модел"'
		)));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		$cms = new CMS();
		$cms::where('key','customOrderReceived')->delete();
	}
}