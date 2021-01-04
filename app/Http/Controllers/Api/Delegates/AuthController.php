<?php

namespace App\Http\Controllers\Api\Delegates;

use App\Delegate;
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
            'governorate_id' => 'required',
            'whatsapp' => 'required',
            'phone' => 'required|unique:delegates',
            'password' => 'required|confirmed',
            'email' => 'required|unique:delegates',
            'type' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
            'id_front' => 'required|image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
            'id_back' => 'required|image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
            'payment_method' => 'required',
            'shipping_method' => 'required',
            'delivery_method_id' => 'required',
            'terms' => 'required',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), null, 20);
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
                    ->save(public_path('/uploads/delegates/' . $request->file('photo')->hashName()));

                $request_data['photo'] = 'public/uploads/delegates/' . $request->file('photo')->hashName();

            }//end of if
            if ($request->hasFile('id_front')) {
//            $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                Image::make($request->file('id_front'))
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('/uploads/delegates/' . $request->file('id_front')->hashName()));

                $request_data['id_front'] = 'public/uploads/delegates/' . $request->file('id_front')->hashName();

            }//end of if
            if ($request->hasFile('id_back')) {
//            $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                Image::make($request->file('id_back'))
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('/uploads/delegates/' . $request->file('id_back')->hashName()));

                $request_data['id_back'] = 'public/uploads/delegates/' . $request->file('id_back')->hashName();

            }//end of if

            $delegate = Delegate::create($request_data);
            $delegate->api_token = str::random(60);
            $delegate->save();

            return responseJson(1, 'تم الاضافة بنجاح', [
                'api_token' => $delegate->api_token,
                'delegate' => $delegate
            ]);

        } else {
            return responseJson(2, 'Check Pin Code');
        }
    }

    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'phone' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), null);
        }

        //$auth = auth()->guard('api')->validator($request->all());
        $delegate = Delegate::where('phone', $request->phone)->first();
        if ($delegate) {
            $api_token = str::random(60);
            $delegate->update(['api_token' => $api_token]);
            if (Hash::check($request->password, $delegate->password)) {
                return responseJson(1, 'تم نسجيل الدخول', [
                    'api_token' => $delegate->api_token,
                    'delegate' => $delegate
                ]);
            } else {
                return responseJson(0, 'بيانات الدخول غير صحيحة');
            }
        } else {
            return responseJson(0, 'بيانات الدخول غير صحيحة');
        }

    }

    public function profile(Request $request, Delegate $delegate)
    {
        $validation = validator()->make($request->all(), [
            'password' => 'confirmed',
            'email' => Rule::unique('delegates')->ignore($request->user()->id),
            'phone' => Rule::unique('delegates')->ignore($request->user()->id),
            'photo' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
        ]);

        if ($validation->fails()) {
            $data = null;
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $validation = validator()->make($request->all(), [
            'password' => 'confirmed',
            'email' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore($request->user()->id),
            'photo' => 'image|mimes:jpeg,png,jpg,gif,bmp,svg|max:2048',
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

                Storage::disk('public_uploads')->delete('/delegates/' . $delegate->photo);

            }//end of inner if
            $path = public_path();
            $destinationPath = $path . '/uploads/delegates/'; // upload path
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $loginUser->update(['photo' => 'uploads/delegates/' . $name]);
            $loginUser['photo'] = 'public/uploads/delegates/' . $name;
        }

        $loginUser->save();

        $data = [
            'delegate' => $request->user()->fresh()
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
        $delegate = Delegate::where('phone', $request->phone)->first();
        if ($delegate) {
            $code = rand(1111, 9999);
            $update = $delegate->update(['pin_code' => $code]);
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

        $delegate = Delegate::where('pin_code', $request->pin_code)->where('pin_code', '!=', 0)->first();
        if ($delegate) {
            $delegate->password = bcrypt($request->password);
            $delegate->pin_code = null;
            if ($delegate->save()) {
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
        $delegate = Auth::guard('delegate')->user();
        if ($delegate) {
            $delegate->api_token = null;
            $delegate->save();
        }

        return responseJson(1, 'success', 'تم تسجيل الخروج');
    }

}