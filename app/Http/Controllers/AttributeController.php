<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeValue;
use App\Http\Requests\AttributeRequest;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes=Attribute::all();
        return view('admin.attributes.index',['title'=>'Attribute','attributes'=>$attributes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attributes.form',['title'=>'Attribute','blade'=>'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeRequest $request)
    {
        $attribute=new Attribute();
        $attribute->name=$request->name;
        $attribute->save();

        if($request->has('attr'))
        {
            foreach ($request->attr as $row)
            {
                if(!empty($row)) {
                    $value = new AttributeValue();
                    $value->attribute_id = $attribute->id;
                    $value->value = $row;
                    $value->save();
                }
            }
        }
        return redirect(PATH.'/attribute');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        return view('admin.attributes.show',['title'=>'Attribute','data'=>$attribute]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeRequest $request, Attribute $attribute)
    {
        $attribute->name=$request->name;
        $attribute->save();
        return back();
    }

    public function editvalue(Request $request,AttributeValue $value){
        if(isset($request->name)) {
            $value->value = $request->name;
            $value->save();
        }
        return back();
    }
    public function add_values(Request $request,Attribute $attribute){

        foreach ($request->attrs as $row)
        {
            if(!empty($row)) {
                $value = new AttributeValue();
                $value->attribute_id = $attribute->id;
                $value->value = $row;
                $value->save();
            }
        }
        return back();
    }
    public function deletevalue(AttributeValue $value){
        $value->delete();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
       AttributeValue::where('attribute_id',$attribute->id)->delete();
       $attribute->delete();
       return back();
    }
}
