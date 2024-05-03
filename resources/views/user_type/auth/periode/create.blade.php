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
<form action="{{ route('periode.store') }}" method="POST">
    @method('POST')
    @csrf
    <div class="row">
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Tahun Periode:</strong>
                <input type="number" min="2020" max="2055" id="periode_name" placeholder="ex : 2024" name="periode_name" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 mb-3 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="block justify-items-center mx-4">
                <div class="card-header pb-3">
                    <h2>Periode Terdaftar </h2>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-3">
                        {{$dataTablePeriode->table()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<dialog class="bg-transparent border-0" id="modal" aria-labelledby="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h5 id="label" class="modal-title font-weight-normal">
                    </h5>
                </div>
                <form id="form" role="form text-left" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer" id="form-input">
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
    {{ $dataTablePeriode->scripts(attributes: ['type' => 'module']) }}
    <script type="text/javascript">
    $(function () {
        
        var table = $('.periode-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('periode.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'periode_name', name: 'periode_name'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
    });

    const modal = document.getElementById('modal');
    const name = document.getElementById('label');
    const form = document.getElementById('form');
    const form_input = document.getElementById('form-input');
    modal.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.close();
    }
    });

    function deleteModal(id, label) {
        name.innerHTML = `Delete data periode <q>${label}</q>`;
        form_input.innerHTML = `
            <input type="hidden" name="_method" value="DELETE">
            <button type="button" onclick="closeModal()" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            <button autofocus type="submit" class="btn bg-gradient-danger">Delete</button>
            `;
        form.action = "{{ route('periode.destroy', ':id') }}".replace(':id', id);
        modal.showModal();
    }

    function editModal(id, label) {
        name.innerHTML = `Edit data periode <q>${label}</q>`;
        form_input.innerHTML = `
            <input type="hidden" name="_method" value="PUT">
            <input type="text" name="periode_name" value="${label}" class="form-control">
            <button type="button" onclick="closeModal()" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            <button autofocus type="submit" class="btn bg-gradient-success">Update</button>
            `;
        form.action = "{{ route('periode.update', ':id') }}".replace(':id', id);
        modal.showModal();
    }

    function closeModal() {
        name.innerHTML = '';
        form.action = '';
        modal.close();
    }

    </script>
@endpush