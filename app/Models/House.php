<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class House extends Model
{
    use HasFactory;
    
    protected $fillabe = [
        'number','address','members_quantity'
    ];

    public function church(): BelongsTo {
        return $this->belongsTo(Church::class);
    }
    public function network(): BelongsTo {
        return $this->belongsTo(Network::class);
    }
}
