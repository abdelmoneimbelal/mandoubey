<?php

namespace App\Http\Controllers;

use App\ConnectUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConnectUsController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:تواصل معنا', ['only' => ['index']]);
        $this->middleware('permission:عرض الرساله', ['only' => ['show']]);
        $this->middleware('permission:حذف الرساله', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $connects = ConnectUs::all();
        return view('connects.index', compact('connects'));
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
        $connects = ConnectUs::find($id);
        return view('connects.show', compact('connects'));
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
        $connects = ConnectUs::findOrFail($request->id);
        if ($connects->image != '') {
            Storage::disk('public_uploads')->delete('/connectus/' . $connects->image);
        }//end of inner if

        $connects->delete();
        session()->flash('delete', 'تم حذف  بنجاح');
        return redirect('/connect-us');
    }

}