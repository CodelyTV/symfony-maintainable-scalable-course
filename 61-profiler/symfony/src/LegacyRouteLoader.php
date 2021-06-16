<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

final class LegacyRouteLoader extends Loader
{
    public function load($resource, string $type = null)
    {
        $collection = new RouteCollection();
        $finder = new Finder();
        $finder->files()->name('*.php');


        /** @var SplFileInfo $legacyScriptFile */
        foreach ($finder->in(__DIR__ . '/../../legacy/public/pages') as $legacyScriptFile) {
            $filename = basename($legacyScriptFile->getRelativePathname(), '.php');
            $routeName = sprintf('app.legacy.%s', str_replace('/', '__', $filename));

            $collection->add($routeName, new Route($legacyScriptFile->getRelativePathname(), [
                '_controller' => 'App\Controller\LegacyController::loadLegacyScript',
                'requestPath' => '/' . $legacyScriptFile->getRelativePathname(),
                'legacyScript' => $legacyScriptFile->getPathname(),
            ]));
        }

        return $collection;
    }

    public function supports($resource, string $type = null)
    {
        return 'legacy' === $type;
    }
}
