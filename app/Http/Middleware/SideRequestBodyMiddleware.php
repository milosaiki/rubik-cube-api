<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SideRequestBodyMiddleware
{
    private const REQUIRED_BODY_PARAMETERS = [
        'direction', 'row', 'column'
    ];

    private const ALLOWED_OPTIONS = [
        'direction' => ['up', 'down', 'left', 'right'],
        'row' => ['top', 'middle', 'bottom'],
        'column' => ['left', 'middle', 'right']
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $body = json_decode($request->getContent(), true);

        foreach ($body as $key => $value) {
            if (!$this->isInRequiredParameters($key) || !$this->isValueAllowed($key, $value)) {
                return response('Bad request', 400)->header('Content-Type', 'text/json');
            }
        }

        return $next($request);
    }

    private function isInRequiredParameters(string $parameter): bool
    {
        return in_array($parameter, self::REQUIRED_BODY_PARAMETERS);
    }

    private function isValueAllowed(string $key, string $value): bool
    {
        return in_array($value, self::ALLOWED_OPTIONS[$key]);
    }
}
