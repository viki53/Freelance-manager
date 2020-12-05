<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemType;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemType::create([
            'label_singular' => 'heure',
            'label_plural' => 'heures',
        ]);
        ItemType::create([
            'label_singular' => 'jour',
            'label_plural' => 'jours',
        ]);
        ItemType::create([
            'label_singular' => 'prestation',
            'label_plural' => 'prestations',
        ]);
        ItemType::create([
            'label_singular' => 'produit',
            'label_plural' => 'produits',
        ]);
    }
}
