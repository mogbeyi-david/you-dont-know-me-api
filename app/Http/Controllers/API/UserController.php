<?php

namespace App\Http\Controllers\API;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

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
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all(); //Get all the input parameters into an array
        $input['password'] = Hash::make($input['password']); //Hash the password and save back into array
        $user = User::create($input); //Create the user
        $success['token'] = $user->createToken('MyApp')->accessToken; //Generate access token
        $success['name'] = $user->name; // Get the user name
        return response()->json(['success' => $success], 201); //Return response to client
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user(); // Fetch the authenticated user
            $success['token'] = $user->createToken('MyApp')->accessToken; // Generate token for user
            return response()->json(['success' => $success], 200); // Return success response to client
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $updateUser = User::where('id', $id)->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password'])
            ]);
        } catch (QueryException $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()]);
        }

        if (!$updateUser) {
            return response()->json(['status' => 'failure', 'data' => "Information could not be updated"], 400);
        }
        return response()->json(['status' => 'success', 'data' => null], 200);
    }

    public function getAll()
    {
        try {
            $users = User::all();
        } catch (QueryException $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()]);
        }

        if(!$users){
            return response()->json(['status' => 'failure', 'data' => "Data could not be fetched at this time"], 503);
        }

        return response()->json(['status' => 'success', 'data' => $users], 200);
    }




}
