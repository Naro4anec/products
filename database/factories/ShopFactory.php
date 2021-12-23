<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class ShopFactory
 * @package Database\Factories
 */
class ShopFactory extends Factory
{

    /**
     * @var string
     */
    protected $model = Shop::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Магазин ' . $this->faker->name,
            'url' => $this->faker->domainName,
            'working_time_open' => $this->faker->time,
            'working_time_close' => $this->faker->time
        ];
    }
}
