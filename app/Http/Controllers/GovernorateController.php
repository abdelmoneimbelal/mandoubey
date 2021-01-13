<?php

namespace App\Http\Controllers;

use App\Governorate;
use Illuminate\Http\Request;


class GovernorateController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $governrates = Governorate::all();
        return view('governrates.index', compact('governrates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'governorate_name' => 'required|unique:governorates|max:255',
            'price' => 'required',
        ], [
            'governorate_name.required' => 'يرجي ادخال اسم المحافظه',
            'governorate_name.unique' => 'اسم المحافظه مسجل مسبقا',
            'price.required' => 'يرجي ادخال السعر',
        ]);

        Governorate::create([
            'governorate_name' => $request->governorate_name,
            'price' => $request->price,
        ]);
        session()->flash('Add', 'تم الاضافه بنجاح ');
        return redirect('/governorates');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [

            'governorate_name' => 'required|',
            'price' => 'required',
        ], [
            'governorate_name.required' => 'يرجي ادخال اسم المحافظه',
            'price.required' => 'يرجي ادخال السعر',
        ]);

        $governrates = Governorate::find($id);
        $governrates->update([
            'governorate_name' => $request->governorate_name,
            'price' => $request->price,
        ]);

        session()->flash('edit', 'تم التعديل  بنجاج');
        return redirect('/governorates');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Governorate::find($id)->delete();
        session()->flash('delete', 'تم حذف بنجاح');
        return redirect('/governorates');
    }

}

?>