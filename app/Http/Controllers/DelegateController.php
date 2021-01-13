<?php

namespace App\Http\Controllers;

use App\Delegate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DelegateController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $delegates = Delegate::all();
        return view('delegates.index', compact('delegates'));
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

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $delegates = Delegate::find($id);
        $orders = $delegates->orders()->get();
        return view('delegates.show', compact('delegates', 'orders'));
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
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */

    public function destroy(Request $request)
    {
        $delegates = Delegate::findOrFail($request->id);
        if ($request->photo !== 'default.png') {
            Storage::disk('public_uploads')->delete('/delegates/' . $delegates->photo);
        }//end of inner if
        if ($request->id_front !== '') {
            Storage::disk('public_uploads')->delete('/delegates/' . $delegates->id_front);
        }//end of inner if
        if ($request->id_back !== '') {
            Storage::disk('public_uploads')->delete('/delegates/' . $delegates->id_back);
        }//end of inner if

        $delegates->delete();
        session()->flash('delete', 'تم حذف بنجاح');
        return redirect('/delegates');
    }

    public function statusUpdate($id, Request $request)
    {
        $delegates = Delegate::findOrFail($id);

        $delegates->update([
            'status' => $request->status,
        ]);

        session()->flash('edit', 'تم التعديل  بنجاج');
        return redirect('/delegates');

    }

}