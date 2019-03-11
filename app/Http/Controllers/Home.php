<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class Home extends Controller
{
    public function getAll(){
        $data = DB::table('contacts')->get();
         return response()->json($data);
    }

    public function store(Request $request)
    {
       $data = array();
       $data['name'] = $request->name;
       $data['email'] = $request->email;
       $data['phone'] = $request->phone;
       $insert = DB::table('contacts')->insert($data);

       $msg = array();
       $msg['success'] = false;
       if($insert){
            $msg['success'] = "Successfully Saved";
       }
       return response()->json($msg);
    }
    public function edit($id)
    {
       $data = DB::table('contacts')->where('id',$id)->first();
       return response()->json($data);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $data = array();
       $data['name'] = $request->name;
       $data['email'] = $request->email;
       $data['phone'] = $request->phone;
       $update = DB::table('contacts')->where('id',$id)->update($data);
       $msg = array();
       $msg['success'] = false;
       if($update){
             $msg['success'] = "Successfully Updated";
       }
       return response()->json($msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
       $delete = DB::table('contacts')->where('id',$id)->delete();
       $msg = array();
       $msg['success'] = false;
       if($delete){
            $msg['success'] = true;;
       }
       return response()->json($msg);
    }
}
