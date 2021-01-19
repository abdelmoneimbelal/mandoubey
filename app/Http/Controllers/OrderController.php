<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:الطلبات', ['only' => ['index']]);
        $this->middleware('permission:عرض الطلب', ['only' => ['show']]);
        $this->middleware('permission:حذف الطلب', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', compact('orders'));
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
        $orders = Order::find($id);
        return view('orders.show', compact('orders'));
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
        $orders = Order::findOrFail($request->id);
        if ($request->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/orders/' . $orders->image);
        }//end of inner if

        $orders->delete();
        session()->flash('delete', 'تم حذف بنجاح');
        return redirect('/orders');
    }

}