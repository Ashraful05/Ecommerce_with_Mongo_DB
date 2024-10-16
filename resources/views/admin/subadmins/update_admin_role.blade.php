@extends('admin.master')
@section('title','Edit SubAdmin Role')
@section('main_content')

{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>--}}

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
                                <h3 class="card-title">{{ $title }}</h3>
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

                            <form action="{{ route('update.role',$id) }}" method="post" >
                                @csrf
                                <input type="hidden" name="admin_id" value="{{ $id }}">
                                @if(!empty($subAdminRoles))
                                    @foreach($subAdminRoles as $role)
                                        @if($role->module == 'cms_pages')
                                            @if($role->view_access==1)
                                                @php $viewCMSPages = 'checked'; @endphp
                                            @else
                                                @php $viewCMSPages = ''; @endphp
                                            @endif
                                            @if($role->edit_access==1)
                                                @php $editCMSPages = 'checked'; @endphp
                                            @else
                                                @php $editCMSPages = ''; @endphp
                                            @endif
                                            @if($role->full_access==1)
                                                @php $fullCMSPages = 'checked'; @endphp
                                            @else
                                                @php $fullCMSPages = ''; @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                                <div class="card-body">
                                    <div class="form-group col-md-12">
                                        <label for="title">CMS Pages: &nbsp;&nbsp;&nbsp;</label>
                                        <input type="checkbox" name="cms_pages[view]" value="1" @if(isset($viewCMSPages)){{ $viewCMSPages }} @endif>View Access &nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" name="cms_pages[edit]" value="1" @if(isset($editCMSPages)){{ $editCMSPages }} @endif>Edit Access &nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" name="cms_pages[full]" value="1" @if(isset($fullCMSPages)){{ $fullCMSPages }} @endif>Full Access
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success form-control">Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>



{{--        <script>--}}
{{--            $(document).ready(function(){--}}
{{--                $('#image').change(function(e){--}}
{{--                    var reader = new FileReader();--}}
{{--                    reader.onload = function(e){--}}
{{--                        $('#showImage').attr('src',e.target.result);--}}
{{--                    }--}}
{{--                    reader.readAsDataURL(e.target.files['0']);--}}
{{--                })--}}
{{--            });--}}
{{--        </script>--}}

@endsection

