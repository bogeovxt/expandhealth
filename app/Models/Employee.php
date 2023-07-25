<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        // static::creating(function ($employee) {
        //     $employee->fullname = $employee->fname.' '.$employee->lname;
        // });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'fname',
        'lname',
        'cnp',
        'email',
        'email2',
        'phone',
        'phone2',
        'birthday',
        'employment_at',
        'location',
        'nextup_id',
        'colorful_id',
        'division_id',
        'is_active',
    ];

    protected $casts = [
        'birthday' => 'date',
        'employment_at' => 'date',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
        'sort_on_pivot' => true,
    ];

    /*
    * **************************
    * MODEL RELATIONS
    * **************************
    */

   /**
    * Get the division
    */
   public function division()
   {
       return $this->belongsTo('App\Models\Division', 'division_id');
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
