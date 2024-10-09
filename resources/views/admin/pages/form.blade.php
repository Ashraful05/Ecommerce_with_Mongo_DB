@extends('admin.master')
@if($cmsPage->exists)
    @section('title','Update CMS Page')
@else
    @section('title','Add CMS Page')
@endif

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
                            <li class="breadcrumb-item active"><a href="{{ route('cmsPage.index') }}">View CMS Pages</a></li>
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
                                @if($cmsPage->exists)
                                    <h3 class="card-title">Update CMS Page</h3>
                                @else
                                    <h3 class="card-title">Add CMS Page</h3>
                                @endif
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
                            @if($cmsPage->exists)
                                <form name="cmsForm" id="cmsForm" action="{{ route('cmsPage.update',$cmsPage->id) }}" method="post" >
                                    @method('put')
                                    @else
                                        <form name="cmsForm" id="cmsForm" action="{{ route('cmsPage.store')}}" method="post">
                                            @endif
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" value="{{ old('title',$cmsPage->title) }}" class="form-control" id="title" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="url">URL</label>
                                                    <input type="text" name="url" value="{{ old('url',$cmsPage->url) }}" class="form-control" id="url" >
                                                    <span id="verifyCurrentPassword"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" id="" class="form-control">{{ old('description',$cmsPage->description) }}</textarea>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->

                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary form-control">Submit</button>
                                            </div>

                                        </form>
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

