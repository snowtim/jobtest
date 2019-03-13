<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends Controller
{

    protected function create(Request $request) {

    	$validator = Validator::make($request->all(), [
    		'Account' => ['required', 'string', 'unique:users', 'max:50'],
    		'Password' => ['required', 'string', 'max:50']
    	]);

    	if($validator->fails()) {
    		return response()->json([
    			'result' => 'false',
    			'response' => $validator->errors()->first()
    		]);	
    	}

    	User::create([
    		'account' => $request['Account'],
    		'password' => $request['Password']
    	]);

    	return response()->json([
    		'Code' => 0,
    		'Message' => "",
    		'Result' => [
    			'IsOK' => true
    		]
    	]);

    }

    protected function delete(Request $request) {

  	  	$validator = Validator::make($request->all(), [
    		'Account' => ['required', 'string', 'max:50'],
    	]);

    	if($validator->fails()) {
    		return response()->json([
    			'result' => 'false',
    			'response' => $validator->errors()->first()
    		]);	
    	}

    	User::where('account', $request['Account'])->delete();

    	return response()->json([
    		'Code' => 0,
    		'Message' => "",
    		'Result' => [
    			'IsOK' => true
    		]
    	]);
    	
    }

    protected function update(Request $request) {
    	
    	$validator = Validator::make($request->all(), [
    		'Account' => ['required', 'string', 'max:50'],
    		'Password' => ['required', 'string', 'max:50']
    	]);

    	if($validator->fails()) {
    		return response()->json([
    			'result' => 'false',
    			'response' => $validator->errors()->first()
    		]);	
    	}

    	User::where('account', $request['Account'])->update([
    		'password' => $request['Password']
    	]);

    	return response()->json([
    		'Code' => 0,
    		'Message' => "",
    		'Result' => [
    			'IsOK' => true
    		]
    	]);

    }

    protected function login(Request $request) {

    	$validator = Validator::make($request->all(), [
    		'Account' => ['required', 'string', 'max:50'],
    		'Password' => ['required', 'string', 'max:50']
    	]);

    	if($validator->fails()) {
    		return response()->json([
    			'result' => 'false',
    			'response' => $validator->errors()->first()
    		]);	
    	}

    	$userinfo = User::where('account', $request['Account'])->get()->first();

    	if($userinfo != null) {
    		if($userinfo['account'] == $request['Account'] && $userinfo['password'] == $request['Password']) {
    			return response()->json([
    				'Code' => 0,
    				'Message' => "",
    				'Result' => 200
    			]);
    		} 
    			return response()->json([
    				'Code' => 2,
    				'Message' => "Login Failed",
    				'Result' => 400
    			]);
    		
    	}
    	return response()->json([
    		'Code' => 2,
    		'Message' => "Login Failed",
    		'Result' => 400
    		]);

    }

}
