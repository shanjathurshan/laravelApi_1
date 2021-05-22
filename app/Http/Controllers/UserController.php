<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // print_r($user);
            
            if (!$user) {
                return response(['message' => ['User not found!']], 404);
            }
            if (!Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
            
        
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
             return response($response, 201);
    }

    function signup(Request $request)
    { 
        $rules = array(
            'name' => 'required|min:5|string',
            'email' => 'required|email|unique:users',
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols(), ],
        );
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails())
        {
            // return $validator->errors();
            return response($validator->errors(), 400);
        }
        else {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $result = $user->save();
            
            if($result)
            {
                return ["Result" => "user Data has been saved!"];
            } 
            else 
            {
                return ["Result" => "user saved Failed!"];
            }
        }

    }

    function updateUser(Request $request)
    { 
        $rules = array(
            'id' => 'required',
            'name' => 'required|min:5|string',
            'email' => 'required|email',
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols(), ],
        );
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails())
        {
            // return $validator->errors();
            return response($validator->errors(), 400);
        }
        else {
            $user = User::find($request->id);
            $user->id = $request->id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $result = $user->save();
            
            if($result)
            {
                return ["Result" => "user Data has been saved!"];
            } 
            else
            {
                return ["Result" => "user saved Failed!"];
            }
        }

    }
    

    function deleteUser(Request $request)
    { 
            $user = User::find($request->id);
            $result = $user->delete();

            if($result)
            {
                return ["Result" => "user Data has been deleted!"];
            } 
            else
            {
                return ["Result" => "user delete Failed!"];
            }
    }


}
