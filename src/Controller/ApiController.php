<?php
// src/Controller/ApiController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Models\StackOverflowApi;

class ApiController
{
    public function index(string $slug)
    {
        $errors=[];

        //region Filters
        $tagged=$slug; //Filtro obligatorio.
        if(empty($tagged)) $errors = 'Not detected any tag to check';

        $todate=$_GET['todate']??null; //Filtro opcional.
        if(isset($todate) && !$this->checkdate($todate)) $errors[]="Bad format in 'todate' parameter YYYY-MM-DD expected";

        $fromdate=$_GET['fromdate']??null; //Filtro opcional
        if(isset($fromdate) && !$this->checkdate($fromdate)) $errors[]="Bad format in 'fromdate' parameter YYYY-MM-DD expected";
        //endregion

        //region CHECK errors
        if(!empty($errors))
            return new Response(
                json_encode([
                    'status'=>'ko',
                    'data'=>[],
                    'meta'=>[
                        'error'=>'Detected errors in the request',
                        'errors'=>$errors
                    ]
                ]),
                400,
                array_merge($headers=[], ['Content-Type' => 'application/json;charset=UTF-8'])
            );
        //endregion
        
        //region Call model
        $api = new StackOverflowApi();
        $data=$api->getQuestions($tagged,$todate,$fromdate);
        //endregion

        return new Response(
            json_encode($data),
            200,
            array_merge($headers=[], ['Content-Type' => 'application/json;charset=UTF-8'])
        );
        //https://lindevs.com/methods-to-return-object-as-json-response-in-symfony/)
    }
    private function checkdate($date) : bool {
        return preg_match('/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/', $date ) ? true : false;
    }
}