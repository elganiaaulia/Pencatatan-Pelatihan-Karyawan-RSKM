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
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">
                                @if ($full_name)
                                    Pelatihan Karyawan {{$full_name}}
                                @else
                                    Validasi Pelatihan Semua Karyawan
                                @endif
                            </h5>
                        </div>
                        <div class="d-flex gap-2">
                            <form action="{{route('export.pelatihan', [$year, $id])}}">
                                <button type="submit" role="button" class="btn bg-gradient-dark btn-sm mb-0">
                                    Unduh Data Pelatihan
                                </button>
                            </form>
                            <a href="{{route('pelatihan.periode',$year)}}" class="btn bg-gradient-info btn-sm">
                                Kembali
                            </a>
                        </div>
                    </div>
                    @if ($karyawan_periode)
                        @if ($karyawan_periode->persentase < 40)
                            <span class="badge bg-gradient-danger">
                                Persentase : {{$karyawan_periode->persentase}}%
                            </span>
                        @elseif ($karyawan_periode->persentase < 70)
                            <span class="badge bg-gradient-warning">
                                Persentase : {{$karyawan_periode->persentase}}%
                            </span>
                        @elseif ($karyawan_periode->persentase == 100)
                            <span class="badge bg-gradient-success">
                                Persentase : {{$karyawan_periode->persentase}}%
                            </span>
                        @else
                            <span class="badge bg-gradient-info">
                                Persentase : {{$karyawan_periode->persentase}}%
                            </span>
                        @endif
                    @endif
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
        
        var table = $('.pelatihanperkaryawan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pelatihan.user', [':year',':id']) }}".replace(':year', {{$year}}).replace(':id', {{$id}}),
            columns: [
                {data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                {data: 'nama_pelatihan', name: 'nama_pelatihan'},
                {data: 'nama_penyelenggara', name: 'nama_penyelenggara'},
                {data: 'bukti_pelatihan', name: 'bukti_pelatihan'},
                {data: 'tgl_mulai', name: 'tgl_mulai'},
                {data: 'tgl_selesai', name: 'tgl_selesai'},
                {data: 'durasi', name: 'durasi'},
                {data: 'verified', name: 'verified'},
                {data: 'validasi', name: 'validasi', orderable: false, searchable: false},
            ]
        });
        
    });
    </script>
@endpush