<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Subscriptiontype extends Model implements Sortable
{
    use HasFactory;
    use SoftDeletes;
    use SortableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table="subscriptiontypes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'operator',
        'type_sim',
        'name',
        'price',
        'is_active',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    /**
     * **************************
     * MODEL RELATIONS
     * **************************
     */



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


    public function getTitleAttribute()
    {
        return $this->price.' Eur';
    }


}
