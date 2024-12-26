<?php

namespace App\Classes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
class ApiResponse
{
    public static function rollback($e, $message ="Something went wrong! Process not completed"){
        DB::rollBack();
        self::throw($e, $message);
    }

    public static function throw($e, $message ="Something went wrong! Process not completed"){
        Log::info($e);
        $response=[
            'success' => false,
            'code'=>500,
            'message'=>$message,
            'data'    => []
        ];
        throw new HttpResponseException(response()->json($response, 500));
    }

    public static function sendResponse($result , $message ,$code=200,$success=true){
        $response=[
            'success' => $success,
            'code'=>$code,
            'message'=>$message,
            'data'    => $result
        ];
        return response()->json($response, $code);
    }

}