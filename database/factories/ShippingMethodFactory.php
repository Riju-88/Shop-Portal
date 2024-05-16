<?php

namespace Database\Factories;
use App\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingMethod>
 */
class ShippingMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ShippingMethod::class;
    public function definition(): array
    {
        $shippingMethodNames = ['Standard Shipping', 'Express Shipping', 'Next-Day Delivery', 'Economy Shipping', 'Priority Shipping'];
        $uniqueShippingMethodNames = $this->faker->unique()->randomElements($shippingMethodNames, $this->faker->numberBetween(1, count($shippingMethodNames)));

        // Define delivery times corresponding to the shipping method names
        $deliveryTimes = [
            'Standard Shipping' => '3-5 business days',
            'Express Shipping' => '1-2 business days',
            'Next-Day Delivery' => 'Next business day',
            'Economy Shipping' => '1 week',
            'Priority Shipping' => '2-3 business days',
        ];

        return [
            //
            'name' => $uniqueShippingMethodNames[0],
            'description' => $this->faker->sentence(),
            'cost' => $this->faker->randomFloat(2, 5, 50), // Random cost between $5 and $50
            'expected_delivery_time' => $deliveryTimes[$uniqueShippingMethodNames[0]], // Retrieve delivery time based on selected shipping method name
        ];
    }
}
