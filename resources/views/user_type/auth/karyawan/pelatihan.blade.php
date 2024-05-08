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

<div>
    <div class="row">
        <div class="col pb-3 ms-4">
            <div class="card bg-gradient-info border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                        <h5 class="text-white mb-2">Persentase Capaian</h5>
                        <span class="text-white font-weight-bold font-size-h1">
                            {{$persentase}}
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col pb-3 me-4">
            <div class="card bg-gradient-success border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                        <h5 class="text-white mb-2">Total Durasi</h5>
                        <span class="text-white font-weight-bold font-size-h1">
                            {{$sum_durasi}} Jam
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-3">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Semua Pelatihan</h5>
                        </div>
                        <div class="d-flex gap-2">
                            <form action="{{route('export.pencatatan', [$year, Auth::user()->id])}}">
                                <button type="submit" role="button" class="btn bg-gradient-info btn-sm mb-0">
                                    Unduh Data Pelatihan
                                </button>
                            </form>
                            <a href="{{route('pencatatan.create',$year)}}" class="btn bg-gradient-dark btn-sm mb-1">
                                +&nbsp; Tambah Pelatihan
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-3">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script type="text/javascript">
    $(function () {
        
        var table = $('.karyawanperperiode-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pencatatan.show', ':id') }}".replace(':id', $year),
            columns: [
                {data: 'id', name: 'id'},
                {data: 'full_name', name: 'full_name'},
                {data: 'persentase', name: 'persentase'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
    });
    </script>
@endpush