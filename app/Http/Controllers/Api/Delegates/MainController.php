<?php

namespace App\Http\Controllers\api\Delegates;

use App\Client;
use App\ConnectUs;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Validator;


class MainController extends Controller
{
    public function myOrders(Request $request)
    {
        $orders = $request->user()->orders()->where(function ($order) use ($request) {
            if ($request->has('acceptable') && $request->status == 'accepted') {
                $order->where('status', '!=', 'pending');
            }

        })->latest()->paginate(10);
        return responseJson(1, 'تم التحميل', $orders);
    }

    public function acceptOrder(Request $request)
    {
        $orders = Order::where('id', $request->id)->first();

        if (!$orders) {
            return responseJson(0, 'لا يمكن الحصول على بيانات الطلب');
        }
        if ($orders->acceptable == 'accepted') {
            return responseJson(0, ' لا يمكن تأكيد الطلب مره اخرى تم تاكيد الطلب من مندوب اخر');
        } else {
            $orders->update([
                'acceptable' => 'accepted',
                'delegate_id' => auth('delegate')->user()->id,
            ]);

            $client = Client::where('id', $orders->client_id)->first();
            $client->notifications()->create([
                'title' => 'تم قبول طلبك',
                'content' => 'تم قبول الطلب من المندوب ' . $request->user()->name,
                'order_id' => $request->id,
                'delegate_id' => auth('delegate')->user()->id,
            ]);
//
            $tokens = $client->tokens()->where('token', '!=', null)->pluck('token')->toArray();
            if (count($tokens)) {
                public_path();
                $title = 'تم قبول الطلب من المندوب ' . $request->user()->name;
                $body = 'تم قبول الطلب من المندوب ' . $request->user()->name;
                $data = [
                    'title' => $title,
                    'body' => $body,
                ];
                $send = notifyByFirebase($body, $title, $tokens, $data);
                info('firebse Result:' . $send);
            }

            return responseJson(1, 'تم قبول الطلب');
        }
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
        $connectus->delegate_id = auth('delegate')->user()->id;

        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/connectus/'; // upload path
            $photo = $request->file('image');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $connectus->update(['image' => 'public/uploads/connectus/' . $name]);
            $connectus['image'] = 'public/uploads/connectus/' . $name;
        }

        return responseJson(1, 'تم الارسال بنجاح', $connectus);
    }

}



