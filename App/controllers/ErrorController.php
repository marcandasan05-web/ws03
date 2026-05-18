<?php

namespace App\Controllers;

class ErrorController
{
    /**
     * Error 404 not found
     * 
     * @return void
     */
    public static function notFound($message = 'Page not found.')
    {
        http_response_code(404);

        loadView('error', [
            'pageTitle' => 'Not Found — RightJob',
            'status' => '404',
            'message' => $message,
        ]);
    }

    /**
     * Error 403 not authorized error
     * 
     * @return void
     */
    public static function unauthorized($message = 'Access denied.')
    {
        http_response_code(403);

        loadView('error', [
            'pageTitle' => 'Access Denied — RightJob',
            'status' => '403',
            'message' => $message,
        ]);
    }
}
