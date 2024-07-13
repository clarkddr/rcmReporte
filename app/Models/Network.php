<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Network extends Model
{
    use HasFactory;

    public function sector(): BelongsTo {
        return $this->belongsTo(Sector::class);
    }

    public function houses(): HasMany {
        return $this->hasMany(House::class);
    }
}
