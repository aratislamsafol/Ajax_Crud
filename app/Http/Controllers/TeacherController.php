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
}
