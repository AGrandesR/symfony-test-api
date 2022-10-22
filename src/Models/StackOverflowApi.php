<?php
namespace App\Models;

use App\Models\Common\Api;

use DateTime;

class StackOverflowApi extends Api{
    private string $url = 'https://api.stackexchange.com/2.3/questions?site=stackoverflow';

    function getQuestions(string $tagged=null,string $todate=null,string $fromdate=null) {
        try {
            $params='';
            if(isset($tagged)) {
                $params .= "&tagged=$tagged";
            }
            if(isset($todate)) {
                $dateTime = new DateTime($todate);
                $timestamp = $dateTime->format('U');
                $params .= "&todate=$timestamp";
            }
            if(isset($fromdate)) {
                $dateTime = new DateTime($fromdate);
                $timestamp = $dateTime->format('U');
                $params .= "&fromdate=$timestamp";
            }
            
            header('Content-type: application/json');
            $url=$this->url . $params; //We create the final URL with the params that we had parse to be equal to stack api

            return [
                'status'=>'ok',
                'data'=>json_decode($this->get($url),true)['items'] //We return only the items
            ];
        } catch (Exception | Error $e) {
            header('Content-type: application/json');
            return [
                'status'=>'ko',
                'data'=>[],
                'meta'=>[
                    'error'=>$e->getMessage()
                ]
            ];
        }
        
    }
}