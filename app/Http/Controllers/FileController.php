<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\FileUploaders\FileUploader;
use Illuminate\Http\Request;

class FileController extends Controller
{
    protected $fileUploader;

    /**
     * FileController constructor.
     * @param $productUploader
     */
    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    public function importExportExcelORCSV(){
        return view('admin.file_import_export');
    }
    public function importFileIntoDB($data){
            if($data->count()){
                $arr = $this->fileUploader->upload($data);
                $this->fileUploader->insert($arr);
            }
        dd('Request data does not have any files to import.');
    }
//    public function downloadExcelFile($type){
//        $products = Product::get()->toArray();
//        return \Excel::create('expertphp_demo', function($excel) use ($products) {
//            $excel->sheet('sheet name', function($sheet) use ($products)
//            {
//                $sheet->fromArray($products);
//            });
//        })->download($type);
//    }

}
