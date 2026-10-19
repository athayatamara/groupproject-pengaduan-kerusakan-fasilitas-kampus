<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function validated(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => 'required|max:100',
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user?->id)],
            'role' => 'required|in:admin,mahasiswa,dosen_tendik',
            'identity_number' => ['nullable', 'max:30', Rule::unique('users', 'identity_number')->ignore($user?->id)],
            'phone' => 'nullable|max:20',
            'password' => $user ? 'nullable|min:8' : 'required|min:8',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'role.required' => 'Pilih peran pengguna.',
            'identity_number.unique' => 'NIM / NIP / NIDN sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));

        $users = User::query()
            ->when($q !== '', fn ($query) => $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            }))
            ->orderBy('role')->orderBy('name')
            ->paginate(10)->withQueryString();

        return view('admin.pengguna.index', compact('users', 'q'));
    }

    public function create()
    {
        return view('admin.pengguna.form', ['item' => new User(['role' => 'mahasiswa'])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('admin.pengguna.index')->with('sukses', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.pengguna.form', ['item' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validated($request, $user);

        if ($user->id === auth()->id() && $data['role'] !== 'admin') {
            return back()->withInput()->with('error', 'Anda tidak dapat mengubah peran akun Anda sendiri.');
        }

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // kosong = password tidak diubah
        }

        $user->update($data);

        return redirect()->route('admin.pengguna.index')->with('sukses', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        if ($user->reports()->exists()) {
            return back()->with('error', "Pengguna \"{$user->name}\" tidak dapat dihapus karena sudah memiliki {$user->reports()->count()} laporan.");
        }

        $user->delete();

        return redirect()->route('admin.pengguna.index')->with('sukses', 'Pengguna berhasil dihapus.');
    }
}
