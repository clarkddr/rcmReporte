<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Sector extends Model
{
    use HasFactory;

    public function zone(): BelongsTo {
        return $this->belongsTo(Zone::class);
    }

    public function networks(): HasMany {
        return $this->hasMany(Network::class);
    }

    public function houses(): HasManyThrough {
        return $this->hasManyThrough(House::class, Network::class);
    }

    
}
