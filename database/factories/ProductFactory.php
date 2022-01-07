<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
		$shopList = Shop::all();
		$shopIds = $shopList->pluck('id')->toArray();
		unset($shopList);
		
		$maxIndex = count($shopIds) - 1;
		
        return [
            'name' => 'Товар ' . $this->faker->name,
            'description' => '<p>' . $this->faker->realText . '</p>',
            'price' => $this->faker->randomFloat(2, 1, 500),
            'shop_id' => $shopIds[$this->faker->numberBetween(0, $maxIndex)]
        ];
    }
}
