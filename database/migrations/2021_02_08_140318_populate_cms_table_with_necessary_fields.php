<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\CMS;

class PopulateCmsTableWithNecessaryFields extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		$cms = new CMS();
		$cms::insert(array(
			array(
				'key' => 'about_us',
				'value' => 'PHA+0JHQuNC20YPRgtC10YDRgdC60LAg0LrRitGJ0LAgIlVWRUwiINC1INGB0LXQvNC10LnQvdCwINGE0LjRgNC80LAsINC+0YHQvdC+0LLQsNC90LAg0L/RgNC10LcgMTk5MNCzLiDQsiDQs9GALtCf0LDQt9Cw0YDQtNC20LjQuiwg0LrQsNGC0L4g0L/RgNC+0LTRitC70LbQtdC90LjQtSDQvdCwINC00LXRgdC10YLQuNC70LXRgtC90LjRgtC1INC30LvQsNGC0LDRgNGB0LrQuCDQuCDRh9Cw0YHQvtCy0L3QuNC60LDRgNGB0LrQuCDRgtGA0LDQtNC40YbQuNC4INC90LAg0LzQtdGB0YLQvdCw0YLQsCDRhNCw0LzQuNC70LjRjyDQlNC10YfQtdCy0LguPC9wPg0KPHA+0J/RgNC40YLQtdC20LDQstCwINGB0L7QsdGB0YLQstC10L3QsCDRgNCw0LHQvtGC0LjQu9C90LjRhtCwINGBINC/0YrQu9C10L0g0L/RgNC+0LjQt9Cy0L7QtNGB0YLQstC10L0g0YbQuNC60YrQuywg0LTQstCwINGE0LjRgNC80LXQvdC4INC80LDQs9Cw0LfQuNC90LAg0LIg0LPRgNCw0LQg0J/QsNC30LDRgNC00LbQuNC6ICwg0LXQtNC40L0g0LIg0LPRgNCw0LQg0KHQvtGE0LjRjyDQuCDQt9Cw0YDQtdC20LTQsCDRgtGK0YDQs9C+0LLRhtC4INC+0YIg0YbRj9C70LDRgtCwINGB0YLRgNCw0L3QsCDQuCDRh9GD0LbQsdC40L3QsC48L3A+DQo8cD7QmNC30L/RitC70L3Rj9Cy0LDQu9CwINC1INGB0L/QtdGG0LjQsNC70L3QuCDQv9C+0YDRitGH0LrQuCDQt9CwINCx0LjQttGD0YLQtdGA0YHQutC4INCy0LXRgNC40LPQuCDQvtGCINCb0L7QvdC00L7QvSDQuCDQn9Cw0YDQuNC2LjwvcD4NCjxwPtCk0LjRgNC80LDRgtCwINGB0LUg0YPQv9GA0LDQstC70Y/QstCwINC+0YIg0LTQstCw0LzQsCDQsdGA0LDRgtGPINCV0LzQuNC7INCU0LXRh9C10LIg0Lgg0JLQu9Cw0LTQuNC80LjRgCDQlNC10YfQtdCyLjwvcD4NCjxoMz7Qk9Cw0YDQsNC90YbQuNGPPC9oMz4NCjxwPtCj0LLQsNC20LDQtdC80Lgg0LrQu9C40LXQvdGC0LgsINCS0LDRiNC10YLQviDQsdC40LbRgyDQtSDQv9GA0L7QstC10YDQtdC90L4g0Lgg0LzQsNGA0LrQuNGA0LDQvdC+INGBINC00YrRgNC20LDQstC10L0g0LfQvdCw0Log0L7RgiDRgdC/0LXRhtC40LDQu9C40LfQuNGA0LDQvdCwINC70LDQsdC+0YDQsCDRgtC+0YDQuNGPINC60YrQvCDQnNC40L3QuNGB0YLQtdGA0YHRgtCy0L4g0L3QsCDRhNC40L3QsNC90YHQuNGC0LUuPC9wPg0KPHA+IlV2ZWwiINC/0L7QtdC80LAg0LXQtNC90L7Qs9C+0LTQuNGI0L3QsCDQs9Cw0YDQsNC90YbQuNGPINC4INCx0LXQt9C/0LvQsNGC0LXQvSDRgNC10LzQvtC90YIg0LfQsCDQstGB0LjRh9C60Lgg0YHQstC+0Lgg0LjQt9C00LXQu9C40Y8sINC+0YHQstC10L0g0LIg0YHQu9GD0YfQsNC5INC90LAg0L7Rh9C10LLQuNC00L3QsCDQstGK0L3RiNC90LAg0LjQvdGC0LXRgNCy0LXQvdGG0LjRjy48L3A+DQo8cD7Qo9C60LDQt9Cw0L3QvtGC0L4g0YLQtdCz0LvQviDQvdCwINC30LvQsNGC0L3QuNGC0LUg0LjQt9C00LXQu9C40Y8g0LUg0YfQuNGB0YLQviwg0L7RgiDQvdC10LPQviDQtSDQv9C+0LTQstCw0LTQtdC9INCz0YDQsNC80LDQttCwINC90LAg0LrQsNC80YrQvdC40YLQtS48L3A+DQo8cD7QkdC70LDQs9C+0LTQsNGA0LjQvCDQktC4LCDRh9C1INC40LfQsdC40YDQsNGC0LUg0LHQuNC20YPRgtCw0YLQsCDQvdCwICJVdmVsIiE8L3A+DQo8cD5VVkVMINC00LDQstCwIDEg0LPQvtC00LjQvdCwINCz0LDRgNCw0L3RhtC40Y88L3A+DQo8aDM+0KbQtdC90Lg8L2gzPg0KPHA+0J7QkdCg0JDQkdCe0KLQldCd0J4g0JfQm9CQ0KLQniAxNCDQutCw0YDQsNGC0LAgKDU4NSkt0YHRgNC10LTQvdCwINGG0LXQvdCwIDogNjgtNzgg0LvQsi/Qs9GALjwvcD4NCjxwPtCV0LTQuNC90LjRh9C90LDRgtCwINGG0LXQvdCwINC90LAg0LLRgdGP0LrQviDQsdC40LbRgyDQt9Cw0LLQuNGB0Lgg0L7RgiDRgdC70L7QttC90L7RgdGC0YLQsCDQvdCwINC40LfRgNCw0LHQvtGC0LrQsNGC0LA8L3A+DQo8cD7QntCR0JzQr9Cd0JA6INCz0YDQsNC8INC30LAg0LPRgNCw0LwgKyDQtNC+0L/Qu9Cw0YnQsNC90LUg0L3QsCDQuNC30YDQsNCx0L7RgtC60LDRgtCwPC9wPg0KPHA+0KHQoNCV0JTQndCQINCY0JfQoNCQ0JHQntCi0JrQkCA6IDI00LvQsi/Qs9GALjwvcD4NCjxwPiJVVkVMIiDQv9GA0L7QtNCw0LLQsCDQp9CY0KHQotCeINCi0JXQk9Cb0J4g0L3QsCDQt9C70LDRgtC+0YLQvjwvcD4NCjxwPtCi0LXQs9C70L7RgtC+INC90LAg0LLRgdC40YfQutC4INC60LDQvNGK0L3QuCDQtSDQv9C+0LTQstCw0LTQtdC90L4g0L7RgiDQs9GA0LDQvNCw0LbQsCDQvdCwINC40LfQtNC10LvQuNGP0YLQsDwvcD4NCjxwPtCY0JfQmtCj0J/Qo9CS0JDQndCVINC90LAg0LfQu9Cw0YLQvijQvNCw0YLQtdGA0LjQsNC7KSA9IDM4INC70LIv0LPRgC48L3A+DQo8cD7QptC10L3QuCDQvdCwINC80LXQttC00YPQvdCw0YDQvtC00L3QuCDQsdC+0YDRgdC4OiB3d3cua2l0Y28uY29tPC9wPg0KPHA+0KbQtdC90Lgg0L3QsCDRgNC10LzQvtC90YLQuCDRgtGD0Lo8L3A+DQo8cD5VVkVMINC00LDQstCwIDEg0LPQvtC00LjQvdCwINCz0LDRgNCw0L3RhtC40Y8hPC9wPg==',
				'friendly_name' => 'За Нас'
			),
			array(
				'key' => 'cookies_policy',
				'value' => 'PHA+0J/RgNC40LzQtdGA0LXQvSDRgtC10LrRgdGCINC30LAgPGI+0J/QvtC70LjRgtC40LrQsCDQl9CwINCR0LjRgdC60LLQuNGC0LrQuDwvYj48L3A+PHA+0KLQtdC60YHRgtCwINC80L7QttC1INC00LAg0LHRitC00LUg0L/RgNC+0LzQtdC90LXQvSDQvtGCIDxiPtCh0LjRgdGC0LXQvNCwIDwvYj4tJmd0OyA8Yj7QndCw0YHRgtGA0L7QudC60LgmbmJzcDs8L2I+PHNwYW4gc3R5bGU9ImxldHRlci1zcGFjaW5nOiAwLjJweDsgZm9udC1mYW1pbHk6IFJvYm90bywgLWFwcGxlLXN5c3RlbSwgc3lzdGVtLXVpLCBCbGlua01hY1N5c3RlbUZvbnQsICIgc2Vnb2U9IiIgdWkiLD0iIiBveHlnZW4sPSIiIHVidW50dSw9IiIgY2FudGFyZWxsLD0iIiAiZmlyYT0iIiBzYW5zIiw9IiIgImRyb2lkPSIiICJoZWx2ZXRpY2E9IiIgbmV1ZSIsPSIiIGFyaWFsLD0iIiBzYW5zLXNlcmlmOyI9IiI+LSZndDsgPGI+0JjQvdGE0L7RgNC80LDRhtC40L7QvdC90Lgg0LHQu9C+0LrQvtCy0LU8L2I+Jm5ic3A7PC9zcGFuPjxzcGFuIHN0eWxlPSJsZXR0ZXItc3BhY2luZzogMC4ycHg7IGZvbnQtZmFtaWx5OiBSb2JvdG8sIC1hcHBsZS1zeXN0ZW0sIHN5c3RlbS11aSwgQmxpbmtNYWNTeXN0ZW1Gb250LCAiIHNlZ29lPSIiIHVpIiw9IiIgb3h5Z2VuLD0iIiB1YnVudHUsPSIiIGNhbnRhcmVsbCw9IiIgImZpcmE9IiIgc2FucyIsPSIiICJkcm9pZD0iIiAiaGVsdmV0aWNhPSIiIG5ldWUiLD0iIiBhcmlhbCw9IiIgc2Fucy1zZXJpZjsiPSIiPi0mZ3Q7IDxiPtCf0L7Qu9C40YLQuNC60LAg0JfQsCDQkdC40YHQutCy0LjRgtC60Lg8L2I+PC9zcGFuPjwvcD48dWw+DQo8L3VsPg==',
				'friendly_name' => 'Политика за Бисквитки'
			),
			array(
				'key' => 'delivery_info',
				'value' => 'PHA+0J/RgNC40LzQtdGA0LXQvSDRgtC10LrRgdGCINC30LAgPGI+0JjQvdGE0L7RgNC80LDRhtC40Y8g0LfQsCDQlNC+0YHRgtCw0LLQutCwPC9iPjwvcD48cD7QotC10LrRgdGC0LAg0LzQvtC20LUg0LTQsCDQsdGK0LTQtSDQv9GA0L7QvNC10L3QtdC9INC+0YIgPGI+0KHQuNGB0YLQtdC80LAgPC9iPi0mZ3Q7IDxiPtCd0LDRgdGC0YDQvtC50LrQuCZuYnNwOzwvYj48c3BhbiBzdHlsZT0ibGV0dGVyLXNwYWNpbmc6IDAuMnB4OyBmb250LWZhbWlseTogUm9ib3RvLCAtYXBwbGUtc3lzdGVtLCBzeXN0ZW0tdWksIEJsaW5rTWFjU3lzdGVtRm9udCwgIiBzZWdvZT0iIiB1aSIsPSIiIG94eWdlbiw9IiIgdWJ1bnR1LD0iIiBjYW50YXJlbGwsPSIiICJmaXJhPSIiIHNhbnMiLD0iIiAiZHJvaWQ9IiIgImhlbHZldGljYT0iIiBuZXVlIiw9IiIgYXJpYWwsPSIiIHNhbnMtc2VyaWY7Ij0iIj4tJmd0OyA8Yj7QmNC90YTQvtGA0LzQsNGG0LjQvtC90L3QuCDQsdC70L7QutC+0LLQtTwvYj4mbmJzcDs8L3NwYW4+PHNwYW4gc3R5bGU9ImxldHRlci1zcGFjaW5nOiAwLjJweDsgZm9udC1mYW1pbHk6IFJvYm90bywgLWFwcGxlLXN5c3RlbSwgc3lzdGVtLXVpLCBCbGlua01hY1N5c3RlbUZvbnQsICIgc2Vnb2U9IiIgdWkiLD0iIiBveHlnZW4sPSIiIHVidW50dSw9IiIgY2FudGFyZWxsLD0iIiAiZmlyYT0iIiBzYW5zIiw9IiIgImRyb2lkPSIiICJoZWx2ZXRpY2E9IiIgbmV1ZSIsPSIiIGFyaWFsLD0iIiBzYW5zLXNlcmlmOyI9IiI+LSZndDsgPGI+0JjQvdGE0L7RgNC80LDRhtC40Y8g0LfQsCDQlNC+0YHRgtCw0LLQutCwPC9iPjwvc3Bhbj48L3A+PHVsPg0KPC91bD4=',
				'friendly_name' => 'Информация за Доставка'
			),
			array(
				'key' => 'exchange_info',
				'value' => 'PHA+0J/RgNC40LzQtdGA0LXQvSDRgtC10LrRgdGCINC30LAgPGI+0JjQvdGE0L7RgNC80LDRhtC40Y8g0LfQsCDQntCx0LzRj9C90LA8L2I+PC9wPjxwPtCi0LXQutGB0YLQsCDQvNC+0LbQtSDQtNCwINCx0YrQtNC1INC/0YDQvtC80LXQvdC10L0g0L7RgiA8Yj7QodC40YHRgtC10LzQsCA8L2I+LSZndDsgPGI+0J3QsNGB0YLRgNC+0LnQutC4Jm5ic3A7PC9iPjxzcGFuIHN0eWxlPSJsZXR0ZXItc3BhY2luZzogMC4ycHg7IGZvbnQtZmFtaWx5OiBSb2JvdG8sIC1hcHBsZS1zeXN0ZW0sIHN5c3RlbS11aSwgQmxpbmtNYWNTeXN0ZW1Gb250LCAiIHNlZ29lPSIiIHVpIiw9IiIgb3h5Z2VuLD0iIiB1YnVudHUsPSIiIGNhbnRhcmVsbCw9IiIgImZpcmE9IiIgc2FucyIsPSIiICJkcm9pZD0iIiAiaGVsdmV0aWNhPSIiIG5ldWUiLD0iIiBhcmlhbCw9IiIgc2Fucy1zZXJpZjsiPSIiPi0mZ3Q7IDxiPtCY0L3RhNC+0YDQvNCw0YbQuNC+0L3QvdC4INCx0LvQvtC60L7QstC1PC9iPiZuYnNwOzwvc3Bhbj48c3BhbiBzdHlsZT0ibGV0dGVyLXNwYWNpbmc6IDAuMnB4OyBmb250LWZhbWlseTogUm9ib3RvLCAtYXBwbGUtc3lzdGVtLCBzeXN0ZW0tdWksIEJsaW5rTWFjU3lzdGVtRm9udCwgIiBzZWdvZT0iIiB1aSIsPSIiIG94eWdlbiw9IiIgdWJ1bnR1LD0iIiBjYW50YXJlbGwsPSIiICJmaXJhPSIiIHNhbnMiLD0iIiAiZHJvaWQ9IiIgImhlbHZldGljYT0iIiBuZXVlIiw9IiIgYXJpYWwsPSIiIHNhbnMtc2VyaWY7Ij0iIj4tJmd0OyA8Yj7QmNC90YTQvtGA0LzQsNGG0LjRjyDQt9CwINCe0LHQvNGP0L3QsDwvYj48L3NwYW4+PC9wPjx1bD4NCjwvdWw+',
				'friendly_name' => 'Информация за Обмяна'
			),
			array(
				'key' => 'privacy_policy',
				'value' => 'PHA+0J/RgNC40LzQtdGA0LXQvSDRgtC10LrRgdGCINC30LAgPGI+0J/QvtC70LjRgtC40LrQsCDQl9CwINCf0L7QstC10YDQuNGC0LXQu9C90L7RgdGCPC9iPjwvcD48cD7QotC10LrRgdGC0LAg0LzQvtC20LUg0LTQsCDQsdGK0LTQtSDQv9GA0L7QvNC10L3QtdC9INC+0YIgPGI+0KHQuNGB0YLQtdC80LAgPC9iPi0+IDxiPtCd0LDRgdGC0YDQvtC50LrQuMKgPC9iPjxzcGFuIHN0eWxlPSJsZXR0ZXItc3BhY2luZzogMC4ycHg7IGZvbnQtZmFtaWx5OiBSb2JvdG8sIC1hcHBsZS1zeXN0ZW0sIHN5c3RlbS11aSwgQmxpbmtNYWNTeXN0ZW1Gb250LCAiU2Vnb2UgVUkiLCBPeHlnZW4sIFVidW50dSwgQ2FudGFyZWxsLCAiRmlyYSBTYW5zIiwgIkRyb2lkIFNhbnMiLCAiSGVsdmV0aWNhIE5ldWUiLCBBcmlhbCwgc2Fucy1zZXJpZjsiPi0+IDxiPtCY0L3RhNC+0YDQvNCw0YbQuNC+0L3QvdC4INCx0LvQvtC60L7QstC1PC9iPsKgPC9zcGFuPjxzcGFuIHN0eWxlPSJsZXR0ZXItc3BhY2luZzogMC4ycHg7IGZvbnQtZmFtaWx5OiBSb2JvdG8sIC1hcHBsZS1zeXN0ZW0sIHN5c3RlbS11aSwgQmxpbmtNYWNTeXN0ZW1Gb250LCAiU2Vnb2UgVUkiLCBPeHlnZW4sIFVidW50dSwgQ2FudGFyZWxsLCAiRmlyYSBTYW5zIiwgIkRyb2lkIFNhbnMiLCAiSGVsdmV0aWNhIE5ldWUiLCBBcmlhbCwgc2Fucy1zZXJpZjsiPi0+IDxiPtCf0L7Qu9C40YLQuNC60LAg0JfQsCDQn9C+0LLQtdGA0LjRgtC10LvQvdC+0YHRgjwvYj48L3NwYW4+PC9wPjx1bD4NCjwvdWw+',
				'friendly_name' => 'Политика за Поверителност'
			),
			array(
				'key' => 'sizes',
				'value' => 'PHA+0J/RgNC40LzQtdGA0LXQvSDRgtC10LrRgdGCINC30LAgPGI+0JjQvdGE0L7RgNC80LDRhtC40Y8g0LfQsCDQotCw0LHQu9C40YbQsCDRgSDQoNCw0LfQvNC10YDQuDwvYj48L3A+PHA+0KLQtdC60YHRgtCwINC80L7QttC1INC00LAg0LHRitC00LUg0L/RgNC+0LzQtdC90LXQvSDQvtGCIDxiPtCh0LjRgdGC0LXQvNCwIDwvYj4tPiA8Yj7QndCw0YHRgtGA0L7QudC60LjCoDwvYj48c3BhbiBzdHlsZT0ibGV0dGVyLXNwYWNpbmc6IDAuMnB4OyBmb250LWZhbWlseTogUm9ib3RvLCAtYXBwbGUtc3lzdGVtLCBzeXN0ZW0tdWksIEJsaW5rTWFjU3lzdGVtRm9udCwgIiBzZWdvZT0iIiB1aSIsPSIiIG94eWdlbiw9IiIgdWJ1bnR1LD0iIiBjYW50YXJlbGwsPSIiICJmaXJhPSIiIHNhbnMiLD0iIiAiZHJvaWQ9IiIgImhlbHZldGljYT0iIiBuZXVlIiw9IiIgYXJpYWwsPSIiIHNhbnMtc2VyaWY7Ij0iIj4tPiA8Yj7QmNC90YTQvtGA0LzQsNGG0LjQvtC90L3QuCDQsdC70L7QutC+0LLQtTwvYj7CoDwvc3Bhbj48c3BhbiBzdHlsZT0ibGV0dGVyLXNwYWNpbmc6IDAuMnB4OyBmb250LWZhbWlseTogUm9ib3RvLCAtYXBwbGUtc3lzdGVtLCBzeXN0ZW0tdWksIEJsaW5rTWFjU3lzdGVtRm9udCwgIiBzZWdvZT0iIiB1aSIsPSIiIG94eWdlbiw9IiIgdWJ1bnR1LD0iIiBjYW50YXJlbGwsPSIiICJmaXJhPSIiIHNhbnMiLD0iIiAiZHJvaWQ9IiIgImhlbHZldGljYT0iIiBuZXVlIiw9IiIgYXJpYWwsPSIiIHNhbnMtc2VyaWY7Ij0iIj4tPiA8Yj7QotCw0LHQu9C40YbQsCDRgSDQoNCw0LfQvNC10YDQuDwvYj48L3NwYW4+PC9wPjx1bD4NCjwvdWw+',
				'friendly_name' => 'Таблица с Размери'
			)
		));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		$cms = new CMS();
		$cms::whereIn('key',array('about_us','cookies_policy','delivery_info','exchange_info','privacy_policy','sizes'))->delete();
	}
}