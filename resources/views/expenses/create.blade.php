@extends('adminlte::page')
@section('title', 'Form Pengeluaran')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group"><label>Kategori Pengeluaran</label>
                    <select name="expense_category_id" class="form-control" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group"><label>Deskripsi</label><input type="text" name="description" class="form-control"
                        required></div>
                <div class="form-group"><label>Jumlah</label><input type="number" name="amount" class="form-control"
                        required></div>
                <div class="form-group"><label>Tanggal Pengeluaran</label><input type="date" name="expense_date"
                        class="form-control" value="{{ date('Y-m-d') }}" required></div>
                <div class="form-group">
                    <label for="proof_of_expense">Unggah Bukti Nota (Opsional)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="proof_of_expense" name="proof_of_expense">
                        <label class="custom-file-label" for="proof_of_expense">Pilih file...</label>
                    </div>
                </div>
            </div>
            <div class="card-footer"><button type="submit" class="btn btn-primary">Simpan</button></div>
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