<?php

namespace core;

class Route
{
    protected static $routes = [];

    public static function get(string $uri, array|string|callable|null $action = null)
    {
        self::addRoute('GET', $uri, $action);
    }

    public static function post(string $uri, array|string|callable|null $action = null)
    {
        self::addRoute('POST', $uri, $action);
    }

    // Другие методы для других типов HTTP-запросов...

    protected static function addRoute(string $method, string $uri, array|string|callable|null $action = null)
    {
        self::$routes[] = [
            'method' => $method,
            'uri'    => $uri,
            'action' => $action
        ];
    }

    public static function dispatch($method, $uri)
    {
        foreach (self::$routes as $route) {
            if ($route['method'] === $method && preg_match('#^' . $route['uri'] . '$#', $uri, $matches)) {
                if (is_string($route['action'])) {
                    [$controllerClass, $method] = explode('::', $route['action']);
                    $controller = new $controllerClass();

                    return $controller->$method();
                } elseif (is_callable($route['action'])) {
                    return call_user_func($route['action']);
                }
            }
        }

        return "404 Not Found";
    }
}