@extends('admin.master')
@section('title','Sub Admin Page')
@section('main_content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Sub Admin Page</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sub Admin Pages</h3>
                <a href="{{ route('add.sub.admin') }}" class="btn btn-primary" style="float: right" title="Add SubAdmin Page"><i class="fas fa-plus-circle"></i></a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="cmspages" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Sl.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile No.</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subAdmins as $row => $subAdmin)
                        <tr>
                            <td> {{ ++$row }} </td>
                            <td>{{ $subAdmin->name }}</td>
                            <td>{{ $subAdmin->email }}</td>
                            <td>{{ $subAdmin->mobile }}</td>
                            <td>
                                <img src="{{ !empty($subAdmin->image)?asset('admin/images/sub_admin_photos/'.$subAdmin->image):url('admin/images/no_image.jpg') }}" style="height: 100px;width: 100px;" alt="">
                            </td>
                            <td>

                                <a href="{{ route('edit.sub.admin',$subAdmin->_id) }}" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;


                                @if($subAdmin->status == 1)
                                    <a href="javascript:void(0)" class="updateSubAdminPageStatus" id="page-{{$subAdmin->_id}}" page_id="{{ $subAdmin->_id }}">
                                        <i class="fas fa-toggle-on" aria-hidden="true" status="active"></i>
                                    </a>&nbsp;
                                @else
                                    <a href="javascript:void(0)" class="updateSubAdminPageStatus" id="page-{{$subAdmin->_id}}" page_id="{{ $subAdmin->_id }}">
                                        <i class="fas fa-toggle-off" aria-hidden="true" status="inactive"></i>
                                    </a>&nbsp;
                                @endif

                                <a href="{{ route('update.role',$subAdmin->_id) }}"><i class="fas fa-unlock"></i></a>

                                <form id="delete-cms-form_{{$subAdmin->_id}}" action="{{route('subadmin.delete',$subAdmin->_id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" id="delete-cms" recordId="{{ $subAdmin->_id }}"><i class="fas fa-trash"></i></button>
                                </form>

                            </td>

                        </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>

    </div>




@endsection
