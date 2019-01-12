<?php

namespace arifsajal\GpSmsGateway\Services;

use GuzzleHttp\Client;

class GpSmsGateway
{
    protected $config;

    protected $username;

    protected $password;

    protected $fullApiUrl = "https://cmp.grameenphone.com/gpcmpapi/messageplatform/controller.home";

    protected $contacts;

    protected $message;

    protected $contactsString;

    protected $messageType;

    protected $sender;

    protected $apiResponse;

    protected $formattedServerResponse;

    protected $language;

    protected $countryCode = "880";

    public function contacts($contacts){
        if(is_string($contacts)):
            $this->contacts = $contacts;
        elseif(is_array($contacts)):
            $this->contacts = $contacts;
        endif;

        if(is_array($contacts) && count($contacts) > 0):
            $string = "";
            foreach($contacts as $contact):
                $string .= $contact.',';
            endforeach;
            $this->contactsString = str_replace('+88','',rtrim($string,','));
        else:
            $this->contactsString = str_replace('+88','',$contacts);
        endif;

        return $this;
    }

    public function language($language){
        if($language){
            $this->language = $language;
        }
        if($this->language == "ENGLISH"):
            $this->messageType = 1;
        elseif($this->language == "BANGLA"):
            $this->messageType = 3;
        endif;
        return $this;
    }

    public function countryCode($countryCode){
        if($countryCode){
            $this->countryCode = $countryCode;
        }
        return $this;
    }

    public function message($message){
        if($message):
            $this->message = $message;
        endif;
        return $this;
    }

    public function sender($sender){
        if($sender):
            $this->sender = $sender;
        endif;
        return $this;
    }

    public function send(){
        $queries = [
            'msisdn'=>$this->contactsString,
            'message'=>$this->message,
            'username'=>$this->username,
            'password'=>$this->password,
            'messageid'=>0,
            'apicode'=>1,
            'messagetype'=>1,
            'countrycode' => $this->countryCode,
            'cli' => $this->sender,
        ];
        $client = new Client([
            'verify' => false,
        ]);
        $response = $client->request('GET',$this->fullApiUrl,['query'=>$queries]);
        $this->apiResponse = ['statusCode'=>$response->getStatusCode(),'reasonPhrase'=>$response->getReasonPhrase(),'serverResponse'=>$response->getBody()->getContents()];
        return $this;
    }

    public function config($array){
        $this->__setConfig($array);
        return $this;
    }

    protected function __setConfig($array){
        if(array_key_exists('username',$array) && array_key_exists('password',$array)):
            $this->config = $array;
            $this->username = $array['username'];
            $this->password = $array['password'];

            if(array_key_exists('full_api_url',$array)):
                $this->fullApiUrl = $array['full_api_url'];
            endif;
        endif;
        return $this;
    }
}
