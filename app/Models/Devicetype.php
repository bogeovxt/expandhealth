<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;


class Devicetype extends Model implements Sortable
{
    use HasFactory;
    use SoftDeletes;
    use SortableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table="devicetypes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_active',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    
    /**
     * Dirty trick to make HasSortableRows work
    */
    // public function determineOrderColumnName() {
    //     return $this->traitDetermineOrderColumnName();
    // }


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

     /**
     * **************************
     * CUSTOM ATTRIBUTES
     * **************************
     */
}
