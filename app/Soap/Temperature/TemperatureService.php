<?php

declare(strict_types=1);

namespace App\Soap\Temperature;

use App\Soap\Temperature\Types\Temperature;

class TemperatureService
{
    /**
     * Converts temperature from Kelvin.
     *
     * @param float $temperature
     * @return Temperature
     */
    public function convertFromKelvin(float $temperature): Temperature
    {
        return new Temperature($temperature, ($temperature * 1.8) - 459.67, $temperature - 273.15);
    }

    /**
     * Converts temperature from Fahrenheit.
     *
     * @param float $temperature
     * @return Temperature
     */
    public function convertFromFahrenheit(float $temperature): Temperature
    {
        return new Temperature(($temperature + 459.67) * 5/9, $temperature, ($temperature - 32 ) / 1.8);
    }

    /**
     * Converts temperature from Celsius.
     *
     * @param float $temperature
     * @return Temperature
     */
    public function convertFromCelsius(float $temperature): Temperature
    {
        return new Temperature($temperature + 273.15,($temperature * 1.8) + 32, $temperature);
    }
}
