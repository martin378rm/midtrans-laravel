<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;



class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }
    //
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        $credentials = request(['email', 'password']);

        if (auth()->attempt($credentials)) {
            $token = Auth::guard('api')->attempt($credentials);
            // dd($token);
            // cookie()->queue(cookie('token', $token, 60));
            return response()
                ->json([
                    'success' => true,
                    'message' => 'login sukses',
                    'token' => $token
                ])
                // ->withCookie(cookie('token', $token, 60 * 24 * 7, null, null, false, true))
            ;
        }

        return response()->json([
            'success' => false,
            'message' => 'email atau password salah'
        ]);
        // return redirect()->back()->with('message', 'Email atau Password salah');
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        // validasi

        $validator = Validator::make($request->all(), [
            "nama_member" => "required",
            "provinsi" => "required",
            "kabupaten" => "required",
            "kecamatan" => "required",
            "detail_alamat" => "required",
            "no_hp" => "required",
            "email" => "required|email",
            "password" => "required|same:konfirmasi_password|min:8",
            "konfirmasi_password" => "required|same:password"

        ]);

        if ($validator->fails()) {

            return response()->json([
                "message" => $validator->messages()
            ], 422);

        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);

        $members = Member::create($input);

        return response()->json([
            "data" => $members
        ]);
    }

    public function login_member()
    {
        return view('auth.login_member');
    }

    public function login_member_action(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required|min:8"

        ]);

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors()->toArray());
            return redirect('/login_member');
        }

        $credentials = $request->only('email', 'password');


        $member = Member::where('email', $request->email)->first();
        $test = Auth::guard('webmember')->attempt($credentials);
        if ($member) {
            if ($test) {
                $request->session()->regenerate();
                return redirect('/');
            } else {
                return response()->json([
                    'message' => 'failed',
                    'data' => 'password wrong'
                ]);
            }

        } else {
            return response()->json([
                'message' => 'failed',
                'data' => 'Email wrong'
            ]);
        }
    }

    public function register_member()
    {
        return view('auth.register_member');

    }

    public function register_member_action(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama_member" => "required",
            "no_hp" => "required",
            "email" => "required",
            "password" => "required|same:konfirmasi_password",
            "konfirmasi_password" => "required|same:password"

        ]);

        if ($validator->fails()) {
            Session::flash('message', $validator->errors()->toArray());
            return redirect('/register_member');
        }

        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        Member::create($input);
        return redirect('/login_member');

    }

    public function logout(Request $request)
    {
        // Auth::guard('api')->logout();

        // return response()->json(['message' => 'Logged out successfully']);
        Session::flush();

        // Auth::logout();

        // $request->session()->invalidate();

        // $request->session()->regenerate();

        return redirect('/login');
    }

    public function logout_member()
    {
        Auth::guard('webmember')->logout();
        return redirect('/');
    }

}