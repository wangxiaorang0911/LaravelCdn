<?php

namespace SampleNinja\LaravelCdn\Contracts;

/**
 * Interface CdnFacadeInterface.
 *
 * @author   Mahmoud Zalt <mahmoud@vinelab.com>
 */
interface CdnFacadeInterface
{
    public function asset($path);
}
