<?php


namespace Application\Models;


use Application\Models\Formatters\UserFormatter;
use Application\Models\Helpers\ExtraColumnHelper;
use Application\Models\Helpers\Timestamps;
use Routeless\Core\Model;

/**
 * Class User
 * @package Application\Models
 * @property String avatar
 * @property String cover
 * @property String constellation
 */
class User extends Model {

    use ExtraColumnHelper;
    use Timestamps;
    use UserFormatter;

    protected $table = 'user';
    protected $appends = ['avatar', 'cover', 'constellation'];

    public $id,$username,$email,$mobile, $password;
    public static function achieveByMobile($mobile) {
        $user = self::getByMobile($mobile);
        if (!$user) {
            $user = self::createByMobile($mobile);
        }

        return $user;
    }

    public static function getByMobile($mobile) {
        return User::read(User::query()
            ->where('mobile', $mobile)
            ->limit(1))->first();
    }

    public static function createByMobile($mobile) {
        $user = new User();
        $user->username = "编号";
        $user->email = $mobile . '@defer.com';
        $user->password = md5(randStr(8));
        $user->mobile = $mobile;
        $user->save();

        $user->username = $user->username . $user->id;
        $user->save();

        return $user;
    }

}