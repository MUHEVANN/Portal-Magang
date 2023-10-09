<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ketua = User::with('konfirmed')->find(auth()->user()->id);
        $konfirmed_ketua = $ketua->konfirmed->last();
        if (!$konfirmed_ketua) {
            return $next($request);
        }
        $konfirmed_at = $konfirmed_ketua->created_at;
        $sixtyDaysAgo = $konfirmed_at->addDays(10);

        if (now()->gte($sixtyDaysAgo)) {
            return $next($request);
        } else {
            $time = $sixtyDaysAgo->diffInDays(now());
            return redirect()->back()->with('error', 'Anda sudah melakukan applyan dan dikonfirmasi, tunggu' . $time . ' hari lagi untuk melakukan apply');
        }

        $email = $request->email;
        for ($i = 0; $i < count($email); $i++) {
            $user = User::where('email', $email[$i])->first();
            if (!$user) {
                return $next($request);
            }
            $konfirm_user = $user->konfirmed->last();
            if (!$konfirm_user) {
                return $next($request);
            }
            $konfirmed_at = $konfirm_user->created_at;
            $sixtyDaysAgo = $konfirmed_at->addDays(60);

            if (now()->gte($sixtyDaysAgo)) {
                return $next($request);
            } else {
                return redirect()->back()->with('error', 'Anggota anda sudah melakukan applyan dan dikonfirmasi, tunggu 60 hari lagi untuk melakukan apply');
            }
        }
    }
}
