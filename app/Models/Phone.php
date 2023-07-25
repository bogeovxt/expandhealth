<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "phones";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'device_id',
        'imei',
        'serial_number',
        'service_tag',
        'inventory_code',
        'purchased',
        'accessory',
        'observations',
        'is_active',
    ];

    protected $casts = [
        'purchased' => 'date'
    ];

    protected $attributes = [
        // 'is_active' => true,
    ];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
        'sort_on_pivot' => true,
    ];


    /**
     * **************************
     * MODEL RELATIONS
     * **************************
     */

    /**
     * Get the device
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id');
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
         return $query->whereIn('id',$search);
    }

    public function scopeOfWithoutSelected($query,$search=null)
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
