<?php

namespace Util;

//use Kint\Kint;

class RoutesUtil
{
    public function getRoutes(): array
    {
        $urls = $this->getUrls();

        $request = [];
        $request['route'] = strtoupper($urls[0]);
        $request['resource'] = $urls[1] ?? null;
        $request['id'] = $urls[2] ?? null;
        $request['method'] = $_SERVER['REQUEST_METHOD'];

        var_dump($request);
        return $request;
    }

    public function getUrls(): array
    {
        $uri = str_replace('/' . DIR_PROJECT, '', $_SERVER['REQUEST_URI']);
        return explode('/', trim($uri, '/'));
    }
}