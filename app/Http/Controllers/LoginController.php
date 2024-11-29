<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        $login = Session::get('is_login');

        if (isset($login)) {
            return redirect()->intended('dash');
        } else {
            return view('login.index');
        }
    }

    public function authenticate(Request $request)
    {
        $env = env('PAYMENT_MODE_GAK');

        if($env == 'sandbox'){
            $url = env('API_GATEWAY_SANDBOX_GAK');
        }else{
            $url = env('API_GATEWAY_GAK');
        }

        // Mengirim permintaan POST ke API login
        $response = Http::post($url . 'login', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        // Mendapatkan respons JSON dari API
        $data = $response->json();

        // Memeriksa jika ada kesalahan dalam respons API
        if ($response->successful() && !$data['Error']) {
            $userData = $data['Data'];

            // Sesuaikan sesi sesuai dengan respons API
            Session::put('name', $userData['name']);
            Session::put('email', $userData['email']);
            Session::put('userID', $userData['UserId']);
            Session::put('company_cd', $userData['Company_Cd']);
            Session::put('company_name', $userData['Company_Name']);
            Session::put('pict', $userData['pict']);
            Session::put('hp', $userData['handphone']);
            Session::put('rowID', $userData['rowID']);
            Session::put('UserLevel', $userData['UserLevel']);
            Session::put('is_login', true);

            // Regenerasi sesi
            $request->session()->regenerate();

            

            // Redirect ke dashboard
            return redirect()->intended('dash');
        } else {
            // Menampilkan pesan kesalahan
            return redirect('/')->with('alert', $data['Pesan']);
        }
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/')->with('alert', 'Already logout!');
    }

}
