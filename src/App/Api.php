<?php


namespace App;


use App\Controllers\ApiController;

class Api
{
    private array $routes;
    private string $serverRequestUri;
    private string $serverRequestMethod;


    /**
     * Api constructor.
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
        $this->serverRequestUri = $_SERVER['REQUEST_URI'];
        $this->serverRequestMethod = $_SERVER['REQUEST_METHOD'];
    }

    /**
     *
     */
    public function run(): void
    {
        foreach ($this->routes as $route => $action) {
            [$routeMethod, $routeRequest] = explode(' ', $route);

            if ($this->serverRequestMethod === $routeMethod) {
                $isMatch = preg_match(
                    '#^' . preg_replace(
                        '#{([a-zA-Z0-9_\-]+)}#',
                        '(?<$1>[a-zA-Z0-9_\-]*)',
                        $routeRequest
                    ) . '$#',
                    $this->serverRequestUri,
                    $routeMatches
                );

                if ($isMatch) {
                    $this->runAction(
                        $action,
                        $this->getActionParams($routeMatches)
                    );
                }
            }
        }

        (new ApiController())->badRequest();
    }

    /**
     * @param $action
     * @param $params
     */
    private function runAction(string $action, array $params): void
    {
        [$controller, $method] = explode('@', $action);
        $controller = 'App\\' . $controller; // create new Controller
        call_user_func_array([new $controller, $method], $params);
    }

    /**
     * @param $routeMatches
     * @return array
     */
    public function getActionParams(array $routeMatches): array
    {
        return array_values(
            array_filter(
                $routeMatches,
                static function ($value, $key) {
                    if (is_string($key)) {
                        return true;
                    }
                },
                ARRAY_FILTER_USE_BOTH
            )
        );
    }
}
