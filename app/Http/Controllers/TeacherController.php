<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(){
        return view('teacher.index');
    }

    public function allcat(){
        $data= Teacher::orderBy('id','desc')->get();

        return response()->json($data);
    }

    public function addData(Request $request){
        $request->validate([
            'a' => 'required',
            'title' => 'required',
            'institute' => 'required',
        ]);

        $data=Teacher::insert([
            'name'=>$request->a,
            'title'=>$request->title,
            'institute'=>$request->institute,
        ]);

        return response()->json($data);
    }

    public function editData($id)
    {
        $data_get=Teacher::findorFail($id);

        return response()->json($data_get);
    }

    public function updateData(Request $request,$id){
        $request->validate([
            'a' => 'required',
            'title' => 'required',
            'institute' => 'required',
        ]);

        $data=Teacher::findorFail($id)->update([
            'name'=>$request->a,
            'title'=>$request->title,
            'institute'=>$request->institute,
        ]);

        return response()->json($data);
    }

    public function deleteData($id){
        $data_del=Teacher::findorFail($id)->delete();

        return response()->json($data_del);
    }
}
