@extends('adminlte::page')

@section('title', 'Pendaftaran Siswa Baru')

@section('content_header')
    <h1>Pendaftaran Siswa Baru</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Formulir Pendaftaran</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Data Siswa</h4>
                        <hr>
                        {{-- Nama Lengkap --}}
                        <div class="form-group">
                            <label for="full_name">Nama Lengkap</label>
                            <input type="text" name="full_name"
                                class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                                placeholder="Masukkan nama lengkap" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- ALUR BARU: PILIH TINGKAT PENDIDIKAN (STATIS) --}}
                        <div class="form-group">
                            <label for="education_level">Tingkat Pendidikan Siswa</label>
                            <select name="education_level" id="education_level" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Tingkat --</option>
                                <option value="Pra-Sekolah">Pra-Sekolah</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="Lulus/Umum">Lulus / Umum</option>
                            </select>
                        </div>

                        {{-- No. HP Orang Tua --}}
                        <div class="form-group">
                            <label for="parent_phone_number">No. HP Orang Tua</label>
                            <input type="text" name="parent_phone_number"
                                class="form-control @error('parent_phone_number') is-invalid @enderror"
                                id="parent_phone_number" placeholder="Contoh: 08123456789"
                                value="{{ old('parent_phone_number') }}" required>
                            @error('parent_phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Email--}}
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email" placeholder=""
                                value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea name="address" class="form-control" id="address" rows="3" placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                        </div>

                        {{-- Sekolah Asal --}}
                        <div class="form-group">
                            <label for="school_origin">Sekolah Asal</label>
                            <input type="text" name="school_origin" class="form-control" id="school_origin"
                                placeholder="Masukkan sekolah asal" value="{{ old('school_origin') }}">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <h4>Pilihan Program</h4>
                        <hr>
                        <div class="form-group">
                            <label for="registration_date">Tanggal Pendaftaran</label>
                            <input type="date" name="registration_date" id="registration_date" class="form-control"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="course_price_id">Pilih Paket Bimbel</label>
                            <select name="course_price_id" id="course_price_id"
                                class="form-control @error('course_price_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Tanggal Dulu --</option>
                            </select>
                            @error('course_price_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Daftarkan Siswa</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Fungsi untuk mengambil data paket
            async function fetchCoursePrices() {
                const educationLevel = $('#education_level').val();
                const selectedDate = $('#registration_date').val();
                const coursePriceSelect = $('#course_price_id');

                if (!educationLevel || !selectedDate) {
                    coursePriceSelect.html('<option value="" disabled selected>-- Pilih Tingkat & Tanggal Dulu --</option>');
                    return;
                }

                coursePriceSelect.prop('disabled', true).html('<option>Loading...</option>');

                try {
                    const url = `{{ route('api.course-prices') }}?date=${selectedDate}&level=${educationLevel}`;

                    const response = await fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });

                    const prices = await response.json();
                    coursePriceSelect.empty().append(
                        '<option value="" disabled selected>-- Pilih Paket --</option>');

                    if (prices.length > 0) {
                        prices.forEach(price => {
                            const priceFormatted = new Intl.NumberFormat('id-ID').format(price.price);
                            // Tampilkan nama program dan nama paketnya
                            const optionText =
                                `${price.course.name} - ${price.name} (Rp ${priceFormatted})`;
                            coursePriceSelect.append(
                                `<option value="${price.id}">${optionText}</option>`);
                        });
                    } else {
                        coursePriceSelect.html(
                            '<option value="" disabled selected>-- Tidak ada paket tersedia --</option>');
                    }
                } catch (error) {
                    console.error('Error fetching course prices:', error);
                    coursePriceSelect.html(
                        '<option value="" disabled selected>-- Gagal memuat data --</option>');
                } finally {
                    coursePriceSelect.prop('disabled', false);
                }
            }

            // Event listener untuk input tanggal
            $('#registration_date').on('change', function() {
                const selectedDate = $(this).val(); // Ambil tanggal dari input
                if (selectedDate) { // Pastikan ada tanggal yang dipilih sebelum fetch
                    fetchCoursePrices(selectedDate);
                }
            });

            // Panggil event 'change' sekali saat halaman pertama kali dimuat
            $('#registration_date').trigger('change');
        });
    </script>
@stop
