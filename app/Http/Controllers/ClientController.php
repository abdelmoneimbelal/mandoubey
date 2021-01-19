<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:المستخدمين', ['only' => ['index']]);
        $this->middleware('permission:عرض مستخدم', ['only' => ['show']]);
        $this->middleware('permission:حذف مستخدم', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
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
        $clients = Client::find($id);
        $orders = $clients->orders()->get();
        return view('clients.show', compact('clients', 'orders'));
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
        $clients = Client::findOrFail($request->id);
        if ($request->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/clients/' . $clients->image);
        }//end of inner if

        $clients->delete();
        session()->flash('delete', 'تم حذف بنجاح');
        return redirect('/clients');
    }


    public function statusUpdate($id, Request $request)
    {
        $clients = Client::findOrFail($id);

        $clients->update([
            'status' => $request->status,
        ]);

        session()->flash('edit', 'تم التعديل  بنجاج');
        return redirect('/clients');

    }

}