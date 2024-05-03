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
            <h5 class="mb-0">Edit {{$pelatihan->nama_pelatihan}} di Tahun {{$year}}</h5>
        </div>
        <a href="{{route('pencatatan.show',$year)}}" class="btn bg-gradient-primary btn-sm mb-1">
            Kembali
        </a>
    </div>
</div>
<form action="{{ route('pencatatan.update',['year' => $year,'id' => $pelatihan->id]) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-xs-12 mb-3">
            <div class="form-group mb-3">
                <strong>Pelatihan Wajib:</strong>
                <select class="form-select" id="wajib" name="wajib">
                        <option value="0" selected>Tidak Wajib</option>
                    @foreach ($pelatihan_wajib as $item)
                        <option value="1">{{$item->nama_pelatihan}}</option>              
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Nama Pelatihan:</strong>
                <input type="text" id="nama_pelatihan" value="{{$pelatihan->nama_pelatihan}}" name="nama_pelatihan" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Nama Penyelenggara:</strong>
                <input type="text" id="nama_penyelenggara" value="{{$pelatihan->nama_penyelenggara}}" name="nama_penyelenggara" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <strong>Tanggal Mulai:</strong>
            <div class="form-group">
                <input id="date-identifier" type="datetime-local" name="tgl_mulai" class="form-control">
            </div>
            <strong>Tanggal Selesai:</strong>
            <div class="form-group">
                <input id="date-identifier" type="datetime-local" name="tgl_selesai" class="form-control">
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
                <input type="hidden" name="old_bukti_pelatihan" value="{{$pelatihan->bukti_pelatihan}}">
            </div>
        </div>
        @if($bukti_pelatihan)
            <div class="card w-100 mb-3 mx-2 d-flex flex-row p-3">
                @foreach ($bukti_pelatihan as $item)
                    <a class="btn bg-gradient-info btn-sm mx-1" href="{{asset('bukti/'.$item)}}" target="_blank">
                        Bukti {{$loop->iteration}}
                    </a>
                @endforeach
            </div>
        @endif
        <div class="col-xs-12 mb-3 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

@endsection

@push('js')
    <script>
        // make durasi base on tgl_selesai - tgl_mulai, show it in input[name="durasi"] as hours
        $('input[id="date-identifier"]').on('change', function() {
            var tgl_mulai = new Date($('input[name="tgl_mulai"]').val());
            var tgl_selesai = new Date($(this).val());
            var diff = tgl_selesai - tgl_mulai;
            var hours = Math.floor(diff / 1000 / 60 / 60);
            $('input[name="durasi"]').val(hours + " jam");
        });
    </script>
@endpush