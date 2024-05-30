@extends('layouts.user_type.auth')

@section('content')

@if(session('success') || session('error'))
<div class="toast align-items-center text-white {{session('success') ? "bg-success" : "bg-danger" }} show border-0 top-5 end-3 position-absolute" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 100">
    <div class="d-flex flex-wrap">
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
                            <h5 class="mb-0">All Users</h5>
                        </div>
                        @if(auth()->user()->role_id == 1)
                        <div class="d-flex gap-2">
                            <form action="{{route('user.export')}}">
                                <button type="submit" role="button" class="btn bg-gradient-info btn-sm mb-0">
                                    Unduh Data Users
                                </button>
                            </form>
                            <button type="button" class="btn bg-gradient-dark btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                +&nbsp; Tambah Akun
                            </button>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Tambah Akun</h5>
        </div>
        <div class="modal-body">
            
            <i class="ni ni-badge text-sm me-2"></i> Manual Input
            <form role="form text-left" method="POST" action="{{route('users.store')}}">
                @csrf
                <label>Nama Lengkap</label>
                <div class="input-group mb-3">
                    <input name="full_name" type="text" class="form-control" placeholder="Nama Lengkap" aria-label="nama-lengkap" aria-describedby="text-addon">
                </div>
                <label>NIK</label>
                <div class="input-group mb-3">
                    <input name="NIK" type="text" class="form-control" placeholder="13749232387" aria-label="NIK" aria-describedby="text-addon">
                </div>
                <label>Unit</label>
                <div class="input-group mb-3">
                    <input name="unit" type="text" class="form-control" placeholder="UGD" aria-label="unit" aria-describedby="text-addon">
                </div>
                
                <label>Role</label>
                <div class="input-group mb-3">
                    <select class="form-select" id="role" name="role">
                        <option selected value="2">Karyawan</option>
                        <option value="1">Admin</option>                        
                    </select>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn bg-gradient-success">Tambah</button>
                </div>
            </form>
            
            <i class="ni ni-laptop text-sm me-2"></i> Excel Input
            <div class="col-xs-12 mb-3">
                <form action="{{route('users.import')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <strong>Upload Data Karyawan</strong>
                        <input type="file" id="file_users" name="file_users" class="form-control">
                    </div>
                </form>
            </div>
            <div class="col-xs-12 mb-3">
                <a href="{{url('/template/Template_users.xlsx')}}" download class="btn bg-gradient-info">
                Unduh template data
                </a>
            </div>
        </div>
    </div>
    </div>
</div>
@endif

<dialog class="bg-transparent border-0 px-3" id="delete_user" aria-labelledby="delete-user">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="delete-user-label">
                        Delete data unit
                        <q id="delete-user-name"></q> 
                    </h5>
                </div>
                <form id="delete-user-form" role="form text-left" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" onclick="closeModal()" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button autofocus type="submit" class="btn bg-gradient-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </dialog>  
@endsection

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script type="text/javascript">
    $(function () {
        
        var table = $('.users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'full_name', name: 'full_name'},
                {data: 'role', name: 'role'},
                {data: 'email', name: 'email'},
                {data: 'NIK', name: 'NIK'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
                {data: 'reset_password', name: 'reset_password', orderable: false, searchable: false},
            ]
        });
        
    });
    var integrity = {!! json_encode(session('integrity_id') ?? strtolower(md5('Good Luck My Bro :) '.rand(3000,10000).''))) !!}
    console.log(`integrity_id = ${integrity}`);

    const delete_user = document.getElementById('delete_user');
      const delete_name = document.getElementById('delete-user-name');
      const delete_form = document.getElementById('delete-user-form');
      delete_user.addEventListener('click', (event) => {
        if (event.target === delete_user) {
          delete_user.close();
        }
      });

      function deleteModal(id, name) {
        delete_name.innerHTML = name;
        delete_form.action = "{{ route('users.destroy', ':id') }}".replace(':id', id);
        delete_user.showModal();
      }

      function closeModal() {
        delete_name.innerHTML = '';
        delete_form.action = '';
        delete_user.close();
      }
      
    document.getElementById('file_users').addEventListener('change', function() {
        this.form.submit();
    });
    </script>
@endpush