<?php

namespace App\Http\Controllers\Api\Clients;

use App\Client;
use App\Http\Controllers\Controller;
use App\Token;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:clients',
            'password' => 'required|confirmed',
            'email' => 'required|unique:clients',
            'terms' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
            'id_front' => 'required|image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
            'id_back' => 'required|image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
            'type' => 'required',
//            'status' => 'required', //1,0
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first());
        }
        if ($request->has('status') && $request->status != null && $request->status = 1) {
            $request->merge(['password' => bcrypt($request->password)]);
            $request_data = $request->except(['photo', 'id_front', 'id_back']);

            if ($request->hasFile('photo')) {
//            $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                Image::make($request->file('photo'))
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('/uploads/clients/' . $request->file('photo')->hashName()));

                $request_data['photo'] = '/uploads/clients/' . $request->file('photo')->hashName();

            }//end of if
            if ($request->hasFile('id_front')) {
//            $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                Image::make($request->file('id_front'))
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('/uploads/clients/' . $request->file('id_front')->hashName()));

                $request_data['id_front'] = '/uploads/clients/' . $request->file('id_front')->hashName();

            }//end of if
            if ($request->hasFile('id_back')) {
//            $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                Image::make($request->file('id_back'))
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('/uploads/clients/' . $request->file('id_back')->hashName()));

                $request_data['id_back'] = '/uploads/clients/' . $request->file('id_back')->hashName();

            }//end of if

            $client = Client::create($request_data);
            $client->api_token = str::random(60);
            $client->save();
            return responseJson(1, 'تم الاضافة بنجاح', [
                'api_token' => $client->api_token,
                'client' => $client]);
        } else {
            return responseJson(2, 'Check Pin Code');
        }

    }

    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'phone' => 'required',
            'password' => 'required',
//            'status' => 'active',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), null);
        }

        //$auth = auth()->guard('api')->validator($request->all());
        $client = client::where('phone', $request->phone)->first();

        if ($client) {
            if ($client->status !== 'active') {
                return responseJson(0, ' حسابك مغلق مؤقتا قم بالرجوع للاداره');
            }
            $api_token = str::random(60);
            $client->update(['api_token' => $api_token]);
            if (Hash::check($request->password, $client->password)) {
                return responseJson(1, 'تم نسجيل الدخول', [
                    'api_token' => $client->api_token,
                    'client' => $client
                ]);
            } else {
                return responseJson(0, 'بيانات الدخول غير صحيحة');
            }
        } else {
            return responseJson(0, 'بيانات الدخول غير صحيحة');
        }
    }

    public function profile(Request $request, Client $client)
    {
        $validation = validator()->make($request->all(), [
            'password' => 'confirmed',
            'email' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore($request->user()->id),
            'photo' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048' . $request->user()->id,
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $loginUser = $request->user();
        $loginUser->update($request->all());

        if ($request->has('password')) {
            $loginUser->password = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($request->file('photo') != 'default.png') {
                Storage::disk('public_uploads')->delete('/clients/' . $client->photo);
            }//end of inner if

            $path = public_path();
            $destinationPath = $path . '/uploads/clients/'; // upload path
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $loginUser->update(['photo' => 'uploads/clients/' . $name]);
            $loginUser['photo'] = '/uploads/clients/' . $name;
        }

        $loginUser->save();

        $data = [
            'client' => $request->user()->fresh()
        ];

        return responseJson(1, 'تم تحديث البيانات', $data);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            $data = null;
            return responseJson(0, $validator->errors()->first(), $data);
        }
        $clients = Client::where('phone', $request->phone)->first();
        if ($clients) {
            $code = rand(1111, 9999);
            $update = $clients->update(['pin_code' => $code]);
            if ($update) {
                // send sms
                //smsMisr($request->phone,"your reset code is : ".$code);

                return responseJson(1, 'برجاء فحص هاتفك',
                    [
                        'pin_code_for_test' => $code,
                    ]);
            } else {
                return responseJson(0, 'حاول مره اخري');
            }
        } else {
            return responseJson(0, 'حاول مره اخرى');
        }
    }

    public function password(Request $request)
    {
        $validator = validator::make($request->all(), [
            'pin_code' => 'required',
            'password' => 'required|confirmed'
        ]);
        if ($validator->fails()) {
            $data = null;
            return responseJson(0, $validator->errors()->first(), $data);
        }

        $user = Client::where('pin_code', $request->pin_code)->where('pin_code', '!=', 0)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->pin_code = null;
            if ($user->save()) {
                return responseJson(1, 'تم تغيير كلمه المرور بنجاح');
            } else {
                return responseJson(0, 'حدث خطا مره اخري');
            }
        } else {
            return responseJson(0, 'هذا الكود غير صالح');
        }
    }

    public function registerToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
            'type' => 'required|in:android,ios',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        Token::where('token', $request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responseJson(1, 'تم التسجيل بنجاح');
    }

    public function removeToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        Token::where('token', $request->token)->delete();
        return responseJson('token', 'تم الحذف بنجاح');
    }

    public function logOut(Request $request)
    {
        $client = Auth::guard('client')->user();
        if ($client) {
            $client->api_token = null;
            $client->save();
        }

        return responseJson(1, 'success', 'تم تسجيل الخروج');
    }
}
