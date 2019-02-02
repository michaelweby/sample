<?php

namespace App\Http\Controllers;

use App\Http\FileUploaders\ProductUploader;
use App\Http\FileUploaders\UserUploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExcelController extends Controller
{
    public function importExportExcelORCSV(){
        return view('admin.file_import_export',['title'=>'Upload CSV']);
    }
    public function switchUploader(Request $request){
//        dd($request->has('csv'));
        if ($request->model == 'product'){
            $file = new FileController(new ProductUploader());
        }elseif($request->model == 'user'){
            $file = new FileController(new UserUploader());
        }
        if($request->has('csv')) {
            $path = $request->file('csv')->getRealPath();
            $data = \Excel::load($path)->get();
        }


        $file->importFileIntoDB($data);
    }
}
