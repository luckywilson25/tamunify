<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query();

            if ($request->has('department') && $request->input('department') != 'All' && $request->input('department') != NULL) {
                $department = $request->input('department');
                $users->where('department', $department);
            }
            if ($request->has('status') && $request->input('status') != 'All' && $request->input('status') != NULL) {
                $status = $request->input('status');
                $users->where('status', $status);
            }


            return DataTables::of($users)->make();
        }

        return view('dashboard.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            'department' => 'required',
            'status' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = new User([
            'name' => $request->name,
            'department' => $request->department,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);
        $user->assignRole('Admin');
        $user->save();

        return redirect('/dashboard/admin')->with('success', 'Admin Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {
        return view('dashboard.admin.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin)
    {
        $rules = [
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'name' => 'required|string',
            'department' => 'required',
            'status' => 'required',
        ];
        if ($request->filled('password')) {
            $rules['password'] = 'required|confirmed';
        }

        $validatedData = $request->validate($rules);

        $updateData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'department' => $validatedData['department'],
            'status' => $validatedData['status'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($validatedData['password']);
        }

        $admin->update($updateData);

        return redirect('/dashboard/admin')->with('success', 'Admin Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        if (User::count() == 1) {
            return redirect('/dashboard/admin')->with('error', 'Tidak dapat menghapus admin terakhir!');
        }
        $admin->delete();

        return redirect('/dashboard/admin')->with('success', 'Admin Berhasil Dihapus!');
    }
}