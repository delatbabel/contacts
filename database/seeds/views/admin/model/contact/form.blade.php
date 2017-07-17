@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h2>
                Contact
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
                        <ul class="nav nav-tabs">
                            <li class=""><a data-toggle="tab" href="#tab-1">Contact</a></li>
                            @if($itemId)
                                <li class=""><a data-toggle="tab" href="#tab-2">Address</a></li>
                            @endif
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane">
                                <div class="panel-body">
                                    {!! Form::model($model, [
                                            'class'   => 'form-horizontal',
                                            'enctype' => 'multipart/form-data',
                                            'route'   => ['admin_save_item',$config->getOption('name'),$itemId],
                                        ]) !!}

                                    @foreach($arrayFields as $key => $arrCol)
                                        @if($arrCol['visible'] && $arrCol['editable'])
                                            <div class="form-group {{$errors->has($arrCol['field_name']) ? 'has-error' : null}}">
                                                <label class="col-md-2 control-label" for="{{$arrCol['field_name']}}">
                                                    {!! $arrCol['title'] !!}
                                                </label>
                                                <div class="col-md-10">
                                                    @include('admin.model.field',[
                                                       'type'         => $arrCol['type'],
                                                       'name'         => $arrCol['field_name'],
                                                       'id'           => $arrCol['field_name'],
                                                       'value'        => $model->{$arrCol['field_name']},
                                                       'arrCol'       => $arrCol,
                                                       'defaultClass' => 'form-control',
                                                       'flagFilter'   => false,
                                                    ])
                                                    @if ($errors->has($arrCol['field_name']))
                                                        <p style="color:red;">
                                                            {!!$errors->first($arrCol['field_name'])!!}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                        @endif
                                    @endforeach

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
                            <div id="tab-2" class="tab-pane" >
                                <div class="panel-body">
                                    <div class="panel-body">
                                        @include('admin.model.contact.address')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@section('javascript')
    <script !src="">
        $(function () {
            var _mode = '{{old('mode')}}';
            if (_mode == 'address') {
                $('ul.nav-tabs a[href="#tab-2"]').trigger('click');
            }
            else {
                $('ul.nav-tabs a[href="#tab-1"]').trigger('click');
            }
        });
    </script>
@endsection
