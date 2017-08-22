<div class="ibox">
    <div class="ibox-title">
        <h5>Company Addresses
            <small>Information</small>
        </h5>
        <div class="ibox-tools">
            <button id="add-company-address" class="btn btn-xs btn-primary">Add Company Address</button>
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
                {!! Form::hidden('company_address_id', isset($companyAddress) ? $companyAddress->id : null) !!}
                {!! Form::hidden('mode', 'company_address') !!}
                {!! Form::hidden('delete', 0) !!}
                {!! Form::hidden('expire', 0) !!}
                @include('admin.model.company.address_partial_fields', ['address' => $companyAddress])
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
                                <a href="{{ route('admin_get_item', ['model' => $config->getOption('name'), 'id' => $model->id, 'company_address_id' => $item->id]) }}" class="btn btn-xs btn-sd-default btn-edit">
                                    Edit
                                </a>
                                <a href="#" class="btn btn-xs btn-sd-default btn-delete"
                                   data-id="{{$item->id}}">
                                    Delete
                                </a>
                                <a href="#" class="btn btn-xs btn-sd-default btn-expire"
                                   data-id="{{$item->id}}">
                                    Expire
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
    <script src="{{ asset('packages/ddpro/admin/assets/js/companies/address.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            // Show form when there are errors
            var _mode = '{{old('mode', $mode)}}';
            var _hasError = {{count($errors)}};
            var _isEdit = "{{Request::get('company_address_id') ? 'true' : 'false'}}";
            var _addressForm = $(".form-address");

            CompanyAddressHandle.init(_mode, _isEdit, _hasError, _addressForm);
        });
    </script>
@endsection
