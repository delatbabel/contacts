@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h2>
                Address
                <small>Form</small>
            </h2>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active"><strong>Here</strong></li>
            </ol>
        </section>
        <section class="content">
            <div id="admin_page" class="with_sidebar">

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            @if($itemId)
                                {{trans('administrator::administrator.edit')}}
                            @else
                                {{trans('administrator::administrator.createnew')}}
                            @endif
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::model($model, [
                                        'class'   => 'form-horizontal',
                                        'enctype' => 'multipart/form-data',
                                        'route'   => ['admin_save_item',$config->getOption('name'),$itemId],
                                    ]) !!}

                                @include('admin.model.address.partial_fields')

                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a href="{{route('admin_index', $config->getOption('name'))}}" class="btn btn-default ">
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
        </section>
    </div>
@endsection
