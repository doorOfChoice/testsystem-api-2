<?php

namespace App\Tool;

class ResponseTool{
    const OK        = 200;

    const CREATED   = 201;

    const REDIRECT  = 302;

    const NO_CONTENT = 204;

    const UNAUTHORIZED = 401;

    const FORBIDDEN = 403;

    const NOT_FOUND = 404;

    public static function back($datas = [], $code = self::OK, $status = ''){
        $result = [
            'datas' => $datas,
            'status' => $status
        ];
        return response($result, $code);
    }
}
