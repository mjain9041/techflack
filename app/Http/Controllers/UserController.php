<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page=0,$search = NULL)
    {   
       $userData = User::query();
       $userCount = User::query();
       if(!empty($search)){
           $userData = $userData->where('name', 'like', '%'.$search.'%');
           $userCount = $userCount->where('name', 'like', '%'.$search.'%');
       } 
       $userData =  $userData->orderBy('updated_at','DESC')->offset($page*10)->limit(10)->get();
       $userCount = $userCount->count();
       return response()->json([
        'status' => 'success',
        'userData' => $userData,
        'userCount' => round($userCount/10)
       ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messsage'=>$validator->errors()->first()
               ],200);
         }
        $path = $request->file('profile_pic')->store('img');
        $data = $request->all();
        $data['profile_pic'] = $path;
        $data['password'] = \Hash::make('123456789');
        $insert = User::create($data);
       if(!empty($insert)) {
        return response()->json([
            'status' => 'success',
           ],200);
       }
       return response()->json([
        'status' => 'error',
       ],500);

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userData = User::find($id);
        if(!empty($userData)) {
        return response()->json([
            'status' => 'success','userData' => $userData
            ],200);
        }
        return response()->json([
        'status' => 'error',
        ],500);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.$request->id,
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messsage'=>$validator->errors()->first()
               ],200);
         }
        $userData = User::find($request->id);
        $userData->name = $request->name;
        $userData->email = $request->email;
        $userData->contact_no = $request->contact_no;
        if(!empty(request('profile_pic'))) {
            $path = $request->file('profile_pic')->store('img');
            $userData->profile_pic = $path;
        }
        $userData->save();
        if(!empty($userData)) {
        return response()->json([
            'status' => 'success',
            ],200);
        }
        return response()->json([
        'status' => 'error',
        ],500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteData = User::where('id',$id)->delete();
        if($deleteData){
            return response()->json([
                'status' => 'success',
               ],200);
        }
        return response()->json([
                'status' => 'error',
               ],200);
        
    }
}
