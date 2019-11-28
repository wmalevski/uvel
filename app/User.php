<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
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
        'name', 'email', 'password', 'store_id', 'role',
        'first_name', 'last_name', 'city', 'street', 'postcode', 'country', 'street_number', 'phone'
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

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function wishLists() 
    {
        return $this->hasMany('App\WishList');
    }

    public function sellings()
    {
        return $this->hasMany('App\UserPayment');
    }

    public function partnerInfo()
    {
        return $this->belongsTo('App\Partner')->withTrashed();
    }

    public function filterUsers(Request $request ,$query){
        $query = User::where(function($query) use ($request){

            if ($request->byName) {
                if (trim($request->byName) == '-') {
                    $query = User::all();
                } else {
                    $request->byName = explode("-", $request->byName);
                    $query->where('name', 'LIKE', '%' . trim($request->byName[0]) . '%');

                    if (count($request->byName) == 1) {
                        $query->orWhereHas('Store', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . trim($request->byName[0]) . '%');
                        });
                    }

                    if (count($request->byName) > 1) {
                        $query->whereHas('Store', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . trim($request->byName[1]) . '%');
                        });
                    }
                }
            }

            if ($request->byEmail) {
                $query->where('email','LIKE','%'.$request->byEmail.'%');
            }

            if ($request->byName == '' && $request->byEmail == '') {
                $query = User::all();
            }
        });

        return $query;
    }

    /***
     * @param string $role
     * @return $this
     */
    public function addRole(string $role)
    {
        $roles = $this->getRoles();
        $roles[] = $role;

        $roles = array_unique($roles);
        $this->setRoles($roles);

        return $this;
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles)
    {
        $this->setAttribute('role', $roles);
        return $this;
    }

    /***
     * @param $role
     * @return mixed
     */
    public function hasRole($role)
    {
        return in_array($role, [$this->getRoles()]);
    }

    /***
     * @param $roles
     * @return mixed
     */
    public function hasRoles($roles)
    {
        $currentRoles = $this->getRoles();
        foreach($roles as $role) {
            if ( ! in_array($role, $currentRoles )) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->getAttribute('role');

        if (is_null($roles)) {
            $roles = [];
        }

        return $roles;
    }
}