<?php

namespace App\Helpers;

class GeneralApiResponse
{
    static function apiResponse($status = null, $statusCode = 200, $msg = null, $data = null)
    {
        return response()->json([
            'status' => $status,
            'statusCode' => $statusCode,
            'message' => $msg,
            'data' => $data,
        ], $statusCode);

        return response($array);
    }

    static function returnError($statusCode = 500, $msg = "")
    {
        return response()->json([
            'status' => false,
            'statusCode' => $statusCode,
            'msg' => $msg
        ], $statusCode);
    }

    static function returnSuccess($statusCode = 200, $msg = "")
    {
        return response()->json([
            'status' => true,
            'statusCode' => $statusCode,
            'msg' => $msg
        ], $statusCode);
    }

    static function returnData($key, $value, $msg = "")
    {
        return response()->json([
            'status' => true,
            'statusCode' => 200,
            'msg' => $msg,
            $key => $value
        ]);
    }

    static function returnValidationError($statusCode = 422, $validator)
    {
        return response()->json([
            'status' => false,
            'statusCode' => $statusCode,
            'msg' => $validator->errors(),
        ], $statusCode);
    }

    static function handlePaginate(object $object, string  $res)
    {
        return [
            'data' => $res::collection($object),
            'next_page_url' => $object->nextPageUrl(),
            'prev_page_url' => $object->previousPageUrl(),
            'current_page' => $object->currentPage(),
            'last_page' => $object->lastPage(),
            'per_page' => $object->perPage(),
        ];
    }
}
