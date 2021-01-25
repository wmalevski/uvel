<?php

namespace App\Console\Commands;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Console\Command;

use App\Product;

class GenerateBarcodes extends Command{

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'GenerateBarcodes';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate Barcode for any Products, Product_Others, or Model Products missing Barcodes';

	protected $supportedTypes = array(
		'Modules' => 'App\Model',
		'Products' => 'App\Product',
		'Boxes' => 'App\ProductOther'
	);

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(){
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(){
		foreach($this->supportedTypes as $name=>$class){
			$this->process($name,$class);
		}
		echo PHP_EOL."All Done. Bye!".PHP_EOL;
	}

	public function process($name, $class){
		echo PHP_EOL."Checking for ".$name." without any Barcode ... ";
		$items = $class::where(array('barcode'=>NULL))->orWhere(array('barcode'=>''));
		$itemCount = $items->count();
		echo "[DONE]".PHP_EOL."\tFound [".$itemCount."]".PHP_EOL;
		if($itemCount > 0){
			echo "Generating Barcodes for them ...";
			foreach($items->get() as $k=>$v){
				echo ".";
				$v->barcode = $this->generateBarcode('models');
				$v->save();
			}
			echo PHP_EOL."[DONE]".PHP_EOL;
		}
	}

	private function generateBarcode($type){
		$bar = '380'.unique_number($type, 'barcode', 7).'1';
		$digits =(string)$bar;
		$even_sum = $digits[1]+$digits[3]+$digits[5]+$digits[7]+$digits[9]+$digits[11];
        $even_sum_three = $even_sum*3;
        $odd_sum = $digits[0]+$digits[2]+$digits[4]+$digits[6]+$digits[8]+$digits[10];
        $total_sum = $even_sum_three+$odd_sum;
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten-$total_sum;
        return $digits.$check_digit;
	}
}