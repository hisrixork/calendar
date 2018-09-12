<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            "name"  => "F",
            "label" => "formation",
        ]);
        Category::create([
            "name"  => "CP",
            "label" => "congés payés",
        ]);
        Category::create([
            "name"  => "R",
            "label" => "rtt",
        ]);
        Category::create([
            "name"  => "AM",
            "label" => "arrêt maladie",
        ]);
        Category::create([
            "name"  => "CS",
            "label" => "congés sans solde",
        ]);
        Category::create([
            "name"  => "A",
            "label" => "autre",
        ]);
    }
}
