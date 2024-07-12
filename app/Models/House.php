<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{
    use HasFactory;
    
    protected $fillabe = [
        'number','address','members_quantity'
    ];

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }

    public function church(): BelongsTo {
        return $this->belongsTo(Church::class);
    }
}
