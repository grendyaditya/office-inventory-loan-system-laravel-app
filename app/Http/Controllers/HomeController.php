<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\PermohonanPinjaman;
use App\Models\PengembalianBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
   public function index(){
    $userId = Auth::id();

    // Menghitung total barang
    $totalBarang = Barang::count();

    // Menghitung riwayat peminjaman saya
    $riwayatPeminjamanSaya = PermohonanPinjaman::where('user_id', $userId)->count();

    // Menghitung riwayat peminjaman semua
    $riwayatPeminjamanSemua = PermohonanPinjaman::count();



    return view('page.dashboard', [
        'totalBarang' => $totalBarang,
        'riwayatPeminjamanSaya' => $riwayatPeminjamanSaya,
        'riwayatPeminjamanSemua' => $riwayatPeminjamanSemua,
    ]);

   }

   public function getNotifications()
{
    // Menghitung jumlah permohonan baru
    $newRequests = PermohonanPinjaman::where('status_pengembalian', 0)->count();

    return [
        'newRequests' => $newRequests,
    ];
}

   
 

   public function register(){
      
      return view ('layoutsauth.register');
     }

     public function doregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'name.required' => 'Nama harus di isi',
            'email.required' => 'Email harus di isi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus di isi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

       // Redirect to a success page or wherever you need after registration
        return redirect()->route('register')->with('success', 'Registrasi berhasil!');
    }

     
       
    public function testcon(Request $request){
      
        try {
            $dbConnect = DB::connection()->getPDO();
            if ($dbConnect) {
                echo "Koneksi ke database berhasil.";
                Log::info("Koneksi ke database berhasil.");
            } else {
                echo "Gagal menghubungkan ke database.";
                Log::error("Gagal menghubungkan ke database.");
            }
        } catch (\Exception $e) {
            echo "Terjadi kesalahan: " . $e->getMessage();
            Log::error("Terjadi kesalahan saat menghubungkan ke database: " . $e->getMessage());
        }
       } 
       public function login(){
      
        return view ('layoutsauth.login');
       }
  
       public function dologin(Request $request)
      {
          $validator = Validator::make($request->all(), [
             
              'email' => 'required|email',
              'password' => 'required',
          ], [
              
              'email.required' => 'Email harus di isi',
              'email.email' => 'Format email tidak valid',
              'password.required' => 'Password harus di isi'
          ]);
          $credentials = $request->only('email','password');
          if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/home');
        }
 
  
          if ($validator->fails()) {
              return redirect()->back()->withErrors($validator)->withInput();
          }
  
          return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
        
      }
      public function logout(Request $request){
        Auth::logout();
        return redirect ('/login');
       }
  
}


