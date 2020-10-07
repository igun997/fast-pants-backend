<?php

namespace App\Http\Controllers;

use App\Models\Wooapi as WooapiModel;
use Illuminate\Http\Request;

class WooAPI extends Controller
{
    public function __construct()
    {
        if ($this->identity() === null){
            return $this->response(400,"Invalid Identity");
        }
    }

    private function _listing()
    {
        $id = $this->identity()->id;

        $first = WooapiModel::where(["user_id"=>$id,"is_active"=>1])->first();
        if ($first){
            $first->user;
            return $first;
        }
        return false;

    }
    public function listing()
    {

        $data = $this->_listing();
        if ($data){
            return $this->response(200,"OK",$data);
        }
        return  $this->response(404);
    }

    public function add_site(Request $req)
    {
        $req->validate([
            "name"=>"required",
            "domain"=>"required|unique:wooapi,domain",
            "key_secret"=>"required",
            "is_active"=>"required",
        ]);
        $data = $req->all();
        $data["domain"] = parse_url($data["domain"],PHP_URL_HOST);
        $data["user_id"] = $this->identity()->id;
        $save = WooapiModel::create($data);
        if ($save){
            return $this->response(200,"OK",$save);
        }
        return $this->response(400,"Bad Request");
    }

    public function products()
    {
        if ($this->_listing()){
            $cred = $this->_listing();
            $sk = explode(":",$cred->key_secret);
            $woo = $this->wooClient("https://$cred->domain",$sk[0],$sk[1],[
                'version' => 'wc/v3'
            ]);
            $fast_pants = 424;
            $products = $woo->get("products",["category"=>$fast_pants]);
            return $this->response(200,"OK",$products);
        }
        return $this->response(400);
    }

    public function product_variations($id)
    {
        if ($this->_listing()){
            $cred = $this->_listing();
            $sk = explode(":",$cred->key_secret);
            $woo = $this->wooClient("https://$cred->domain",$sk[0],$sk[1],[
                'version' => 'wc/v3'
            ]);
            $fast_pants = 424;
            $products = $woo->get("products/$id/variations");
            return $this->response(200,"OK",$products);
        }
        return $this->response(400);
    }

    public function current_login(Request $req)
    {
        $req->validate([
            "identifier"=>"required"
        ]);
        if ($this->_listing()){
            $cred = $this->_listing();
            $full_domain = "https://".$cred->domain."/api/user/get_currentuserinfo/";
            $client = $this->wpCurrentUser($full_domain,$req->identifier);
            if ($client !== FALSE){
                $myId = json_decode($client->getBody()->getContents());
                if ($myId){
                    if ($this->_listing()){
                        $cred = $this->_listing();
                        $sk = explode(":",$cred->key_secret);
                        $woo = $this->wooClient("https://$cred->domain",$sk[0],$sk[1],[
                            'version' => 'wc/v3'
                        ]);
                        $data = $woo->get("customers/".$myId->user->id);
                        return $this->response(200,"OK",$data);
                    }
                }

                return $this->response(400,"Request Failed");
            }
        }
        return $this->response(400,"Invalid Woo Token");
    }

    public function generate_cookie(Request $req)
    {
        $req->validate([
            "username"=>"required",
            "password"=>"required",
        ]);
        if ($this->_listing()){
            $cred = $this->_listing();
            $full_domain = "https://".$cred->domain."/api/user/generate_auth_cookie/";
            $client = $this->wpLoginUser($full_domain,$req->all());
            if ($client !== FALSE){
                $myId = json_decode($client->getBody()->getContents());
                if ($myId){
                    return  $this->response(200,"OK",$myId);
                }
                return $this->response(400,"Invalid MyID");
            }
        }
        return $this->response(400,"Invalid Woo Client");
    }

    public function customer($id)
    {
        if ($this->_listing()){
            $cred = $this->_listing();
            $sk = explode(":",$cred->key_secret);
            $woo = $this->wooClient("https://$cred->domain",$sk[0],$sk[1],[
                'version' => 'wc/v3'
            ]);
            $data = $woo->get("customers/$id");
            return $this->response(200,"OK",$data);
        }
        return $this->response(400);
    }

    public function payments()
    {
        $command = "payment_gateways";
        if ($this->_listing()){
            $cred = $this->_listing();
            $sk = explode(":",$cred->key_secret);
            $woo = $this->wooClient("https://$cred->domain",$sk[0],$sk[1],[
                'version' => 'wc/v3'
            ]);
            $data = $woo->get($command);
            return $this->response(200,"OK",$data);
        }
        return $this->response(400);
    }
    public function order(Request $req)
    {
        $req->validate([
            "payment_method"=>"required",
            "payment_method_title"=>"required",
            "billing"=>"required",
            "shipping"=>"required",
            "line_items"=>"required",
            "shipping_lines"=>"required",
            "notes"=>"required"
        ]);
        $data = $req->all();
        $data["set_paid"] = false;

        if ($this->_listing()){
            $cred = $this->_listing();
            $sk = explode(":",$cred->key_secret);
            $woo = $this->wooClient("https://$cred->domain",$sk[0],$sk[1],[
                'version' => 'wc/v3'
            ]);
            $fast_pants = 424;
            $order = $woo->post("orders",$data);
            if ($order){
                foreach ($data["notes"] as $index => $note) {
                    $woo->post("orders/$order->id/notes",$note);
                }
            }
            return $this->response(200,"OK",$order);
        }
        return $this->response(400);


    }

}
