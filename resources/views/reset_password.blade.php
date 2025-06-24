@extends('layout.navbar')

@section('style')
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Reset password</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card widget">
                        <div class="card card-body">
                            <div class="widget-stats-container">
                                <form action="/reset-password/{{ $user_id }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="old_password" class="form-label">Password Lama</label>
                                        <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password">
                                        <div class="invalid-feedback">
                                            @error('old_password')
                                                Password lama harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="new_password" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                                        <div class="invalid-feedback">
                                            @error('new_password')
                                                Password baru harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <button class="btn btn-primary float-end" type="submit">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection
