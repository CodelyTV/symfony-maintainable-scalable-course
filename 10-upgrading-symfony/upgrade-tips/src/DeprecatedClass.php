<?php

declare(strict_types=1);

namespace App;

/** @deprecated */
final class DeprecatedClass
{
    /** @deprecated */
    public function deprecatedMethod()
    {
        trigger_deprecation('symfony/http-kernel', '5.4', '"%s" is deprecated and will be removed in 6.0, inject a session in the request instead.', __METHOD__);
    }
}