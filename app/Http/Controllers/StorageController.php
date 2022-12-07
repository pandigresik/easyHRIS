<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function __invoke(Request $request)
    {   
        $path = $request->get('path');
                
        abort_if(
            ! Storage::disk('local')->exists($path),
            404,
            "The file doesn't exist. Check the path."
        );

        return Storage::disk('local')->response($path);
    }
}
