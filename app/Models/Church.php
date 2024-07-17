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

    public function sectors(): HasManyThrough {        
        return $this->hasManyThrough(
            Sector::class,
            Zone::class,
            'district_id',
            'zone_id',
            'id',
            'id'
        );
    }



    public function networks(): HasManyThrough {
        // Utilizar una consulta personalizada para acceder a las casas a través de las networks, sectores, zonas y distritos
        return $this->hasManyThrough(
            Network::class,
            Sector::class,
            'zone_id',
            'sector_id',
            'id',
            'id'
        )->join('zones', 'zones.id', '=', 'sectors.zone_id')
         ->join('districts', 'districts.id', '=', 'zones.district_id')
         ->where('districts.church_id', $this->id);
    }

    public function houses(): HasMany {
        return $this->hasMany(House::class);
    }
}
