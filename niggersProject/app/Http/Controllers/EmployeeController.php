<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class EmployeeController extends Controller
{
    public function create(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'birth_date' => 'required|date',
            'salary' => 'required|integer',
            'frontImage' => 'required|file|mimes:png,jpg,jpeg'
        ]);

        $name = time().'_'.uniqid().'.'. $request->frontImage->extension();

        $temp = $request->frontImage->storeAs('emp_photos',$name,'public');

        $nameToStore = URL::asset('storage/emp_photos/'.$name);



        $emp = Employee::create([
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'salary' => $request->salary,
            'image' => $nameToStore
        ]);

        return response()->json([
            'status' => true,
            'message' => 'done',
            'data' => $emp
        ],201);


    }
    public function read()
    {

        $employee = DB::table('employees')->select('id','name','salary','image','birth_date')->get();

        return response()->json([
            'status' => true,
            'message' => 'done',
            'data' => $employee
        ]);


    }
    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:employees,id',
            'name' => 'string',
            'birth_date' => 'date',
            'frontImage' => 'file|mimes:png,jpg,jpeg'
        ]);

        if($request->frontImage != null){

            $name = time().'_'.uniqid().'.'. $request->frontImage->extension();

            $temp = $request->frontImage->storeAs('emp_photos',$name,'public');

            $nameToStore = URL::asset('storage/emp_photos/'.$name);

            DB::table('employees')->where('id',$request->id)->update([
                'image' => $nameToStore
            ]);


        }

        $emp = Employee::findOrFail($request->id);
        $emp->update($request->only('name','birth_date'));

        return response()->json([
            'status' => true,
            'message' => 'done'
        ]);



    }
    public function delete($id)
    {

        $emp = Employee::findOrFail($id);

        $emp->delete();

        return response()->json([
            'status' => true,
            'message' => 'done'
        ]);


    }
    public function search()
    {

        $name = request()->query('name');

        $data = DB::table('employees')->where('name','like',"%{$name}%")->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);


    }
}
