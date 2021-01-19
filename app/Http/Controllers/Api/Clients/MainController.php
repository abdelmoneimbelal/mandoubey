<?php

namespace App\Http\Controllers\Api\Clients;

use App\ConnectUs;
use App\Delegate;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Order;
use Auth;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Validator;

//use Illuminate\Support\Str;

class MainController extends Controller
{


    public function addOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lat2' => 'required',
            'long' => 'required',
            'long2' => 'required',
            'address' => 'required',
            'address2' => 'required',
            'delivery_method_id' => 'required',
            'name' => 'required',
            'title' => 'required',
            'payment_method' => 'required',
            'type' => 'required',
            'count' => 'required',
            'price' => 'required',
            'shipping_price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
            'weight' => 'required',
            'phone' => 'required',
            'section_id' => 'required',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), null);
        } else {
            $request_data = $request->except(['image']);

            if ($request->hasFile('image')) {
//            $filename = date('Y-m-d-H:i:s')."-".$request->file('image')->getClientOriginalName();
                Image::make($request->file('image'))
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('/uploads/orders/' . $request->file('image')->hashName()));

                $request_data['image'] = '/uploads/orders/' . $request->file('image')->hashName();

            }//end of if

            $order = Order::create($request_data);
            $order->client_id = auth()->user()->id;
            $order->delivery_number = rand(111111, 999999);
            $order->save();

            $delegates = Delegate::where('type', $request->type)->where('delivery_method_id', $request->delivery_method_id)->get();

            Notification::create([
                'title' => 'طلب جديد',
                'content' => 'لديك طلب جديد من العميل ' . $request->user()->name,
                'order_id' => $order->id,
                'client_id' => auth()->user()->id,
            ]);

            If ($delegates) {
                foreach ($delegates as $delegate) {
                    $tokens = $delegate->tokens()->where('token', '!=', null)->where('delegate_id', '=', $delegate->id)->get();
                    if (count($tokens)) {
                        public_path();
                        $title = 'لديك طلب جديد من العميل ' . $request->user()->name;
                        $body = [
                            'title' => 'لديك طلب جديد من العميل ' . $request->user()->name,
                            'delivery_number' => $request->delivery_number,
                            'shipping_price' => $request->shipping_price,
                            'price' => $request->price,
                        ];
                        $data = [
                            'title' => $title,
                            'body' => $body,
                        ];
                        $send = notifyByFirebase($body, $title, $tokens, $data);
                        info('firebse Result:' . $send);
                    }
                }
            }
        }
        return responseJson(1, 'تم ارسال الطلب بنجاح', $order);
    }

    public function myOrder(Request $request)
    {
        $client = Auth::guard('client')->user();
        $orders = $client->orders()->latest()->paginate(10);

        return responseJson(1, 'success', $orders);
    }

    public function currentOrder(Request $request)
    {
        $orders = $request->user()->orders()->where(function ($order) use ($request) {
            if ($request->has('status') && $request->status == 'current') {
                $order->where('status', '!=', 'former');
            }

        })->latest()->paginate(10);
        return responseJson(1, 'تم التحميل', $orders);
    }

    public function connectUs(Request $request, ConnectUs $connectUs)
    {
        $validation = validator()->make($request->all(), [
            'type' => 'required|in:problems,suggestions,balance,others',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
        ]);

        if ($validation->fails()) {

            return responseJson(0, $validation->errors()->first());
        }

        $connectus = ConnectUs::create($request->all());
        $connectus->client_id = auth('client')->user()->id;

        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/connectus/'; // upload path
            $photo = $request->file('image');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $connectus->update(['image' => '/uploads/connectus/' . $name]);
            $connectus['image'] = '/uploads/connectus/' . $name;
        }


        return responseJson(1, 'تم الارسال بنجاح', $connectus);
    }

    public function notifications(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate(20);
        return responseJson(1, 'تم التحميل', $notifications);
    }
}



