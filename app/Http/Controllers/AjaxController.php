<?php

namespace App\Http\Controllers;

use App\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function get_attribute_value(Request $request)
    {
        $data=AttributeValue::where('attribute_id',$request->id)->orderBy('value','asc')->get();
        return $data;
    }
    public function searchTable(Request $request){
         $result = DB::table($request->table)->where($request->column , 'LIKE', "%$request->search%")->get();
         return view('admin.ajax.product_table',compact('result'));
    }
}
