<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LegacyBridge
{
    public static function prepareLegacyScript(Request $request, Response $response, string $publicDirectory): ?string
    {
        if (false === $response->isNotFound()) {
            return null;
        }

        // Figure out how to map to the needed script file
        // from the existing application and possibly (re-)set
        // some env vars.
        $legacyScriptFilename = $publicDirectory . '/../../legacy/public/index.php';

        return $legacyScriptFilename;
    }
}