<?php

namespace App\Http\Middleware;

use Silber\Bouncer\Bouncer;
use Closure;

class ScopeBouncer
{
    /**
     * The Bouncer instance.
     *
     * @var \Silber\Bouncer\Bouncer
     */
    protected $bouncer;

    /**
     * Constructor.
     *
     * @param \Silber\Bouncer\Bouncer  $bouncer
     */
    public function __construct(Bouncer $bouncer)
    {
        $this->bouncer = $bouncer;
    }

    /**
     * Set the proper Bouncer scope for the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $tenantId = 0;
        if ($request->user() && $request->user()->publicAdministration) {
            $tenantId = $request->user()->publicAdministration->id;
        }

        $this->bouncer->scope()->to($tenantId);

        return $next($request);
    }
}
