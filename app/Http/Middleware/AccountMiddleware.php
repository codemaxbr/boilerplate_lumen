<?php

namespace App\Http\Middleware;

use App\Models\Account;
use Closure;

class AccountMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->hasHeader('domain')) {
            $request['errors'] = ['headers' => [
                'domain' => ['Domínio não informado.']
            ]];
        } else {
            $account = Account::query()
                ->where(['domain' => $request->header('domain')])
                ->orWhere(['alias' => $request->header('domain')])
                ->get();

            if ($account->isEmpty()) {
                $request['errors'] = ['headers' => [
                    'domain' => ['Domínio não encontrado.']
                ]];
            } else {
                $request['account'] = $account->first();
            }
        }

        return $next($request);
    }
}
