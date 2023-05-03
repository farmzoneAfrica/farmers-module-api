<?php

namespace App\Services;

class BaseService
{
    public string $perPage;
    public string $pageStart;
    public string $offSet;
    public string $order;
    public string $dir;

    public function __construct()
    {
        $this->perPage = \request()->limit ?? '-1';
        $this->pageStart = \Request::get('page', 1);
        $this->offSet = ($this->pageStart * $this->perPage) - $this->perPage;
        $this->order = $request->sort_field ?? 'id';
        $this->dir = $request->sort_type ?? 'asc';
    }

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
}
