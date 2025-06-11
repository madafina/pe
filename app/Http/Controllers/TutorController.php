<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\TutorDataTable;
use App\Http\Requests\StoreTutorRequest;
use App\Models\Tutor;
use App\Http\Requests\UpdateTutorRequest;

class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TutorDataTable $dataTable)
    {
        return $dataTable->render('tutors.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tutors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTutorRequest $request)
    {
        Tutor::create($request->validated());

        return redirect()->route('tutors.index')->with('success', 'Tutor baru berhasil ditambahkan!');
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
    public function edit(Tutor $tutor)
    {
        return view('tutors.edit', compact('tutor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTutorRequest $request, Tutor $tutor)
    {
        $tutor->update($request->validated());
        return redirect()->route('tutors.index')->with('success', 'Data tutor berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tutor $tutor)
    {
        try {
            $tutor->delete();
            return response()->json(['success' => true, 'message' => 'Data tutor berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data.'], 500);
        }
    }
}
