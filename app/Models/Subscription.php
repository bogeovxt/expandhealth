<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "subscriptions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sim',
        'number',
        'observations',
        'subscriptiontype_id',
        'is_active',
    ];

    protected $casts = [

    ];

    protected $attributes = [
        // 'is_active' => true,
    ];

    /**
     * **************************
     * MODEL RELATIONS
     * **************************
     */

    /**
     * Get the type of the device.
     */
    public function subscriptiontype()
    {
        return $this->belongsTo('App\Models\Subscriptiontype', 'subscriptiontype_id');
    }

    /**
     * **************************
     * SCOPE LISTS
     * **************************
     */
    public function scopeOfActive($query)
    {
        $query->where('is_active',1);
        return $query;
    }


    public function scopeOfSelected($query,$search=null)
    {
         if (!$search) return $query;
         return $query->whereNotIn('id',$search);
    }

     /**
     * **************************
     * CUSTOM ATTRIBUTES
     * **************************
     */
}
