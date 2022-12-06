<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Http\Request;
use Response;

class ImportController extends AppBaseController
{
    /**
     * Show the form for creating a new Company.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        return view('base.import.create')->with(['urlOrigin' => $request->input('urlOrigin')]);
    }

    protected function store(Request $request)
    {
        $urlOrigin = substr($request->input('urlOrigin'),strlen(config('app.url')));
        $urlArray = parse_url($urlOrigin);
        
        $model = $this->getModel($urlArray['path']);

        $modelImport = '\\App\Imports\\'.$model.'Import';

        try {
            (new $modelImport())->import($request->file('file_upload'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                array_push(
                    $messages,
                    'row number : '.$failure->row() // row that went wrong
                    .'attribute : '.$failure->attribute() // either heading key (if using heading row concern) or column index
                    .'errors : '.$failure->errors() // Actual error messages from Laravel validator
                    .' values : '.$failure->values() // The values of the row that has failed.
                );
            }

            Flash::error('Data imported failed <br />'.join('<br />', $messages));

            return redirect();
        }
        Flash::success('Data imported successfully');

        return redirect($urlOrigin);
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
