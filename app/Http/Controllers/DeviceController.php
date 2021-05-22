<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    function list()
    {
        return Device::all();
    }

    function add(Request $request)
    { 
        $device = new Device;
        $device->name = $request->name;
        $device->count = $request->count;
        $result = $device->save();

        if($result)
        {
            return ["Result" => "Data has been saved!"];
        } 
        else 
        {
            return ["Result" => "Failed!"];
        }

    }

    function test(Request $request){
        $rules = array(
            'name' => 'required|unique:devices|min:5',
            'count' => 'required',
        );
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails())
        {
            return $validator->errors();
        }
        else {
            $device = new Device;
            $device->name = $request->name;
            $device->count = $request->count;
            $result = $device->save();
    
            if($result)
            {
                return ["Result" => "Data has been saved!"];
            } 
            else 
            {
                return ["Result" => "Failed!"];
            }
        }
    }

    function testup(Request $request){
        $device = Device::find($request->id);
        $device->name = $request->name;
        $device->count = $request->count;
        $result = $device->save();

        if($result)
        {
            return ["Result" => "update Data has been saved!"];
        } 
        else 
        {
            return ["Result" => "update Failed!"];
        }
    }

    function testse($name){
        $searchResult = Device::where("name","like","%".$name."%")->get();
        // return Device::where("name","like","%".$name."%")->get();

        if($searchResult->isEmpty()){
            return ["Result" => "No result found!"];
        } else {
            return $searchResult;
        }
    }

}
