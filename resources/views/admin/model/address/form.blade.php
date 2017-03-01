@extends('admin.layouts.main')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>
                Address
                <small>Form</small>
            </h2>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active"><strong>Here</strong></li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            @if($itemId)
                                {{trans('administrator::administrator.edit')}}
                            @else
                                {{trans('administrator::administrator.createnew')}}
                            @endif
                        </h5>
                    </div>
                    <div class="ibox-content">
                        @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        {!! Form::model($model, [
                                'class'   => 'form-horizontal',
                                'enctype' => 'multipart/form-data',
                                'route'   => ['admin_save_item',$config->getOption('name'),$itemId],
                            ]) !!}
                        @include('adminmodel.address.partial_fields')
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a href="{{route('admin_index', $config->getOption('name'))}}"
                                   class="btn btn-default ">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">Save & Close</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script !src="">
        $(function () {
            $('.chosen-select').chosen({width: "100%"});
        });
    </script>
@endsection
