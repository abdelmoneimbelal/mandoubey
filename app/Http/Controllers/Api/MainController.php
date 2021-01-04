<?php

namespace App\Http\Controllers\api;

use App\City;
use App\DeliveryMethod;
use App\Governorate;
use App\Http\Controllers\Controller;
use App\Message;
use App\Section;
use Illuminate\Http\Request;


class MainController extends Controller
{

    public function governrates()
    {
        $governrates = Governorate::all();

        return responseJson(1, 'success', $governrates);
    }

    public function deliveryMethod()
    {
        $deliveryMethod = DeliveryMethod::all();

        return responseJson(1, 'success', $deliveryMethod);
    }


    public function sections()
    {
        $section = Section::all();

        return responseJson(1, 'success', $section);
    }


    public function cities(Request $request)
    {
        $cities = City::where(function ($query) use ($request) {
            if ($request->has('governorate_id')) {
                $query->where('governorate_id', $request->governorate_id);
            }
        })->get();

        return responseJson(1, 'success', $cities);
    }

    public function messages()
    {
        $message = Message::paginate(20);

        return responseJson(1, 'success', $message);
    }

}



