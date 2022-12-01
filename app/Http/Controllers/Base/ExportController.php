<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

class ExportController extends AppBaseController
{
    public function index(Request $request)
    {
        // $urlOrigin = parse_url($request->input('urlOrigin'));
        $urlOrigin = parse_url(substr($request->input('urlOrigin'),strlen(config('app.url'))));
        $model = $this->getModel($urlOrigin['path']);
        $fileName = str_replace('\\', '_', $model);
        $modelEksport = '\\App\Exports\\Template\\'.$model.'Export';

        return (new $modelEksport(true))->download($fileName.'.xls');
    }

    private function getModel($path)
    {
        $modelPath = explode('/', $path);
        $result = [];
        array_walk($modelPath, function ($item) use (&$result) {
            if (!empty($item)) {
                array_push($result, \Str::ucfirst($item));
            }
        });
        $lastIndex = count($result) - 1;
        $result[$lastIndex] = \Str::ucfirst(\Str::singular(end($result)));

        return implode('\\', $result);
    }
}
