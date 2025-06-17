@extends('adminlte::page')
@section('title', 'Edit Pengeluaran')
@section('content_header')
    <h1>Edit Data Pengeluaran</h1>
@stop
@section('content')
    <div class="card card-primary">
        <form action="{{ route('expenses.update', $expense->id) }}" method="POST"  enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Kategori Pengeluaran</label>
                    <select name="expense_category_id" class="form-control" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('expense_category_id', $expense->expense_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" name="description" class="form-control"
                        value="{{ old('description', $expense->description) }}" required>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="amount" class="form-control" value="{{ old('amount', $expense->amount) }}"
                        required>
                </div>
                <div class="form-group">
                    <label>Tanggal Pengeluaran</label>
                    <input type="date" name="expense_date" class="form-control"
                        value="{{ old('expense_date', $expense->expense_date) }}" required>
                </div>
                <div class="form-group">
                    <label for="proof_of_expense">Unggah Bukti Nota Baru (Opsional)</label>
                    @if ($expense->proof_of_expense)
                        <p>Bukti saat ini: <a href="{{ asset('storage/' . $expense->proof_of_expense) }}"
                                target="_blank">Lihat Nota</a></p>
                    @endif
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="proof_of_expense" name="proof_of_expense">
                        <label class="custom-file-label" for="proof_of_expense">Pilih file baru...</label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop

@section('js')
 <script>
        // Script untuk menampilkan nama file di input custom file
        $('.custom-file-input').on('change', function(event) {
            var inputFile = event.currentTarget;
            $(inputFile).parent()
                .find('.custom-file-label')
                .html(inputFile.files[0].name);
        });
    </script>
@stop
