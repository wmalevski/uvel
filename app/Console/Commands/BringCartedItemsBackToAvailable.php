<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Product;
use Cart;

class BringCartedItemsBackToAvailable extends Command{

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'BringCartedItemsBackToAvailable';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command should be executed as a Cron Job. Check products in status Selling, with updated_at higher than 1 hour.';

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
		$products = Product::whereRaw('`status`="selling" AND `updated_at` < DATE_ADD(NOW(), INTERVAL -1 HOUR) ');
		if($products->count()>0){
			foreach($products->get() as $product){
				if($product->selling_to !== ''){ // Legacy support
					Cart::session($product->selling_to)->remove($product->barcode);
				}
				$product->selling_to = NULL;
				$product->status='available';
				$product->save();
			}
		}
	}
}