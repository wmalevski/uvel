<?php

namespace App;

use App\Gallery;
use App\Jewel;
use App\MaterialQuantity;
use App\Model as DefModel;
use App\ModelOption;
use App\Price;
use App\Stone;
use App\StoneContour;
use App\StoneSize;
use App\StoneStyle;
use Auth;
use File;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Mavinoo\Batch\Traits\HasBatch;
use Response;

class Product extends BaseModel
{
  use SoftDeletes, HasBatch;

  protected $fillable = [
    'id',
    'model',
    'type',
    'weight',
    'retail_price',
    'size',
    'workmanship',
    'price',
    'material_type_id',
    'model_id'
  ];

  protected $casts = ['deleted_at'];

  protected $table = 'products';

  public function model()
  {
    return $this->belongsTo('App\Model');
  }

  public function comments()
  {
    return $this->hasMany('App\Comment');
  }

  public function jewel()
  {
    return $this->belongsTo('App\Jewel');
  }

  public function photos()
  {
    return $this->hasMany('App\Gallery');
  }

  public function material()
  {
    return $this->belongsTo('App\Material');
  }

  public function stones()
  {
    return $this->hasMany('App\ProductStone');
  }

  public function retailPrice()
  {
    return $this->belongsTo('App\Price')->withTrashed();
  }

  public function reviews()
  {
    return $this->hasMany('App\Review');
  }

  public function wishLists()
  {
    return $this->hasMany('App\WishList');
  }

  public function orederItem()
  {
    return $this->belongsTo('App\OrderItem', 'product_id');
  }

  public function store_info()
  {
    return $this->belongsTo('App\Store', 'store_id');
  }

  public function chainedSelects(Model $model)
  {
    $materials = Material::take(env('SELECT_PRELOADED'))->get();
    $default = $model->options->where('default', 'yes')->first();

    if ($model) {
      $jewels = Jewel::take(env('SELECT_PRELOADED'))->get();
      $model_stones = $model->stones;
      $model_photos = $model->photos;
      $models = Model::take(env('SELECT_PRELOADED'))->get();

      if ($default) {
        $retail_prices = $default->material->pricesSell;

        $pass_jewels = array();

        foreach ($jewels as $jewel) {
          if ($jewel->id == $model->jewel_id) {
            $pass_jewels[] = (object) [
              'label' => $jewel->name,
              'attributes' => [
                'value' => $jewel->id,
              ]
            ];
          }
        }

        $prices_retail = array();

        foreach ($retail_prices as $price) {
          if ($price->id == $default->retail_price_id) {
            $prices_retail[] = (object) [
              'label' => $price->slug . ' - ' . $price->price . 'лв',
              'price' => $price->price,
              'attributes' => [
                'value' => $price->id,
              ]
            ];
          }
        }
      }

      $pass_models = array();

      foreach ($models as $modelp) {
        if ($model->id == $modelp->id) {
          $selected = true;

          $pass_models[] = [
            'label' => $modelp->name,
            'attributes' => [
              'value' => $modelp->id,
            ]
          ];
        }
      }


      $pass_materials = array();

      foreach ($materials as $material) {
        if ($material->id == $default->material->id) {
          if (count($material->pricesSell)) {
            $pass_materials[] = (object) [
              'label' => $material->parent->name . ' - ' . $material->color . ' - ' . $material->code,
              'attributes' => [
                'value' => $material->id,
                'data-material' => $material->id,
                'data-price' => $material->pricesSell->first()['price'],
                'data-pricebuy' => $material->pricesBuy->first()['price'],
              ]
            ];
          }
        }
      }

      $pass_stones = array();

      foreach ($model_stones as $stone) {
        $pass_stones[] = [
          'label' => $stone->stone->nomenclature->name . ' (' . $stone->stone->contour->name . ', ' . $stone->stone->size->name . ', ' . $stone->stone->style->name . ')',
          'amount' => $stone->amount,
          'flow' => $stone->flow,
          'attributes' => [
            'data-price' => $stone->stone->price,
            'data-type' => $stone->stone->type,
            'data-weight' => $stone->weight,
            'value' => $stone->stone->id,
          ]
        ];
      }

      $pass_photos = array();

      foreach ($model_photos as $photo) {
        if (!Storage::exists('public/models/' . $photo->photo)) continue;

        $url =  Storage::get('public/models/' . $photo->photo);
        $ext_url = Storage::url('public/models/' . $photo->photo);

        $info = pathinfo($ext_url);

        $image_name =  basename($ext_url, '.' . $info['extension']);

        $base64 = base64_encode($url);

        $pass_photos[] = [
          'id' => $photo->id,
          'base64' => 'data:image/' . $info['extension'] . ';base64,' . $base64
        ];
      }

      return array(
        'retail_prices' => $prices_retail,
        'jewels_types' => $pass_jewels,
        'stones' => $pass_stones,
        'weight' => $model->weight,
        'size'   => $model->size,
        'workmanship' => round($model->workmanship),
        'price' => round($model->price),
        'materials' => $pass_materials,
        'photos' => $pass_photos,
        'pricebuy' => $default->material->pricesBuy->first()->price,
        'price' => $default->material->pricesSell->first()->price,
        'models' => $pass_models
      );
    }
  }
  public function scopeOfSimilarPrice($query, $price)
  {
    return $query->orderBy(DB::raw('ABS(`price` - ' . $price . ')'));
  }

  public function getProductAvgRating($product)
  {
    $productTotalRating = 0;
    if (count($product->reviews)) {
      foreach ($product->reviews as $review) {
        $productTotalRating = $productTotalRating + $review->rating;
      }
      $productTotalRating = round($productTotalRating / count($product->reviews));
    }
    return $productTotalRating;
  }

  public function listProductAvgRatingStars($product){
    $return = '';
    for($i=1; $i<=5;$i++){
      if($this->getProductAvgRating($product)>=$i){ $return .= '<i class="spr-icon spr-icon-star"></i>';}
      elseif($product->getProductAvgRating($product)<$i){ $return .= '<i class="spr-icon spr-icon-star-empty"></i>';}
    }
    return $return;
  }

  public static function filterProducts(Request $request){
    $query = Product::where(function($query) use ($request){
      if(
        (is_array($request->priceFrom) && (int)$request->priceFrom[0]>0)
        &&
        (is_array($request->priceTo) && (int)$request->priceTo[0]>0)
      ){
        $query->whereBetween('price', [$request->priceFrom, $request->priceTo]);
      }
      elseif(is_array($request->priceFrom) && (int)$request->priceFrom[0]>0){
        $query->where('price', '>=', $request->priceFrom);
      }
      elseif(is_array($request->priceTo) && (int)$request->priceTo[0]>0){
        $query->where('price', '<=', $request->priceTo);
      }

      if(isset($request->byName) && $request->byName!==''){
        $query->where('name', 'LIKE', '%'.$request->byName.'%');
      }

      if(isset($request->byBarcode) && $request->byBarcode!==''){
        $query->where('barcode', 'LIKE', '%'.$request->byBarcode.'%');
      }

      if(isset($request->byCode) && $request->byCode!==''){
        $query->where('id', 'LIKE', '%'.$request->byCode.'%');
      }

      if(is_array($request->bySize) && !empty($request->bySize) && $request->bySize[0]!==NULL){
        $query->whereIn('size', $request->bySize);
      }

      if(is_array($request->byStore) && !empty($request->byStore) && $request->byStore[0]!==NULL){
        $query->whereIn('store_id', $request->byStore);
      }

      if(is_array($request->byJewel) && !empty($request->byJewel) && $request->byJewel[0]!==NULL){
        $query->whereIn('jewel_id', $request->byJewel);
      }

      if(is_array($request->byMaterial) && !empty($request->byMaterial) && $request->byMaterial[0]!==NULL){
        $query->whereIn('material_id', $request->byMaterial);
      }

      if ($request->byName == '' && $request->byBarcode == '' && $request->byCode == '' && $request->bySize == '' && $request->byStore == '' && $request->byJewel == '' && $request->byMaterial == '') {
        $query = Product::where('store_id', '!=', 1)->get();
      }
    });

    // Order by
    if(isset($request->sortBy)){
      $order = explode('-', $request->sortBy);
      $query->orderBy($order[0], $order[1]);
    }

    return $query;
  }

  public function store($request, $responseType = 'JSON', $updatedStones = [])
  {
    $validate_data = [
      'jewel_id' => 'required',
      'material_id' => 'required',
      'retail_price_id' => 'required|numeric|min:1',
      'weight' => 'required|numeric|between:0.1,10000',
      'gross_weight' => 'required|numeric|between:0.1,10000',
      'size' => 'required|numeric|between:0.1,10000',
      'workmanship' => 'required|numeric|between:0.1,500000',
      'price' => 'required|numeric|between:0.1,500000',
    ];

    if (Auth::user()->role != 'storehouse') {
      $validate_data['store_id'] = 'required|numeric';
    }

    $validator = Validator::make($request->all(), $validate_data);

    if ($validator->fails()) {
      if ($responseType == 'JSON') {
        return Response::json(['errors' => $validator->getMessageBag()->toArray()], 401);
      } else {
        return array('errors' => $validator->errors());
      }
    }

    $material = MaterialQuantity::where('material_id', $request->material_id)->first();

    $store_data = Auth::user()->role == 'storehouse' && !isset($request->store_id) ? "1" : $request->store_id;

    $findModel = DefModel::find($request->model_id);

    $product = $this->firstOrCreate([
      'order_id' => $request->order_id,
    ]);

    $product->name = $findModel->name;
    $product->model_id = $request->model_id;
    $product->jewel_id = $request->jewel_id;
    $product->material_id = $request->material_id;
    $product->weight = $request->weight;
    $product->gross_weight = round($request->gross_weight, 3);
    $product->retail_price_id = $request->retail_price_id;
    $product->size = $request->size;
    $product->workmanship = round($request->workmanship);
    $product->price = round($request->price);
    $product->store_id = $store_data;
    $product->order_id = $request->order_id ?? null;
    $bar = '380' . unique_number('products', 'barcode', 7) . '1';

    $material->quantity += $request->weight;
    $material->save();

    if ($request->with_stones == 'false') {
      $product->weight_without_stones = 'yes';
    } else {
      $product->weight_without_stones = 'no';
    }

    $digits = (string) $bar;
    $even_sum = $digits[1]+$digits[3]+$digits[5]+$digits[7]+$digits[9]+$digits[11];
    $even_sum_three = $even_sum*3;
    $odd_sum = $digits[0]+$digits[2]+$digits[4]+$digits[6]+$digits[8]+$digits[10];
    $total_sum = $even_sum_three+$odd_sum;
    $next_ten = (ceil($total_sum / 10)) * 10;
    $check_digit = $next_ten - $total_sum;
    $product->barcode = $digits . $check_digit;

    $path = public_path('uploads/products/');

    File::makeDirectory($path, 0775, true, true);
    Storage::disk('public')->makeDirectory('products', 0775, true);


    $findModel = ModelOption::where([
      ['material_id', '=', $request->material],
      ['model_id', '=', $request->model]
    ])->get();

    if (!$findModel) {
      $option = new ModelOption();
      $option->material_id = $request->material_id;
      $option->model_id = $request->model_id;
      $option->retail_price_id = $request->retail_price_id;

      $option->save;
    }

    $stoneQuantity = 1;
    if ($request->stones && !$updatedStones) {
      foreach ($request->stones as $key => $stone) {
        if ($stone) {
          $checkStone = Stone::find($stone);

          if ($checkStone->amount < $request->stone_amount[$key]) {
            $stoneQuantity = 0;
            if ($responseType == 'JSON') {
              return Response::json(['errors' => ['stone_weight' => ['Няма достатъчна наличност от този камък.']]], 401);
            } else {
              return array('errors' => array('stone_weight' => ['Няма достатъчна наличност от този камък.']));
            }
          }

          $checkStone->amount = $checkStone->amount - $request->stone_amount[$key];
          $checkStone->save();
        }
      }
    }

    $product->save();

    if ($request->stones) {
      if ($stoneQuantity == 1) {
        foreach ($request->stones as $key => $stone) {
          if ($stone) {
            $product_stones = new ProductStone();
            $product_stones->product_id = $product->id;
            $product_stones->model_id = $request->model_id;
            $product_stones->stone_id = $stone;
            $product_stones->amount = $request->stone_amount[$key];
            $product_stones->weight = $request->stone_weight[$key];
            if ($request->stone_flow[$key] == 'true') {
              $product_stones->flow = 'yes';
            } else {
              $product_stones->flow = 'no';
            }
            $product_stones->save();
          }
        }
      }
    }

    $file_data = $request->input('images');
    if ($file_data) {
      foreach ($file_data as $img) {
        $memi = substr($img, 5, strpos($img, ';') - 5);

        $extension = explode('/', $memi);
        if ($extension[1] == "svg+xml") {
          $ext = 'png';
        } else {
          $ext = $extension[1];
        }

        $file_name = 'productimage_' . uniqid() . time() . '.' . $ext;

        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
        file_put_contents(public_path('uploads/products/') . $file_name, $data);

        Storage::disk('public')->put('products/' . $file_name, file_get_contents(public_path('uploads/products/') . $file_name));

        $photo = new Gallery();
        $photo->photo = $file_name;
        $photo->product_id = $product->id;
        $photo->table = 'products';
        $photo->save();
      }
    }

    return $product;
  }
}
