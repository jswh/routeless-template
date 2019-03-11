<?php


namespace Application\Procedures;


use Application\Models\User;
use Routeless\Core\Application;
use Routeless\Core\Exceptions\HttpException;
use Routeless\Core\RPC\Controller;
use Firebase\JWT\JWT;
use Routeless\Services\Cache;
use Services\Sms;

class Auth extends Controller {
    public function acquireByUsername($username, $password) {
        /** @var User $user */
        $user = User::find(compact('username', 'password'), true);

        if (!$user) throw new HttpException(404, 'user not found');
        $token = JWT::encode(['id' => $user->id], Application::config()->get('app.auth_key'));

        return $this->success(compact('token'));
    }

    public function sendSmsVerifyCode($mobile) {
        // todo firewall
        if (!$mobile) throw new HttpException(400, 'mobile not valid');
        $cache = new Cache("Verify:Sms:$mobile", 900);
        $code = randStr(4, '0123456789');
        $cache->put($code);
        Sms::get()->sendVerifyCode($mobile, $code);

        return $this->success(['code' => $code]);
    }

    public function acquireByMobileCode($mobile, $verifyCode) {
        $cache = new Cache("Verify:Sms:$mobile", 900);
        $code = $cache->get();
        if ($code !== $verifyCode) {
            throw new HttpException('403', 'code not match');
        }
        $user = User::achieveByMobile($mobile);
        $token = JWT::encode(['id' => $user->id], Application::config()->get('app.auth_key'));

        return $this->success(['token' => $token]);
    }
}