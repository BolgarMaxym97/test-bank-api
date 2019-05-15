<?php

use Illuminate\Database\Seeder;

class OperationTypesTableSeeder extends Seeder
{

    private const types = [
        'Cash withdrawal',
        'Credit card replenishment',
        'Transfer money from card to card',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::types as $type_name) {
            \App\Models\OperationType::insert([
                'type_name' => $type_name
            ]);
        }
    }
}
