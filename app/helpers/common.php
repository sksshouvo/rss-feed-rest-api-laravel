<?php

// helpers.php

if (!function_exists('successResponse')) {
    function successResponse($token, $data, $msg, $statusCode = 200) {
        return response()->json(
            [
                'success' => true,
                'errors'  => [],
                'token'   => $token,
                'data'    => $data,
                'message' => $msg
            ], 
            $statusCode
        );
    }
}

if (!function_exists('myResponse')) {
    function errorResponse($errors, $msg, $statusCode = 500) {
        return response()->json(
            [
                'success' => false,
                'errors'  => $errors,
                'token'   => NULL,
                'data'    => NULL,
                'message' => $msg
            ], 
            $statusCode
        );
    }
}
