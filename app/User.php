<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\DiscountCode;
use App\UserSubstitution;
use App\Store;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'store_id',
        'first_name', 'last_name', 'city', 'street', 'postcode', 'country', 'street_number'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getId()
    {
      return $this->id;
    }

    public function getStore()
    {
        $substitution = UserSubstitution::where([
            ['user_id', '=', $this->id],
            ['date_to', '>=', date("Y-m-d")]
        ])->first();

        if($substitution){
            return Store::find($substitution->store_id);
        }else{
            return $this->store;
        }
    }

    public function discountCodes()
    {
        return $this->hasMany('App\DiscountCode');
    }

    public function store()
    {
        return $this->belongsTo('App\Store')->withTrashed();
    }

    public function blogs()
    {
        return $this->hasMany('App\Blog')->get();
    }

    public function blogComments()
    {
        return $this->hasMany('App\BlogComment')->get();
    }
}