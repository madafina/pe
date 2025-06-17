<?php
namespace App\Http\Controllers;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::latest()->get();
        return view('expense_categories.index', compact('categories'));
    }

    public function create() { return view('expense_categories.create'); }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        ExpenseCategory::create($request->all());
        return redirect()->route('expense-categories.index')->with('success', 'Kategori baru berhasil dibuat.');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('expense_categories.edit', compact('expenseCategory'));
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $expenseCategory->update($request->all());
        return redirect()->route('expense-categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }
}