<div class="ibox">
    <div class="ibox-title">
        <h5>Address
            <small>Information</small>
        </h5>
        <div class="ibox-tools">
            <button id="add-address" class="btn btn-xs btn-primary">Add Address</button>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open([
                        'class'   => 'form-horizontal form-address',
                        'enctype' => 'multipart/form-data',
                        'route'   => ['admin_save_item',$config->getOption('name'),$itemId],
                    ]) !!}
                {!! Form::hidden('address_id', null) !!}
                {!! Form::hidden('mode', 'address') !!}
                {!! Form::hidden('delete', 0) !!}
                @include('admin.model.address.partial_fields')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{$errors->has('address_type') ? 'has-error' : null}}">
                            <label class="col-md-4 control-label" for="address_type">
                                Address Type <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-8">
                                {!! Form::select('address_type',['' => 'Choose a Type...'] + $addressTypeList, null, ['class'=>'form-control chosen-select']) !!}
                                @if ($errors->has('address_type'))
                                    <p class="text-danger">{!!$errors->first('address_type')!!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{$errors->has('status') ? 'has-error' : null}}">
                            <label class="col-md-4 control-label" for="status">
                                Address Status <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-8">
                                {!! Form::select('status',['' => 'Choose a Status...'] + $addressStatusList, null, ['class'=>'form-control chosen-select']) !!}
                                @if ($errors->has('status'))
                                    <p class="text-danger">{!!$errors->first('status')!!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{$errors->has('start_date') ? 'has-error' : null}}">
                            <label class="col-md-4 control-label" for="start_date">
                                Start Date
                            </label>
                            <div class="col-md-8">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {!! Form::text('start_date',null, ['class'=> 'form-control', 'id'=>'start_date']) !!}
                                </div>
                                @if ($errors->has('start_date'))
                                    <p class="text-danger">{!!$errors->first('start_date')!!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{$errors->has('end_date') ? 'has-error' : null}}">
                            <label class="col-md-4 control-label" for="end_date">
                                End Date
                            </label>
                            <div class="col-md-8">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    {!! Form::text('end_date',null, ['class'=> 'form-control', 'id'=>'end_date']) !!}
                                </div>
                                @if ($errors->has('end_date'))
                                    <p class="text-danger">{!!$errors->first('end_date')!!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a href="#" class="btn btn-default btn-cancel">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                {!! Form::close() !!}
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Address</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($model->addresses()->get() as $item)
                        <?php
                        $tmpType                 = $item->pivot->address_type;
                        $tmpStatus               = $item->pivot->status;
                        $tmpType                 = isset($addressTypeList[$tmpType]) ? $addressTypeList[$tmpType] : $tmpType;
                        $tmpStatus               = isset($addressStatusList[$tmpStatus]) ? $addressStatusList[$tmpStatus] : $tmpStatus;
                        $item->pivot->start_date = $item->pivot->start_date != '0000-00-00' ? $item->pivot->start_date : null;
                        $item->pivot->end_date   = $item->pivot->end_date != '0000-00-00' ? $item->pivot->end_date : null;
                        ?>
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->formatted_address}}</td>
                            <td>{{$tmpType}}</td>
                            <td>{{$tmpStatus}}</td>
                            <td>{{$item->pivot->start_date}}</td>
                            <td>{{$item->pivot->end_date}}</td>
                            <td>
                                <a href="#" class="btn btn-xs btn-sd-default btn-edit"
                                   data-address_info="{{json_encode($item->toArray())}}">
                                    Edit
                                </a>
                                <a href="#" class="btn btn-xs btn-sd-default btn-delete"
                                   data-id="{{$item->id}}">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('javascript')
    @parent
    <script type="text/javascript">
        $(function () {
            var ContactAddressHandle = function () {
                // Show form when there are errors
                var _mode = '{{old('mode')}}';
                var _hasError = {{count($errors)}};
                var _addressForm = $(".form-address");

                var HandlePlugins = function () {
                    // Chosen
                    $('.chosen-select').chosen({
                        width: '100%'
                    });
                    $("#start_date,#end_date").datepicker({
                        dateFormat: "yy-mm-dd"
                    });
                };
                var ModeHandle = function () {
                    if (_mode == 'address' && _hasError) {
                        _addressForm.show();
                    }
                    else {
                        _addressForm.hide();
                    }
                };
                var resetForm = function () {
                    $('input:hidden[name="address_id"]', _addressForm).val(null);
                    _addressForm[0].reset();
                    $('.chosen-select', _addressForm).trigger("chosen:updated");
                };
                var FormHandle = function () {
                    // Form Handle
                    $('.btn-cancel', _addressForm).click(function () {
                        resetForm();
                        _addressForm.hide();
                    });
                    // Handle Add action
                    $('#add-address').click(function () {
                        resetForm();
                        _addressForm.show();
                    });
                    // Handle Edit action
                    $('.btn-edit').click(function () {
                        var objData = $(this).data();
                        $('input:hidden[name="delete"]', _addressForm).val(0);
                        $('input:hidden[name="address_id"]', _addressForm).val(objData.address_info.id);

                        $.each(objData.address_info.pivot, function (key, value) {
                            if (['address_type', 'status'].indexOf(key) >= 0) {
                                $('select[name="' + key + '"]', _addressForm)
                                        .find('option[value="' + value + '"]')
                                        .prop('selected', true)
                                        .trigger("chosen:updated");
                            } else if (['start_date', 'end_date'].indexOf(key) >= 0) {
                                $('input[name="' + key + '"]', _addressForm).val(value);
                            }
                        });
                        $.each(objData.address_info, function (key, value) {
                            if (['country_code'].indexOf(key) >= 0) {
                                $('select[name="' + key + '"]', _addressForm)
                                        .find('option[value="' + value + '"]')
                                        .prop('selected', true)
                                        .trigger("chosen:updated");
                            } else if (['street', 'suburb', 'city', 'state_name', 'postal_code', 'contact_name', 'contact_phone'].indexOf(key) >= 0) {
                                $('input[name="' + key + '"]', _addressForm).val(value);
                            }
                        });
                        _addressForm.show();
                    });

                    // Handle delete action
                    $('.btn-delete').click(function () {
                        if (!confirm('Do you want remove this item ?')) {
                            return;
                        }
                        var objData = $(this).data();
                        $('input:hidden[name="delete"]', _addressForm).val(1);
                        $('input:hidden[name="address_id"]', _addressForm).val(objData.id);
                        _addressForm.submit();
                    });
                };
                return {
                    init: function () {
                        ModeHandle();
                        HandlePlugins();
                        FormHandle();
                    }
                };
            }();
            ContactAddressHandle.init();
        });
    </script>
@endsection
