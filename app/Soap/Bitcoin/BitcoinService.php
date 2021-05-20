<?php

declare(strict_types=1);

namespace App\Soap\Bitcoin;

use App\Soap\Bitcoin\Types\Bitcoin;

class BitcoinService
{
    /**
     * Returns Bitcoin price.
     *
     * @return Bitcoin
     */
    public function getCurrentPrice(): Bitcoin
    {
        $content = file_get_contents('https://api.coindesk.com/v1/bpi/currentprice.json');
        $data = json_decode($content, true);

        return new Bitcoin($data['time'], $data['disclaimer'], $data['chartName'], $data['bpi']);
    }
}
