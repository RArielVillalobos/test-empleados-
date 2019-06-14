<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $admin=auth()->user()->has_role(1);
        return view('pages.report.index',['admin'=>$admin]);
    }

    public function reportesJson(Request $request){




        //todos los reportes
        if(auth()->user()->has_role(1)){

            $reports=Report::with('employee.user')->orderBy('id','desc')->paginate(3);
        }else{
            //reportes empleado
            $reports=auth()->user()->employee->reports()->orderBy('id','desc')->paginate(3);
        }


        return ['pagination'=>['total'=>$reports->total(),
            'current_page'=>$reports->currentPage(),
            'per_page'=>$reports->perPage(),
            'last_page'=>$reports->lastPage(),
            'from'=>$reports->firstItem(),
            'to'=>$reports->lastItem()],
            'reports'=>$reports];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if(!$request->ajax()){
            abort(403);

        }
        $this->authorize('create',Report::class);
        $request->merge(['employee_id'=>auth()->user()->employee->id]);

        Report::create($request->input());

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        if(!$request->ajax()){
            abort(403);

        }

        $report=Report::find($request->id);
        $this->authorize('update',$report);
        $report->description=$request->description;
        $report->date=$request->date;
        $report->save();





    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if(!$request->ajax()){
            abort(403);
        }
        $report=Report::find($request->id);
        $this->authorize('delete',$report);
        $report->delete();
    }
}
