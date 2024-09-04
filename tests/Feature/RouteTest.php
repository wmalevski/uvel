<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use Exception;
use App\User;

class RouteTest extends TestCase
{
    /**
     * Test all routes in the application.
     *
     * @return void
     */
    public function testAllRoutes()
    {
        $user = User::first();
        $this->actingAs($user, 'web');
        $routes = Route::getRoutes();
        foreach ($routes as $route) {
            if (!in_array('GET', $route->methods()) && 
                !in_array('POST', $route->methods()) && 
                !in_array('PUT', $route->methods()) && 
                !in_array('PATCH', $route->methods()) && 
                !in_array('DELETE', $route->methods())) {
                continue;
            }

            $this->actingAs($user, 'web');
            $uri = $route->uri();
            $uri = $this->mockRouteParameters($uri, $route->parameterNames());

            if ($this->shouldSkipRoute($uri)) {
                continue;
            }

            $this->actingAs($user, 'web');
            foreach ($route->methods() as $method) {
                if ($method !== 'HEAD') {
                    $response = $this->call($method, $uri);

                    if ($response->status() === 500) {
                        throw new Exception("Route {$method} {$uri} returned status 500. Exception: " . $response->getContent());
                    }

                    $this->assertTrue(
                        in_array($response->status(), [200, 302]),
                        "Route {$method} {$uri} returned status {$response->status()}"
                    );
                }
            }
        }
    }

    /**
     * Mock route parameters with example values.
     *
     * @param string $uri
     * @param array $parameters
     * @return string
     */
    protected function mockRouteParameters($uri, $parameters)
    {
        foreach ($parameters as $parameter) {
            $uri = str_replace('{' . $parameter . '}', '1', $uri);
        }

        return $uri;
    }

    protected function shouldSkipRoute(string $uri): bool
    {
        $patterns = [
            '_debugbar',
            'horizon',
            'telescope',
            'nova-api',
            'oauth',
            'sanctum',
            '_ignition',
            'gdpr/download',
            'ajax/selling/certificate',
        ];

        foreach ($patterns as $pattern) {
            if (str_contains($uri, $pattern)) {
                return true;
            }
        }

        return false;
    }
}
