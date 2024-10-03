@extends('admin.master')
@section('title','Update Admin Details')
@section('main_content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Update Admin Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Admin Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('update.admin.details')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" name="email" value="{{ Auth::guard('admin')->user()->email }}" class="form-control" id="exampleInputEmail1" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" value="{{ Auth::guard('admin')->user()->name }}" class="form-control" id="name" required>
                                        <span id="verifyCurrentPassword"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input type="text" name="mobile" value="{{ Auth::guard('admin')->user()->mobile }}" class="form-control" id="mobile"  required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Image</label>
                                        <input type="file" name="image" class="form-control" id="image" >
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary form-control">Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection

