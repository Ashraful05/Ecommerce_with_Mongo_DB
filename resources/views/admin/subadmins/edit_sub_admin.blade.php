@extends('admin.master')
@section('title','Edit SubAdmin Page')
@section('main_content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Pages Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('subadmins') }}">View Sub Admins</a></li>
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
                                <h3 class="card-title">Update Sub Admin</h3>
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

                            <form action="{{ route('update.sub.admin',$subAdminData->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="title">Sub Admin Name</label>
                                        <input type="text" name="name" value="{{ old('name',$subAdminData->name) }}"  class="form-control" id="name" >
                                    </div>
                                    <div class="form-group">
                                        <label for="url">Mobile</label>
                                        <input type="text" name="mobile" value="{{ old('mobile',$subAdminData->mobile) }}" class="form-control" id="mobile" >
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" value="{{ old('email',$subAdminData->email) }}" class="form-control" id="email" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Password</label>
                                        <input type="password" name="password"  class="form-control" id="password" >
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="hidden" name="old_image" value="{{ $subAdminData->image }}">
                                        <input type="file" name="image" class="form-control" id="image" >

                                    </div>
                                    <div class="form-group">

                                        <img id="showImage" src="{{ !empty($subAdminData->image)?url('admin/images/sub_admin_photos/'.$subAdminData->image):url('admin/images/no_image.jpg') }}" style="height: 100px;width: 100px;" alt="">

                                    </div>

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info form-control">Update</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <script>
            $(document).ready(function(){
                $('#image').change(function(e){
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('#showImage').attr('src',e.target.result);
                    }
                    reader.readAsDataURL(e.target.files['0']);
                })
            });
        </script>

@endsection

