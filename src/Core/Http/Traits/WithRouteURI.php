<?php

namespace App\Core\Http\Traits;

trait WithRouteURI
{
    protected array $paramsURI  = [];

    protected function resolveURI(string $uri): string
    {
        return $uri === '/' ? $uri : rtrim(ltrim($uri, '/'), '/');
    }

    protected function checkRouteURI(string $routeURI, string $compareURI): bool
    {
        $routeURI = $this->resolveURI($routeURI);
        $compareURI = $this->resolveURI($compareURI);

        if ($routeURI === $compareURI) {
            return true;
        }       

        return $this->resolveParamsURI($routeURI, $compareURI) === $compareURI;
    }


    protected function resolveParamsURI(string $routeURI,string $compareURI)
    {
        $arrayCompareURI = explode('/', $this->resolveURI($compareURI));
        $arrayRoute = explode('/', $this->resolveURI($routeURI));

        if (
            strpos($routeURI, '{') !== false &&
            count($arrayCompareURI) === count($arrayRoute)
        ) {

            array_walk($arrayRoute, function (&$uri, $key) use ($arrayCompareURI, $arrayRoute) {
                if (strpos($uri, '{') !== false) {
                    $uri =  $arrayCompareURI[$key];

                    //set params
                    $this->setParam($arrayRoute[$key], $arrayCompareURI[$key]);
                    
                }
                return $uri;
            });

            return join('/', $arrayRoute);
        }
    }

    private function setParam(string $paramKey, string $paramValue)
    {
        $paramKey = ltrim(rtrim($paramKey, '}'), '{');
        if (strpos($paramValue, '?') !== false) {
            $paramValue = substr($paramValue, 0, strpos($paramValue, '?'));
        }
        $paramValue = $paramValue;
        $this->paramsURI[$paramKey] = $paramValue;
    }
}
