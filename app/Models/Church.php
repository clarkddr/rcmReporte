<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Church extends Model
{
    use HasFactory;

    protected $fillabe = [
        'name','number','address'
    ];

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }

    public function districts(): HasMany {
        return $this->hasMany(District::class);
    }

    public function zones(): HasManyThrough {
        return $this->hasManyThrough(Zone::class, District::class);
    }

    public function houses(): HasMany {
        return $this->hasMany(House::class);
    }
}
