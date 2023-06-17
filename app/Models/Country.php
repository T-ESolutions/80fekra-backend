<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ofcold\NovaSortable\SortableTrait;

class Country extends Model
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'title_ar', 'title_en', 'is_active', 'sort_order','shipping_cost'
    ];
    protected $appends = ['title'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($country) {
            if ($country->users()->count() > 0) {
                throw new \Exception('لايمكن الحذف لاستخدامها فى المستخدمين  .');
            }

            if ($country->addresses()->count() > 0) {

                throw new \Exception('لايمكن الحذف لاستخدامها فى العناوين  .');
            }

            if ($country->cities()->count() > 0) {

                throw new \Exception('لايمكن الحذف لاستخدامها فى المدن  .');
            }
        });


        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('sort_order', 'asc');
        });
    }

    public function getTitleAttribute()
    {
        if (\app()->getLocale() == "en") {
            return $this->title_en;
        } else {
            return $this->title_ar;
        }
    }


    public function scopeActive($query): void
    {
        $query->where('is_active', 1);
    }


    public function users()
    {
        return $this->hasMany(User::class, 'country_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'country_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id');
    }


}
