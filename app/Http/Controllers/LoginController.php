<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Sale;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        $users = User::orderBy('updated_at', 'DESC')->get();
        return view('dashboard.admin.user.index', compact('users'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users,email',
            'name' => 'required',
            'role' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi!',
            'email.unique' => 'Email sudah terdaftar!',
            'name.required' => 'Nama harus diisi!',
            'role.required' => 'Role harus diisi!',
            'password.required' => 'Password harus diisi!',
        ]);

        $createUser = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($createUser) {
            return redirect()->route('user.index')->with('success', 'Berhasil Menambahkan Data Pengguna !');
        } else {
            return redirect()->back()->with('error', 'Gagal Menambahkan Data Pengguna !');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        return view('dashboard.admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'role' => 'required',
        ], [
            'email.required' => 'Email harus diisi!',
            'name.required' => 'Nama harus diisi!',
            'role.required' => 'Role harus diisi!',
        ]);

        if ($request->password) {
            $updateUser = User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $updateUser = User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);
        }

        if ($updateUser) {
            return redirect()->route('user.index')->with('success', 'Berhasil Mengubah Data Pengguna !');
        } else {
            return redirect()->back()->with('error', 'Gagal Mengubah Data Pengguna !');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sales = Sale::where('user_id', $id)->count();
        if ($sales) {
            return redirect()->back()->with('error', 'Akun sudah tertaut dengan pembelian!');
        } else {
            $delteUser = User::find($id)->delete();

            if ($delteUser) {
                return redirect()->back()->with('success', 'Data Berhasil Dihapus !');
            } else {
                return redirect()->back()->with('error', 'Data Gagal Dihapus !');
            }
        }
    }

    public function login()
    {
        return view('auth.login.index');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect('/dashboard');
            } elseif ($user->role == 'cashier') {
                return redirect('/dashboard');
            }
        } else {
            return redirect()->back()->with('error', "Login failed, please check your credentials and try again!");
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
