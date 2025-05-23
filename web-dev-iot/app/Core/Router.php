<?php
class Router
{
    private $routes = [];
    public function add(string $method, string $path, callable $action)
    {
        $this->routes[] = compact('method','path','action');
    }
    public function dispatch(string $method, string $uri)
    {
        $parsed = parse_url($uri);
        $path = rtrim($parsed['path'], '/');
        foreach ($this->routes as $r) {
            if ($r['method'] === $method && $r['path'] === $path) {
                return call_user_func($r['action']);
            }
        }
        http_response_code(404);
        echo "Not Found";
    }
}
?>