<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class ApiController extends Controller{

    protected $statusCode = 200;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return ApiController
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function respond($data,$headers = []){
        return  response()->json($data , $this->getStatusCode() , $headers);
    }

    public function responseWithError($message){
        return $this->respond([
            'status'=>'error',
            'error'=>[
                'message'=>$message,
                'code'=>$this->getStatusCode(),
            ]
        ]);
    }
    public  function responseSuccess($message = 'Your Request is done'){
        return $this->respond([
            'status'=>'OK',
            'data'=>$message
        ]);
    }
    public function responseDone($message = 'Your Request is done'){
        return $this->setStatusCode(200)->responseSuccess($message);
    }
    public function responseNotFound($message = 'Not Found!'){
        return $this->setStatusCode(214)->responseWithError($message);
    }
    public function responseWrongData($message = 'Wrong Data!'){
        return $this->setStatusCode(215)->responseWithError($message);
    }
    public function responseWrongValidation($message = 'Wrong Validation!'){
        return $this->setStatusCode(216)->responseWithError($message);
    }
}