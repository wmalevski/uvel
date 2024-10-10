<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Cart;
use Auth;

class Material extends Model
{
    use SoftDeletes;

    protected $fillable = array(
        'name',
        'code',
        'color',
        'carat',
        'parent_id',
        'cash_group'
    );

    protected $table = 'materials';
    protected $casts = ['deleted_at'];

    public function parent(){
        return $this->belongsTo('App\MaterialType')->withTrashed();
    }

    public function quantity(){
        return $this->hasMany('App\MaterialQuantity')->withTrashed();
    }

    public function prices(){
        return $this->hasMany('App\Price')->withTrashed();
    }

    public function pricesBuy(){
        return $this->hasMany('App\Price')->where('type', 'buy');
    }

    public function pricesExchange(){
        return $this->hasMany('App\Price')->where('type', 'buy')->whereIn('slug',array('Купува 1', 'Купува 2'));
    }

    public function pricesSell(){
        return $this->hasMany('App\Price')->where('type', 'sell');
    }

    public function products(){
        return $this->hasMany('App\Product');
    }

    public function productsOnline(){
        return $this->hasMany('App\Product')
            ->where('status', 'available')
            ->where('store_id', '!=', 1)
            ->where('website_visible', 'yes')
            ->with(['store_info', 'photos', 'model', 'material'])
            ->orderBy('created_at','DESC');
    }

    public function scopeForBuy()
    {
        return $this->where('for_buy', 'yes');
    }

    public function scopeForExchange()
    {
        return $this->where('for_exchange', 'yes');
    }

    public function filterMaterials(Request $request, $returnModel = false){
        $search = $request->search;
        $params = $request->all();

        // There are specific scenarios where header named 'search' is not present in the request so we have to overwrite it
        if (is_null($search)) {
            $search = reset($params);
        }

        // There are specific scenarios where header named 'search' is not present in the request so  we have overwrite it
        if (is_null($search)) {
            foreach($request->all() as $k => $v) {
                $search = $request->input($k);
                break;
            }
        }

        $materials = Material::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' .$search. '%')
                    ->orWhere('color', 'like', '%' .$search. '%')
                    ->orWhere('code', 'like', '%' .$search. '%');
            })->with([
                'pricesBuy',
                'pricesSell'
            ]);

        $paginatedResult = $materials->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        if ( $returnModel ) {
            return $materials;
        }

        $results = $paginatedResult->map(function ($material) {
            $materialCode = $material->code;
            $materialColor = $material->color;
            $materialName = $material->parent->name;

            return [
                'id' => $material->id,
                'text' => sprintf('%s %s %s', $materialName, $materialColor, $materialCode),
                'attributes' => [
                    'data-carat' => $material->carat,
                    'data-transform' => $material->carat_transform,
                    'data-pricebuy' => $material->pricesBuy->first()['price'],
                    'data-price' => $material->pricesSell->first()['price'],
                    'data-material' => $material->id,
                ],
            ];
        });

        $response = response()->json([
            'results' => $results,
            'pagination' => ['more' => $paginatedResult->hasMorePages()],
        ]);

        return $response;
    }

    public function filterMaterialsPayment(Request $request){
        $items = Cart::session(Auth::user()->getId())->getContent()->count();
        $search = $request->search ?? $request->byName;
        $query = Material::where(function($query) use ($request, $items){
            if (isset($search)) {
                if ($items > 0){
                    $query->where('for_exchange', 'yes');
                }else{
                    $query->where('for_buy', 'yes');
                }

                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('color', 'LIKE', "%$search%")
                    ->orWhere('code', 'LIKE', "%$search%");
            }
        })
        ->paginate(\App\Setting::where('key','per_page')->first()->value ?? 30);

        return $query;
    }
}
