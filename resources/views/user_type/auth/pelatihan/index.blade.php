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
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-3">
                    <div class="d-flex flex-row flex-wrap justify-content-between">
                        <div>
                            <h5 class="mb-0">Semua Pelatihan</h5>
                        </div>
                        @if(auth()->user()->role_id == 1)
                        <div>
                            <a href="{{route('export.user.periode',$year)}}" class="btn bg-gradient-dark btn-sm mb-1">
                                Unduh Data
                            </a>
                            <a href="{{route('pelatihan.validate',$year)}}" class="btn bg-gradient-warning btn-sm mb-1">
                                Validasi
                            </a>
                            <button type="button" class="btn bg-gradient-secondary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Pelatihan Wajib
                            </button>
                            <a href="{{route('pelatihan.grafik',$year)}}" class="btn bg-gradient-info btn-sm mb-1">
                                Lihat Grafik
                            </a>
                        </div>
                        @endif
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
@if(auth()->user()->role_id == 1)
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Tambah Pelatihan Wajib {{$year}}</h5>
            </div>
            <form role="form text-left" method="POST" action="{{ route('pelatihan.store') }}">
                @csrf
                @method('POST')
                <label>Nama Lengkap</label>
                <div class="input-group mb-3">
                  <input name="nama_pelatihan" type="text" class="form-control" placeholder="Latihan ...." aria-label="nama-pelatihan" aria-describedby="text-addon">
                </div>
                <input name="periode_id" type="text" class="form-control d-none" value="{{$year}}" aria-label="periode-id" aria-describedby="text-addon">
                
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn bg-gradient-success">Tambah</button>
                </div>
            </form>
            <div class="w-100">
                <table class="w-100 table-responsive table p-3 dataTable">
                    <thead>
                        <tr>
                            <th class="d-flex justify-content-center">Aksi</th>
                            <th>Nama Pelatihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelatihan_wajib as $item)
                        <tr>
                            <td class="d-flex justify-content-center">
                                <form action="{{route('pelatihan.destroy',$item->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger my-auto p-2 rounded-1">
                                        <i class="fas fa-trash text-white m-0"></i>
                                    </button>
                                </form>
                            </td>
                            <td>{{$item->nama_pelatihan}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</div>
@endif 
@endsection

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script type="text/javascript">
    $(function () {
        
        var table = $('.karyawanperperiode-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pelatihan.periode', ':id') }}".replace(':id', $year),
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