<?php

namespace App\Http\Controllers\API;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Classes\Response as apiResponse;

class UserController extends Controller
{
    public function register(Request $request)
    {
        //Validate the user input
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return apiResponse::error(401, $validator->errors());
        }

        $input = $request->all(); //Get all the input parameters into an array
        $input['password'] = Hash::make($input['password']); //Hash the password and save back into array
        $user = User::create($input); //Create the user
        $success['token'] = $user->createToken('MyApp')->accessToken; //Generate access token
        $success['name'] = $user->name; // Get the user name
        return apiResponse::success(201, $success); //Return response to client
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user(); // Fetch the authenticated user
            $success['token'] = $user->createToken('MyApp')->accessToken; // Generate token for user
            return apiResponse::success(200, $success);  // Return success response to client
        } else {
            return apiResponse::error(401, null);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            User::where('id', $id)->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password'])
            ]);
            return apiResponse::success(200);
        } catch (QueryException $exception) {
            return apiResponse::error(503, $exception->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $users = User::all();
            return apiResponse::success(200, $users);
        } catch (QueryException $exception) {
            return apiResponse::error(503, $exception->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            User::destroy($id);
            return apiResponse::success(200);
        } catch (QueryException $exception) {
            return apiResponse::error(503, $exception->getMessage());
        }
    }


}
