<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Church;
use App\Models\District;
use App\Models\Zone;
use App\Models\Sector;
use App\Models\Network;
use App\Models\House;
use Database\Factories\HouseFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Church::factory()->create([
            'name' => 'El tabernaculo',
            'number' => '22',
            'address' => 'Blvd 1810 #1900 Col. Hidalgo',
        ]);

        District::factory()->create([
            'number' => 1,
            'church_id' => Church::find(1),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Zone::factory()->create([
            'number' => 1,
            'district_id' => District::find(1),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Sector::factory()->create([
            'number' => 1,
            'zone_id' => Zone::find(1),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Sector::factory()->create([
            'number' => 2,
            'zone_id' => Zone::find(1),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Network::factory()->create([
            'number' => 1,
            'sector_id' => Sector::find(1),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Network::factory()->create([
            'number' => 2,
            'sector_id' => Sector::find(1),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Network::factory()->create([
            'number' => 3,
            'sector_id' => Sector::find(1),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Network::factory()->create([
            'number' => 4,
            'sector_id' => Sector::find(1),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Network::factory()->create([
            'number' => 1,
            'sector_id' => Sector::find(2),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Network::factory()->create([
            'number' => 2,
            'sector_id' => Sector::find(2),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'clarK2312',
            'type' => 'superadmin',
            'church_id' => 1
        ]);
        User::factory()->create([
            'name' => 'David Ruiz',
            'username' => 'davidruiz',
            'email' => 'clarkddr@gmail.com',
            'password' => 'clarK2312',
            'type' => 'admin',
            'church_id' => 1            
        ]);
        User::factory()->create([
            'name' => 'user',
            'username' => 'user',
            'email' => 'user@gmail.com',
            'password' => 'clarK2312',
            'type' => 'user'            
        ]);
        User::factory(20)->create();
        House::factory(20)->create();
    }
}
