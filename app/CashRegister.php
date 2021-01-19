<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Currency;
use App\User;
use Auth;

class CashRegister extends Model{

	public $timestamps = false;

	protected $fillable = array(
		'date',
		'store_id',
		'income',
		'expenses',
		'total',
		'status'
	);

	protected $table = 'cash_register';
	protected $dates = ['date'];


	// The Currency ID for BGN
	static $default_currency = false;

	static $date,$store;

	function __construct(){
		// Set the Date for convenience
		CashRegister::$date = date('Y-m-d');

		// Set the default Store
		try{
			CashRegister::$store = Auth::user()->getStore()->id;
		}
		catch(Exception $e){
			CashRegister::$store = false;
		}

		// Get the currency ID for the default Currency (assumed BGN)
		CashRegister::$default_currency = Currency::where('default', 'yes')->first()->id;
	}

	/**
	 * Adds income calculation to the Cash Register table
	 *@method RecordIncome
	 *@param  int, float 	$sum         The number to be added to the records for the day
	 *@param  int || FALSE  $currency_id (OPTIONAL) The ID of the currency in use
	 *@param  int || FALSE  $store       (OPTIONAL) Store ID for the transaction
	*/
	public static function RecordIncome($sum, $currency_id, $store){
		$add = $sum;

		// Some tools don't use currency so we need to bypass this param with a FALSE
		if($currency_id == false){$currency_id = CashRegister::$default_currency;}

		// Store is not always passed
		if($store == false && CashRegister::$store !== false){$store = CashRegister::$store;}

		// If the passed sum is not in the default currency we need to convert it
		if($currency_id !== CashRegister::$default_currency){
			// Get conversion rate for the passed currency
			$conversion_rate = Currency::where('id', $currency_id)->first()->currency;
			// Do the "exchange" into Default currency
			$add = number_format($sum / $conversion_rate, 2, '.', '');
		}

		$register = CashRegister::firstOrNew(array('date'=>CashRegister::$date));

		$register->date = CashRegister::$date;
		$register->store_id = $store;
		$register->income += $add;

		// If status is NULL then this is a new record and we need to take the total of the previous work day for this store
		if($register->status == NULL){
			$previous_total = CashRegister::where('store_id', $store)->orderBy('date', 'DESC')->first()['total'];
			if($previous_total == NULL){ // No previous records for this store (probably right after setup)
				$previous_total = 0;
			}

			// Add the total of the previous day to today's total
			$register->total += $previous_total;

			$register->total += $add;

			$register->save();
		}
		else{
			$register->total += $add;

			CashRegister::where(array('date'=>CashRegister::$date, 'store_id'=>$store))->update(array(
			'income' => $register->income,
			'total' => $register->total
			));
		}

	}

	/**
	 * Adds Expense to the Cash Register and alters the Total accordingly
	 *@method RecordExpense
	 *@param  int, float 	$sum         The number to be added to the Expense column for the day
	 *@param  int || FALSE  $currency_id (OPTIONAL) The ID of the currency in use
	 *@param  int || FALSE  $store       (OPTIONAL) Store ID for the transaction
	 */
	public static function RecordExpense($sum, $currency_id, $store){
		$subtract = $sum;

		// Some tools don't use currency so we need to bypass this param with a FALSE
		if($currency_id == false){$currency_id = CashRegister::$default_currency;}

		// Store is not always passed
		if($store == false){$store = CashRegister::$store;}

		// If the passed sum is not in the default currency we need to convert it
		if($currency_id !== CashRegister::$default_currency){
			// Get conversion rate for the passed currency
			$conversion_rate = Currency::where('id', $currency_id)->first()->currency;
			// Do the "exchange" into Default currency
			$subtract = number_format($sum / $conversion_rate, 2, '.', '');
		}

		$register = CashRegister::firstOrNew(array('date'=>CashRegister::$date));

		$register->date = CashRegister::$date;
		$register->store_id = $store;
		$register->expenses += $subtract;

		// If status is NULL then this is a new record and we need to take the total of the previous work day for this store
		if($register->status == NULL){
			$previous_total = CashRegister::where('store_id', $store)->orderBy('date', 'DESC')->first()['total'];
			if($previous_total == NULL){ // No previous records for this store (probably right after setup)
				$previous_total = 0;
			}

			// Add the total of the previous day to today's total
			$register->total += $previous_total;

			$register->total -= $subtract;

			$register->save();
		}
		else{
			$register->total -= $subtract;

			CashRegister::where(array('date'=>CashRegister::$date, 'store_id'=>$store))->update(array(
			'expenses' => $register->expenses,
			'total' => $register->total
			));
		}
	}

	/**
	 * Function used when updating an Expense via /admin/expenses
	 */
	public static function updateExpense($old_currency, $new_currency, $old_sum, $new_sum){
		// No change on the currency and sum => no need to process this
		if($old_currency == $new_currency && $old_sum == $new_sum){return true;}


		$old_expense = $old_sum;
		$new_expense = $new_sum;

		// Ensure both sums are in the default currency
		if($old_currency !== CashRegister::$default_currency){
			// Get conversion rate for the passed currency
			$old_currency_conversion_rate = Currency::where('id', $old_currency)->first()->currency;
			// Do the "exchange" into Default currency
			$old_expense = number_format($old_sum / $old_currency_conversion_rate, 2, '.', '');
		}
		if($new_currency !== CashRegister::$default_currency){
			// Get conversion rate for the passed currency
			$new_currency_conversion_rate = Currency::where('id', $new_currency)->first()->currency;
			// Do the "exchange" into Default currency
			$new_expense = number_format($new_sum / $new_currency_conversion_rate, 2, '.', '');
		}


		$register = CashRegister::firstOrNew(array('date'=>CashRegister::$date, 'store_id'=>CashRegister::$store));

		// Negate the subtraction of the old expense
		$register->expenses -= $old_expense;
		$register->total += $old_expense;

		// Add the new expense
		$register->expenses += $new_expense;
		$register->total -= $new_expense;

		CashRegister::where(array('date'=>CashRegister::$date, 'store_id'=>CashRegister::$store))->update(array(
			'expenses' => $register->expenses,
			'total' => $register->total
		));
	}

	/**
	 * Function used to update Income via /admin/income
	 */
	public static function updateIncome($old_currency, $new_currency, $old_sum, $new_sum){
		// No change on the currency and sum => no need to process this
		if($old_currency == $new_currency && $old_sum == $new_sum){return true;}


		$old_income = $old_sum;
		$new_income = $new_sum;

		// Ensure both sums are in the default currency
		if($old_currency !== CashRegister::$default_currency){
			// Get conversion rate for the passed currency
			$old_currency_conversion_rate = Currency::where('id', $old_currency)->first()->currency;
			// Do the "exchange" into Default currency
			$old_income = number_format($old_sum / $old_currency_conversion_rate, 2, '.', '');
		}
		if($new_currency !== CashRegister::$default_currency){
			// Get conversion rate for the passed currency
			$new_currency_conversion_rate = Currency::where('id', $new_currency)->first()->currency;
			// Do the "exchange" into Default currency
			$new_income = number_format($new_sum / $new_currency_conversion_rate, 2, '.', '');
		}


		$register = CashRegister::firstOrNew(array('date'=>CashRegister::$date, 'store_id'=>CashRegister::$store));

		// Negate the old income of the total
		$register->income -= $old_income;
		$register->total -= $old_income;

		// Add the new income
		$register->income += $new_income;
		$register->total += $new_income;

		CashRegister::where(array('date'=>CashRegister::$date, 'store_id'=>CashRegister::$store))->update(array(
			'income' => $register->income,
			'total' => $register->total
		));
	}
}