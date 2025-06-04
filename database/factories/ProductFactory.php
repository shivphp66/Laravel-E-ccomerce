<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->name();
        $slug = Str::slug($title);
        $subcategories = [7,11];
        $subcategoryRandomKye = array_rand($subcategories);
        $brands = [1,3,4,5];
        $brandRandomKye = array_rand($brands);     

        return [
            'title' => $title,
            'slug' => $slug,
            'category_id' => 40,
            'sub_category_id' => $subcategories[$subcategoryRandomKye],
            'brand_id' =>  $brands[$brandRandomKye],
            'is_featured' => 'Yes',
            'price' => rand(100,15000),
            'sku'   => rand(1000, 10000),
            'barcode' => rand(5566,889988),
            'track_qty' => 'Yes',
            'qty' => 20,
            'status' => '1'

        ];
           
    }
}
