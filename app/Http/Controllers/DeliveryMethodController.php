<?php

namespace App\Http\Controllers;

use App\DeliveryMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DeliveryMethodController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:طرق التوصيل', ['only' => ['index']]);
        $this->middleware('permission:اضافة طريقة توصيل', ['only' => ['store']]);
        $this->middleware('permission:تعديل طريقة توصيل', ['only' => ['update']]);
        $this->middleware('permission:حذف طريقة توصيل', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $deliveryMethods = DeliveryMethod::all();
        return view('delivery-method.index', compact('deliveryMethods'));
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
        $request->validate([
            'name' => 'required|unique:delivery_methods',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
        ], [
            'image.required' => 'يرجي اضافة صوره',
            'image.image' => 'يجب ان يكون المرفق صوره',
            'image.mimes' => 'يجب ان تكون صيغة الصوره jpeg,png,jpg,gif,bmp,svg',
            'name.required' => 'يرجي ادخال الاسم',
            'name.unique' => 'الاسم موجود بالفعل',
        ]);
        $request_data = $request->except(['image']);

        if ($request->hasFile('image')) {
//            $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
            Image::make($request->file('image'))
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('/uploads/delivery_methods/' . $request->file('image')->hashName()));

            $request_data['image'] = $request->file('image')->hashName();

        }//end of if
//        dd($request_data);
        DeliveryMethod::create($request_data);

        session()->flash('Add', 'تم الاضافه بنجاح ');
        return redirect('/delivery-method');
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
//        $id = $request->id;
        $deliveryMethods = DeliveryMethod::find($request->id);

        $request->validate([
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
        ], [
            'image.image' => 'يجب ان يكون المرفق صوره',
            'image.mimes' => 'يجب ان تكون صيغة الصوره jpeg,png,jpg,gif,bmp,svg',
            'name.required' => 'يرجي ادخال الاسم',
        ]);
        $request_data = $request->except(['image']);

        if ($request->hasFile('image')) {
//            $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
            if ($deliveryMethods->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/delivery_methods/' . $deliveryMethods->image);
            }//end of inner if

            Image::make($request->file('image'))
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('/uploads/delivery_methods/' . $request->file('image')->hashName()));

            $request_data['image'] = $request->file('image')->hashName();

        }//end of if
//        dd($request_data);
        $deliveryMethods->update($request_data);
        session()->flash('edit', 'تم التعديل  بنجاج');
        return redirect('/delivery-method');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $deliveryMethods = DeliveryMethod::findOrFail($request->id);
        if ($request->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/delivery_methods/' . $deliveryMethods->image);
        }//end of inner if

        $deliveryMethods->delete();
        session()->flash('delete', 'تم حذف القسم بنجاح');
        return redirect('/delivery-method');
    }

}