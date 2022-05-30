<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Contact;

class ConfirmContact
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
        if ($request->filled("contacts-email-confirmation")) {
            Contact::setEmailConfirmation(
                $request->input('contacts-email-confirmation')
            );
        }

        if (
            $request->filled("contacts-phone-confirmation") && 
            $request->filled("contacts-phone-confirmation-code")
        ) {
            Contact::setPhoneConfirmation(
                $request->input('contacts-phone-confirmation'),
                $request->inpout("contacts-phone-confirmation-code")
            );
        }

        return $next($request);
    }
}
