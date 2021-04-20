<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function view(?string $view = null,
                            iterable $data = [],
                            int $status = 200,
                            array $headers = []
    ): Response
    {
        return response()->view($view, $data, $status, $headers);
    }

    protected function back(bool $success, iterable $data = []): Response
    {
        return redirect()->back()->withSuccess(['status' => $success, 'data' => $data]);
    }
}
