<?php
namespace App\Http\Controllers;
use App\DataTables\ExpenseDataTable;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest; // <-- Tambah ini
use Illuminate\Support\Facades\Storage;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(ExpenseDataTable $dataTable)
    {
        return $dataTable->render('expenses.index');
    }

    public function create()
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('expenses.create', compact('categories'));
    }

    public function store(StoreExpenseRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        if ($request->hasFile('proof_of_expense')) {
            $validated['proof_of_expense'] = $request->file('proof_of_expense')->store('expense_proofs', 'public');
        }

        Expense::create($validated);
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function edit(Expense $expense) // <-- Tambah ini
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $validated = $request->validated();

        if ($request->hasFile('proof_of_expense')) {
            // Hapus file lama jika ada
            if ($expense->proof_of_expense) {
                Storage::disk('public')->delete($expense->proof_of_expense);
            }
            $validated['proof_of_expense'] = $request->file('proof_of_expense')->store('expense_proofs', 'public');
        }

        $expense->update($validated);
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diperbarui.');
    }
}