<?php

namespace App\Http\Controllers;

use App\Models\User;
use DataTables;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            return Datatables::of($data)
            ->addColumn('full_name', function($row){ return $row->first_name.' '.$row->second_name.' '.$row->third_name.' '.$row->last_name; })
            ->addIndexColumn()
            ->make(true);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Here Is Simple
        // So I Used In The Same Controller
        // Alternative :- Using FormRequest File
        $validator = Validator::make($request->all(), ['first_name' => 'required', 'last_name' => 'required', 'grades' => 'required|numeric' , 'seating_numbers' => 'required|numeric']);

        // Message If Failed
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with(['message' => 'Revise Errors Please', 'alert' => 'alert-danger']);
        }

        // Create Fake Email And Password
        $request->merge(['password' => bcrypt($request->password) , 'email' => Str::random(20).'@domain.com']);

        // Save User
        User::create($request->all());


        return redirect()->back()->withMessage('Student Created SuccessFully');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import()
    {
        if(request()->file('file') == null){
            return back()->withMessage('please upload a file first');
        }

        Excel::import(new UsersImport,request()->file('file'));

        return back();
    }

}
