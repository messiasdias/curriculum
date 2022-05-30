<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageNavegation;
use App\Models\Page;
use \BrowserDetect as Browser;

class PageNavegationRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $explodedPath = explode('/', $request->path());

        $slug = $explodedPath[0];
        $items_id = count($explodedPath) === 2 ? (int) $explodedPath[1] : null;
        $items_id = $items_id > 0 ? $items_id : null;

        if (!$slug) $slug = "teaser";
        if (strpos($request->path(), 'cases/') === 0) $slug = "interna-cases"; 

        $page = Page::getBySlug($slug);

        if ($page instanceof Page) {
            $uuid = $request->cookie('user_device_uuid');
            $pageNavegation = null;

            if ($uuid) $pageNavegation = PageNavegation::getToday($uuid, $page->id, $items_id);
            else $uuid = PageNavegation::generateUUID($page->id, $items_id);
            
            if ($pageNavegation) {
                $pageNavegation->views++;
            } else {                  
                $pageNavegation = new PageNavegation([
                    'pages_id' => $page->id,
                    'items_id' => $items_id > 0 ? $items_id : null,
                    'user_device_ip' => $request->ip(),
                    'user_device_uuid' => $uuid
                ]);
            }

            if ($pageNavegation) {
                $types = [
                    "mobile" => Browser::isMobile(),
                    "table" => Browser::isTablet(),
                    "desktop" => Browser::isDesktop(),
                    "bot" => Browser::isBot()
                ];

                $device_type = implode('', array_filter(array_keys($types), function($type) use ($types) {
                    if ($types[$type]) return $type;
                    return null;
                }));

                if (!$pageNavegation->items_id && $items_id) $pageNavegation->items_id = $items_id;
                if (!$pageNavegation->user_name) $pageNavegation->user_name = $request->cookie('user_name');
                if (!$pageNavegation->user_email) $pageNavegation->user_email = $request->cookie('user_email');
                if (!$pageNavegation->user_phone) $pageNavegation->user_phone = $request->cookie('user_phone');
                if (!$pageNavegation->user_device_vendor) $pageNavegation->user_device_vendor = Browser::browserName();
                if (!$pageNavegation->user_device_type) $pageNavegation->user_device_type = $device_type;
                if (!$pageNavegation->user_device_platform) $pageNavegation->user_device_platform = Browser::platformName();
                if (!$pageNavegation->user_location_lat) $pageNavegation->user_location_lat = $request->cookie('user_location_lat', 0);
                if (!$pageNavegation->user_location_long) $pageNavegation->user_location_long = $request->cookie('user_location_long', 0);

                $pageNavegation->save();
            }

            return $next($request)->withCookie(cookie('user_device_uuid', $uuid, 527040));
        }

        return $next($request);
    }
}
