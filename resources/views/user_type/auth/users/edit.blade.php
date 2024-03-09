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
<form action="{{ route('users.update', $user->id) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" id="full_name" value="{{ $user->full_name }}" name="full_name" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Username: <i>(autocomplete)</i></strong>
                <input type="text" id="email" name="email" value="{{ $user->email }}" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>NIK:</strong>
                <input type="number" id="NIK" name="NIK" value="{{ $user->NIK }}" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Unit:</strong>
                <input type="text" name="unit" value="{{ $user->unit }}" class="form-control">
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Password:</strong>
                <input type="password" name="password" class="form-control"
                    placeholder="Password">
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Confirm Password:</strong>
                <input type="password" name="confirm-password" class="form-control"
                    placeholder="Confirm Password">
            </div>
        </div>
        <div class="col-xs-12 mb-3">
            <div class="form-group">
                <strong>Role:</strong>
                <select class="form-control" name="role">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{$user->role_id == $role->id ? 'selected' : ''}}>{{ $role->role_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 mb-3 text-center">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </div>
</form>
@endsection

@push('js')
    <script>
        const username = document.getElementById('full_name');
        const u_email = document.getElementById('email');
        const u_nik = document.getElementById('NIK');
        username.addEventListener('input', function(){
            u_email.value = username.value.toLowerCase().split(' ')[0] + '.' + u_nik.value;
        });
        u_nik.addEventListener('input', function(){
            u_email.value = username.value.toLowerCase().split(' ')[0] + '.' + u_nik.value;
        });
    </script>
@endpush