<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{
    public function index()
{
    $people = Person::all();
    return view('people.index', compact('people')); // Path 'people.index' harus sesuai lokasi file.
}


    public function create()
    {
        return view('people.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'alamat' => 'required',
        'jenis_kelamin' => 'required',
        'no_telepon' => 'required',
        'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar
    ]);

    // Upload file
    $photoPath = $request->file('photo')->store('photos', 'public');

    Person::create([
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'jenis_kelamin' => $request->jenis_kelamin,
        'no_telepon' => $request->no_telepon,
        'photo' => $photoPath, // Simpan path file ke database
    ]);

    return redirect()->route('people.index')->with('success', 'Data berhasil ditambahkan');
}


public function edit($id)
{
    $person = Person::findOrFail($id); // Ambil data berdasarkan ID
    return view('people.edit', compact('person')); // Kirim data ke view
}


public function update(Request $request, $id)
{
    $person = Person::findOrFail($id);

    if ($request->hasFile('photo')) {
        // Hapus foto lama jika ada
        if ($person->photo && Storage::exists('public/' . $person->photo)) {
            Storage::delete('public/' . $person->photo);
        }

        // Simpan foto baru
        $photoPath = $request->file('photo')->store('photos', 'public');
        $person->photo = $photoPath;
    }

    $person->save();

    return redirect()->route('people.index')->with('success', 'Data berhasil diperbarui');
}


    public function destroy(Person $person)
    {
        if ($person->photo) {
            Storage::delete($person->photo);
        }
        $person->delete();
        return redirect()->route('people.index')->with('success', 'Data berhasil dihapus');
    }
}