@extends('admin.dashboard.main')
@section('title', 'Add Role')
@section('sidenav')
    @include('admin.dashboard.sidenav')
@endsection
@section('page', 'Add Role')
@section('nav')
    @include('admin.dashboard.nav')

    <style>
        .border-contrast {
            transition: border-color 0.3s ease; 
            border: 1px solid #ced4da; 
            width: 100%; 
        }

        .border-contrast:focus-within {
            border-color: #ff69b4; 
        }

        .form-label {
            font-weight: bold;
            margin-top: 20px;
        }

        .card {
            margin-top: 30px;
            margin-left: 150px;
            width: 70%;
        }
        
        .col-3 {
            margin-top: 30px;
        }

        .error-message {
            color: red;
            font-size: 12px;
        }
    </style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Add New Role</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.addRole') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input type="text" class="form-control" id="role" name="role" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
