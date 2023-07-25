<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "devices";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [        
        'name',
        'year',
        'observations',
        'brand_id',
        'devicetype_id',
        'is_active',
    ];

    protected $casts = [
        'year' => 'date'
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
     * Get the brand of the device.
     */
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    /**
     * Get the type of the device.
     */
    public function devicetype()
    {
        return $this->belongsTo('App\Models\Devicetype', 'devicetype_id');
    }

    /**
     * **************************
     * SCOPE LISTS
     * **************************
     */


     /**
     * **************************
     * CUSTOM ATTRIBUTES
     * **************************
     */
}
