<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Zone extends Model
{
    use HasFactory;

    public function district(): BelongsTo {
        return $this->belongsTo(District::class);
    }

    public function sectors(): HasMany {
        return $this->hasMany(Sector::class);
    }

    public function networks(): HasManyThrough {
        return $this->hasManyThrough(Network::class, Sector::class);
    }

    public function houses(): HasManyThrough {
        return $this->hasManyThrough(House::class, Network::class, 'sector_id','network_id','id','id' );
    }
}
