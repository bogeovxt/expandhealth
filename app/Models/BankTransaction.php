<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class BankTransaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SortableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table="bank_transactions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'no_document',
        'debit',
        'credit',
        'description',
        'account',
        'purchased_at',
        'bank',
        'is_processed',
    ];


    protected $casts = [
        'purchased_at' => 'date'
    ];

    protected $attributes = [
        'is_processed' => false,
    ];

    public $sortable = [
        'order_column_name' => 'purchased_at',
        'sort_when_creating' => true,
    ];


    /**
     * **************************
     * MODEL RELATIONS
     * **************************
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id')
            ->orderBy('fullname');
    }


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
