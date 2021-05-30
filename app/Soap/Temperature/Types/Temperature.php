<?php

namespace App\Soap\Temperature\Types;

class Temperature
{
    public float $kelvin;

    public float $fahrenheit;

    public float $celsius;

    /**
     * Temperature constructor.
     *
     * @param float $kelvin
     * @param float $fahrenheit
     * @param float $celsius
     */
    public function __construct(float $kelvin = 0, float $fahrenheit = 0, float $celsius = 0)
    {
        $this->kelvin = $kelvin;
        $this->fahrenheit = $fahrenheit;
        $this->celsius = $celsius;
    }
}
