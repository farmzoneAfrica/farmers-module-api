<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use function PHPUnit\Framework\isNull;

class BaseController extends Controller
{

    /**
     * @OA\OpenApi(
     *     @OA\Info(
     *         version="1.0",
     *         title="Novel AG API",
     *         description="Agritech Solution API",
     *     )
     * )
     */
    public function sendResponse($result, $msg = null, $token = null): \Illuminate\Http\JsonResponse
    {
        $response = ['success'=>true];
        if (!empty($msg)) $response['message'] = $msg;
        if(!empty($result)) $response['data'] = $result;
        if(!empty($token)) $response['token'] = $token;
        return response()->json($response, 200);
    }

    public function sendError($error_msg, $error=null): \Illuminate\Http\JsonResponse
    {
        $response=[
            'success'=>false,
            'message'=>$error_msg,
        ];
        if(isset($error)) $response['errors'] = $error;
        return response()->json($response, 400);
    }

    //    Set cookie
    public function setCookie($cookie_name, $cookie_value)
    {
        $domain = ($_SERVER['SERVER_NAME'] != 'localhost') ? $_SERVER['SERVER_NAME'] : '.'.$_SERVER['SERVER_NAME'];
        $this->destroyCookie($cookie_name);
        setcookie($cookie_name, $cookie_value, time() + 2147483647, '/', $domain);
    }

    // Get cookie
    public function getCookie($cookie_name)
    {
        if (isset($_COOKIE[$cookie_name])) {
            return $_COOKIE[$cookie_name];
        }
        return false;
    }
    // Has cookie
    public function hasCookie($cookie_name): bool
    {
        if (isset($_COOKIE[$cookie_name])) {
            return true;
        } else {
            return false;
        }
    }

    // Destroy cookie
    public function destroyCookie($cookie_name)
    {
        $domain = ($_SERVER['SERVER_NAME'] != 'localhost') ? $_SERVER['SERVER_NAME'] : '.'.$_SERVER['SERVER_NAME'];
        if (isset($_COOKIE[$cookie_name])) {
            unset($_COOKIE[$cookie_name]);
            setcookie($cookie_name, '', time() - 2147483647, '/',  $domain);
        }
    }

    // Clear cookie
    public function clearCookie()
    {
        $domain = ($_SERVER['SERVER_NAME'] != 'localhost') ? $_SERVER['SERVER_NAME'] : '.'.$_SERVER['SERVER_NAME'];
        if (isset($_COOKIE['novel_token'])) {
            unset($_COOKIE['novel_token']);
            setcookie('novel_token', '', time() - 2147483647, '/', $domain); // empty value and old timestamp
        }
    }

    // Set config mail
    public function Set_config_mail()
    {

        $server = DB::table('servers')->where('deleted_at', '=', null)->first();
        $settings = DB::table('settings')->where('deleted_at', '=', null)->first();
        if ($server && $settings) //checking if table is not empty
        {
            $config = array(
                'driver' => 'smtp',
                'host' => $server->host,
                'port' => $server->port,
                'from' => array('address' => $settings->email, 'name' => 'Admin'),
                'encryption' => $server->encryption,
                'username' => $server->username,
                'password' => $server->password,
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend' => false,
            );
            Config::set('mail', $config);
        }
    }

}
