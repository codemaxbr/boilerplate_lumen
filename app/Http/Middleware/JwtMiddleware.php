<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();
        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            $request['user'] = User::find($credentials->user->id);
            return $next($request);
            /*
            if($credentials->iss == "admin")
            {
                if(Cache::has($token)){
                    $user = Cache::get($token);
                }else{
                    $now = Carbon::now();
                    $validade = Carbon::createFromTimestamp($credentials->exp);

                    $user = Cache::remember($token, $now->diffInSeconds($validade), function() use ($credentials){
                        return \App\Models\Usuario::find($credentials->id);
                    });
                }

                if($user->account->id == $credentials->acc)
                {
                    if(!Cache::has('account_'.$credentials->acc)){
                        Cache::rememberForever('account_'.$credentials->acc, function () use ($user){
                            return $user->account;
                        });
                    }
                    return $next($request);
                }else{
                    return response()->json([
                        'error' => 'Tentativa XSS Cross-Site Scripting detectado. [xss]'
                    ], Response::HTTP_UNAUTHORIZED);
                }
            }

            else{
                return response()->json([
                    'error' => 'Acesso restrito apenas para Administradores'
                ], Response::HTTP_FORBIDDEN);
            }
            */

        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'O token expirou.'
            ], Response::HTTP_UNAUTHORIZED);

        } catch(\Exception $e) {
            return response()->json([
                'error' => 'Não foi possível decodificar o token.',
                'exception' => $e->getMessage()
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
