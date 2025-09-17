<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Eléctricos', 'Hibridos Enchufables'];

        try {
            foreach ($categories as $category) {
                Category::createOrFirst(['name' => $category], ['name' => $category]);
            }
            Log::info('Categorias insertadas en la Base de datos');
        } catch (\Exception $err) {
            Log::info('Algo fallo al insertar las categorias', [
                'error' => $err->getMessage()
            ]);
        }
    }
}
