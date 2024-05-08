@extends('layouts.user_type.auth')

@section('content')

@if(session('success') || session('error'))
<div class="toast align-items-center text-white {{session('success') ? "bg-success" : "bg-danger" }} show border-0 top-5 end-3 position-absolute" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 100">
    <div class="d-flex">
    <div class="toast-body">
        {{session('success')}} {{session('error')}}
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
@endif
<div class="row mb-2">
    <div class="d-flex flex-row justify-content-between">
        <div>
            <h5 class="mb-0">Tambah Pelatihan {{$year}}</h5>
        </div>
        <a href="{{route('pencatatan.show',$year)}}" class="btn bg-gradient-primary btn-sm mb-1">
            Kembali
        </a>
    </div>
</div>
<form action="{{ route('pencatatan.store',$year) }}" method="POST" enctype="multipart/form-data">
    @method('POST')
    @csrf
    <div class="row">
        <div class="col-xs-12 mb-3">
            <div class="form-group mb-3">
                <strong>Pelatihan Wajib:</strong>
                <select class="form-select" id="wajib" name="wajib">
                        <option value="0">Tidak Wajib</option>
                    @foreach ($pelatihan_wajib as $item)
                        <option value="1">{{$item->nama_pelatihan}}</option>              
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Nama Pelatihan:</strong>
                <input type="text" id="nama_pelatihan" placeholder="Pelatihan ...." name="nama_pelatihan" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Nama Penyelenggara:</strong>
                <input type="text" id="nama_penyelenggara" placeholder="Pelatihan ...." name="nama_penyelenggara" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <strong>Tanggal Mulai:</strong>
            <div class="form-group">
                <input id="date-identifier" type="datetime-local" name="tgl_mulai" class="form-control" value="{{date('Y-m-d\TH:i')}}">
            </div>
            <strong>Tanggal Selesai:</strong>
            <div class="form-group">
                <input id="date-identifier" type="datetime-local" name="tgl_selesai" class="form-control" value="{{date('Y-m-d\TH:i', strtotime('+2 hours'))}}">
            </div>
            <strong>Durasi:</strong>
            <div class="form-group">
                <input type="text" name="durasi" class="form-control" placeholder="2 jam" disabled>
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Bukti Pelatihan:</strong>
                <input type="file" id="bukti_pelatihan" name="bukti_pelatihan[]" class="form-control" multiple>
            </div>
        </div>
        <div class="col-xs-12 mb-3 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

@endsection

@push('js')
    <script>
        // make durasi base on tgl_selesai - tgl_mulai, show it in input[name="durasi"] as hours
        function getWorkingDays(startDate, endDate) {
        var workingDays = 0;
        var currentDate = new Date(startDate);
        while (currentDate <= endDate) {
            var dayOfWeek = currentDate.getDay();
            if (dayOfWeek !== 6 && dayOfWeek !== 0) {
                workingDays++;
            }
            currentDate.setDate(currentDate.getDate() + 1);
        }
        return workingDays;
    }

    // make durasi base on tgl_selesai - tgl_mulai, show it in input[name="durasi"] as hours
    $('input[id="date-identifier"]').on('change', function() {
        var tgl_mulai = new Date($('input[name="tgl_mulai"]').val());
        var tgl_selesai = new Date($(this).val());

        var yearTglMulai = parseInt(tgl_mulai.getFullYear());
        var yearTglSelesai = parseInt(tgl_selesai.getFullYear());
        var yearPHP = parseInt({!! json_encode($year) !!});

        if (yearTglMulai !== yearPHP || yearTglSelesai !== yearPHP) {
            alert("Tahun tanggal mulai atau tanggal selesai tidak sama dengan tahun pelatihan, ubah ke tahun " + yearPHP + " untuk melanjutkan.");
        }
        
        // Calculate working days and hours between two dates
        var workingDays = getWorkingDays(tgl_mulai, tgl_selesai);
        var workingHours = 0;

        if (workingDays === 0) {
            // If it's same day
            workingHours = Math.round((tgl_selesai - tgl_mulai) / 1000 / 60 / 60);
            if (workingHours > 7) {
                workingHours = 7;
            }
        } else {
            // If it's multiple days
            workingHours = workingDays * 7; // Assuming each working day is 7 hours
        }

        $('input[name="durasi"]').val(workingHours + " jam");
    });
    
    </script>
@endpush