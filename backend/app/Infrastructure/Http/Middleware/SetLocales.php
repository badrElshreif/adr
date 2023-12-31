<?php

namespace App\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;

class SetLocales
{
    /**
     * Localization constructor.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // read the language from the request header
        $locale = $request->header('Accept-Language');

        // if the header is missed
        if (! $locale) {
            // take the default local language
            $locale = config('app.locale');
//            $locale = $this->app->config->get('app.locale');
        }
        // check the languages defined is supported
        if (! array_key_exists($locale, ['en' => 'English', 'ar' => 'Arabic'])) {
            $locale = config('app.locale');
            // respond with error
//            return abort(403, 'Language not supported.');
        }

        // set the local language
        $this->app->setLocale($locale);

        // get the response after the request is done
        $response = $next($request);

        // set Content Languages header in the response
        $response->headers->set('Accept-Language', $locale);

        // return the response
        return $response;
    }
}
