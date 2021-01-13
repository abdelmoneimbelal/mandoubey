<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;


class SectionController extends Controller
{

//    function __construct()
//    {
//        $this->middleware('permission:الاقسام', ['only' => ['index']]);
//        $this->middleware('permission:اضافة قسم', ['only' => ['create', 'store']]);
//        $this->middleware('permission:تعديل قسم', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        return view('sections.index', compact('sections'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|unique:sections|max:255',
        ], [

            'name.required' => 'يرجي ادخال اسم القسم',
            'name.unique' => 'اسم القسم مسجل مسبقا',


        ]);

        Section::create([
            'name' => $request->name,
        ]);
        session()->flash('Add', 'تم اضافة القسم بنجاح ');
        return redirect('/sections');

    }


    /**
     * Display the specified resource.
     *
     * @param \App\sections $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\sections $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\sections $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [
            'name' => 'required|max:255|unique:sections,name,' . $id,
        ], [

            'name.required' => 'يرجي ادخال اسم القسم',
            'name.unique' => 'اسم القسم مسجل مسبقا',
//            'description.required' =>'يرجي ادخال البيان',

        ]);

        $sections = Section::find($id);
        $sections->update([
            'name' => $request->name,
        ]);

        session()->flash('edit', 'تم تعديل القسم بنجاج');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\sections $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Section::find($id)->delete();
        session()->flash('delete', 'تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
