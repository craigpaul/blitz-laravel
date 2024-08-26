<?php

namespace CraigPaul\Blitz;

use Exception;

class UnsupportedAuthenticationGuardException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param string $guard
     *
     * @return void
     */
    public function __construct(string $guard)
    {
        parent::__construct("Unsupported authentication guard: {$guard}");
    }
}
