<?php

namespace App\Http\Controllers;

use App\City;
use App\Governorate;
use Illuminate\Http\Request;

class CityController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cities = City::all();
        $governrates = Governorate::all();
        return view('cities.index', compact('cities', 'governrates'));
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
            'name' => 'required',
            'governorate_id' => 'required',
        ], [
            'governorate_id.required' => 'يرجي ادخال اسم المحافظه',
            'name.required' => 'يرجي ادخال المدينه',
        ]);

        City::create([
            'name' => $request->name,
            'governorate_id' => $request->governorate_id,
        ]);
        session()->flash('Add', 'تم الاضافه بنجاح ');
        return redirect('/cities');
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
        $id = Governorate::where('governorate_name', $request->governorate_name)->first()->id;

        $validatedData = $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'يرجي ادخال المدينه',
        ]);
        $cities = City::findOrFail($id);
        $cities->update([
            'name' => $request->name,
            'governorate_id' => $id,
        ]);
        session()->flash('edit', 'تم التحديث بنجاح ');
        return redirect('/cities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $cities = City::findOrFail($request->id);
        $cities->delete();
        session()->flash('delete', 'تم حذف بنجاح');
        return back();
    }

}

?>