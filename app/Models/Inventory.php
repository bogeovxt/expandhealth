<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($inventory) {
            $inventory->user_id = auth()->user()->id;
        });
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "inventories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'employee_id',
        'phone_id',
        'phone_sim_id',
        'laptop_id',
        'laptop_sim_id',
        'tablet_id',
        'tablet_sim_id',
        'usbstick_id',
        'usbstick_sim_id',
        'projector_id',
        'desktop_id',
        'monitor_id',
        'received_at',
        'delivered_at',
        'observations',
        'is_active',
    ];

    protected $casts = [
        'received_at' => 'datetime:Y-m-d',
        'delivered_at' => 'datetime:Y-m-d',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * **************************
     * MODEL RELATIONS
     * **************************
     */


    /**
     * Get the type of the device.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id')
            ->OfActive()
            ->orderBy('fullname');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function phone()
    {
        return $this->belongsTo(Phone::class, 'phone_id');
    }

    public function phone_sim()
    {
        return $this->belongsTo(Subscription::class, 'phone_sim_id');
    }

    public function laptop()
    {
        return $this->belongsTo(Laptop::class, 'laptop_id');
    }

    public function laptop_sim()
    {
        return $this->belongsTo(Subscription::class, 'laptop_sim_id');
    }

    public function tablet()
    {
        return $this->belongsTo(Tablet::class, 'tablet_id');
    }

    public function tablet_sim()
    {
        return $this->belongsTo(Subscription::class, 'tablet_sim_id');
    }

    public function usbstick()
    {
        return $this->belongsTo(Usbstick::class, 'usbstick_id');
    }

    public function usbstick_sim()
    {
        return $this->belongsTo(Subscription::class, 'usbstick_sim_id');
    }

    public function projector()
    {
        return $this->belongsTo(Projector::class, 'projector_id');
    }

    public function desktop()
    {
        return $this->belongsTo(Desktop::class, 'desktop_id');
    }

    public function monitor()
    {
        return $this->belongsTo(Monitor::class, 'monitor_id');
    }

    /**
     * **************************
     * SCOPE LISTS
     * **************************
     */

    // /**
    //  * Scope of slug
    //  * @param $query
    //  * @param null $search
    //  * @return mixed
    //  */
    // public function scopeOfSlug($query,$search=null,$locale=null)
    // {
    //     if (!$search) return $query;
    //     return $query->whereHas('translations', function ($query) use ($search, $locale) {
    //         $query->where('slug', $search);
    //     });
    // }

    public function scopeOfActive($query)
    {
        $query->where('is_active',1);
        return $query;
    }

    // public function scopeOfS($query)
    // {
    //     $is_admin = optional(Auth::user())->is_admin;
    //     if(!$is_admin){
    //         $query->where('is_public',1);
    //     }

    //     return $query;
    // }


     /**
     * **************************
     * CUSTOM ATTRIBUTES
     * **************************
     */
}
