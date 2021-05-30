<?php

declare(strict_types=1);

namespace App\Soap\Bitcoin\Types;

class Bitcoin
{
    public array $time;

    public string $disclaimer;

    public string $chartName;

    public array $bpi;

    /**
     * Bitcoin constructor.
     *
     * @param array $time
     * @param string $disclaimer
     * @param string $chartName
     * @param array $bpi
     */
    public function __construct(array $time, string $disclaimer, string $chartName, array $bpi)
    {
        $this->time = $time;
        $this->disclaimer = $disclaimer;
        $this->chartName = $chartName;
        $this->bpi = $bpi;
    }
}
