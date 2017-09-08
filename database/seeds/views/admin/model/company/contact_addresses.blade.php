<div class="ibox">
    <div class="ibox-title">
        <h5>Contact Addresses
            <small>Information</small>
        </h5>
        <div class="ibox-tools">
            <button id="add-contact-address" class="btn btn-xs btn-primary" ng-click="vm.addNew()">Add Contact Address</button>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open([
                        'class'   => 'form-horizontal form-contact-address',
                        'enctype' => 'multipart/form-data',
                        'route'   => ['admin_save_item',$config->getOption('name'),$itemId, 'contact_id' => $contact->id],
                    ]) !!}
                {!! Form::hidden('contact_address_id', isset($contactAddress) ? $contactAddress->id : null) !!}
                <input name="mode" type="hidden" value="contact_address" autocomplete="off">
                {!! Form::hidden('delete', 0, ['ng-value'=>'vm.delete']) !!}
                {!! Form::hidden('expire', 0, ['ng-value'=>'vm.expire']) !!}
                <div class="form" ng-if="vm.IsDisplayForm || vm.IsEdit">
                    @include('admin.model.company.address_partial_fields', ['address' => $contactAddress])
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a href="#" ng-click="vm.hideForm();$event.preventDefault();" class="btn btn-default btn-cancel">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
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
                    @foreach($contact->addresses()->get() as $item)
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
                                <a href="{{ route('admin_get_item', ['model' => $config->getOption('name'), 'id' => $model->id, 'contact_id' => $contact->id, 'contact_address_id' => $item->id]) }}" class="btn btn-xs btn-sd-default btn-edit">
                                    Edit
                                </a>
                                <a href="#" class="btn btn-xs btn-sd-default btn-delete"
                                   data-id="{{$item->id}}" ng-click="vm.deleteItem({{$item->id}}); $event.preventDefault();">
                                    Delete
                                </a>
                                <a href="#" class="btn btn-xs btn-sd-default btn-expire"
                                   data-id="{{$item->id}}" ng-click="vm.expireItem({{$item->id}}); $event.preventDefault();">
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
