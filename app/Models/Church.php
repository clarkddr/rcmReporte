<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Church extends Model
{
    use HasFactory;

    protected $fillabe = [
        'name','number','address'
    ];

    public function users(): HasMany {
        return $this->hasMany(User::class);
    }
}
