<?php

namespace SampleNinja\LaravelCdn\Contracts;

/**
 * Interface FinderInterface.
 *
 * @author   Mahmoud Zalt <mahmoud@vinelab.com>
 */
interface FinderInterface
{
    public function read(AssetInterface $paths);
}
