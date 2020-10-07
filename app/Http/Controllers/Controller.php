<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Automattic\WooCommerce\Client;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function identity()
    {
        return $object = auth()->user();
    }

    public function wooClient($url, $consumer_key, $consumer_secret, $options)
    {
        return $woocommerce = new Client($url, $consumer_key, $consumer_secret, $options);
    }

    public function wpCurrentUser($full_path,$cookie)
    {
        $client = new GuzzleClient([
            'base_uri' => 'http://httpbin.org',
            'timeout'  => 2.0,
        ]);
        try {
            return $client->request("POST",$full_path,[

                'form_params'=>[
                    "cookie"=>$cookie
                ]
            ]);
        } catch (GuzzleException $e) {
            return false;
        }

    }

    public function wpLoginUser($full_path,$data)
    {
        $client = new GuzzleClient([
            'base_uri' => 'https://pridenjoyco.id/',
            'timeout'  => 2.0,
        ]);
        try {
            return $client->request("POST",$full_path,[
                "headers"=>[
                    "Content-Type"=>"application/x-www-form-urlencoded"
                ],
                'form_params'=>$data
            ]);
        } catch (GuzzleException $e) {
            return false;
        }

    }


    public function response($code = 200,$msg="OK",$data=[])
    {
        return response()->json([
            "code"=>$code,
            "msg"=>$msg,
            "data"=>$data,
        ]);
    }
}
