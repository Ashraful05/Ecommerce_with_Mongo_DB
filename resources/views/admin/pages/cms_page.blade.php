@extends('admin.master')
@section('title','Home Page')
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
                            <li class="breadcrumb-item active">CMS Page</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">CMS Pages</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="cmspages" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>URL</th>
                        <th>Created On</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cmsPages as $cmsPage)
                    <tr>
                        <td>{{ $cmsPage->title }}</td>
                        <td>{{ $cmsPage->url }}</td>
                        <td>{{ $cmsPage->created_at }}</td>
                        <td>
                            <a href="{{ route('cmsPage.edit',$cmsPage->id) }}" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                            <a href="{{ route('cmsPage.destroy',$cmsPage->id) }}" title="Delete"><i class="fas fa-trash"></i></a>&nbsp;&nbsp;
                            @if($cmsPage->status == 1)
                                <a href="javascript:void(0)" class="updateCmsPageStatus" id="page-{{$cmsPage->id}}" page_id="{{ $cmsPage->id }}">
                                    <i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i>
                                </a>
                            @else
                                <a href="javascript:void(0)" class="updateCmsPageStatus" id="page-{{$cmsPage->id}}" page_id="{{ $cmsPage->id }}">
                                    <i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i>
                                </a>
                            @endif
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
