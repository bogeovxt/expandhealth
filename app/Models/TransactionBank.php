<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class TransactionBank extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SortableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table="transactions_bank";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'no_document',
        'debit',
        'credit',
        'description',
        'account',
        'purchased',
        'observations',
        'filename',
        'bank',
        'is_processed',
    ];


    protected $casts = [
        'purchased' => 'date'
    ];

    protected $attributes = [
        'is_processed' => false,
    ];

    public $sortable = [
        'order_column_name' => 'id',
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
    public function scopeOfProcessed($query)
    {
        $query->where('is_processed',1);
        return $query;
    }

     /**
     * **************************
     * CUSTOM ATTRIBUTES
     * **************************
     */

}
