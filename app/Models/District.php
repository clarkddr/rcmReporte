<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class District extends Model
{
    use HasFactory;

    public function church(): BelongsTo {
        return $this->belongsTo(Church::class);
    }

    public function zones(): HasMany {
        return $this->hasMany(Zone::class);
    }

    public function houses(): HasManyThrough {
        // Utilizar una consulta personalizada para acceder a las casas a través de las networks, sectores, zonas y distritos
        return $this->hasManyThrough(
            House::class,
            Network::class,
            'sector_id',    // Clave foránea en la tabla networks que apunta a la tabla sectors
            'network_id',   // Clave foránea en la tabla houses que apunta a la tabla networks
            'id',           // Clave primaria local en la tabla districts
            'id'            // Clave primaria local en la tabla sectors
        )->join('sectors', 'sectors.id', '=', 'networks.sector_id')
         ->join('zones', 'zones.id', '=', 'sectors.zone_id')
         ->join('districts', 'districts.id', '=', 'zones.district_id')
         ->where('districts.id', $this->id);
    }
}
