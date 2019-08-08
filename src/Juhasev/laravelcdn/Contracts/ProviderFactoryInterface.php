<?php

namespace Juhasev\laravelcdn\Contracts;

/**
 * Interface ProviderFactoryInterface.
 *
 * @author   Mahmoud Zalt <mahmoud@vinelab.com>
 */
interface ProviderFactoryInterface
{
    public function create($configurations);
}
