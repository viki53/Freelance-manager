<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaxRate;

class TaxRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaxRate::create([
            'label' => 'Taux normal',
            'percentage' => 20,
        ]);
        TaxRate::create([
            'label' => 'Taux intermédiaire',
            'percentage' => 10,
        ]);
        TaxRate::create([
            'label' => 'Taux réduit',
            'percentage' => 5.5,
        ]);
        TaxRate::create([
            'label' => 'Taux particulier',
            'percentage' => 2.1,
        ]);
    }
}
