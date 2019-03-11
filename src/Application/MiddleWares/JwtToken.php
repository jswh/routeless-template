<?php


namespace Application\MiddleWares;


use Application\Models\User;
use Routeless\Core\RPC\MiddleWare;
use Routeless\Services\Cfg;
use Firebase\JWT\JWT;

class JwtToken extends MiddleWare {
    public function handle() {
        try {
            $code = $this->request->header('Authorization');
            $code = substr($code, 7);
            $key = Cfg::get('app.auth_key');
            $decode = JWT::decode($code, $key, ['HS256']);
            if ($decode->id) {
                $user = User::get($decode->id);
                $this->request->setAuthUser($user);
            }
        } catch (\Throwable $ex) {
            // todo log middle error
            // dump($ex);
        }
    }
}