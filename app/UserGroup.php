<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_groups';

    protected $fillable = [
        'name',
        'domain'
    ];

    public function store(array $attributes)
    {
        return $this->create($attributes);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_groups_id');
    }
}
