<div class="ibox">
    <div class="ibox-title">
        <h5>Contacts
            <small>Information</small>
        </h5>
        <div class="ibox-tools">
            <button id="add-contact" class="btn btn-xs btn-primary" ng-click="vm.addNew()">Add Contact</button>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open([
                        'class'   => 'form-horizontal form-contact',
                        'enctype' => 'multipart/form-data',
                        'route'   => ['admin_save_item',$config->getOption('name'),$itemId]
                    ]) !!}
                    {!! Form::hidden('contact_id', isset($contact) ? $contact->id : null) !!}
                    <input name="mode" type="hidden" value="contact" autocomplete="off">
                    {!! Form::hidden('delete', 0, ['ng-value'=>'vm.delete']) !!}
                <div class="form" ng-if="vm.IsDisplayForm || vm.IsEdit">
                    @include('admin.model.company.contact_partial_fields')
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a href="#" ng-click="vm.hideForm(); $event.preventDefault();" class="btn btn-default btn-cancel">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($model->contacts()->get() as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->sorted_name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->category->name}}</td>
                            <td>
                                <a href="{{ route('admin_get_item', ['model' => $config->getOption('name'), $itemId, 'contact_id' => $item->id]) }}" class="btn btn-xs btn-sd-default btn-edit">
                                    Edit
                                </a>
                                <a href="#" class="btn btn-xs btn-sd-default btn-delete"
                                   data-id="{{$item->id}}" ng-click="vm.deleteItem({{$item->id}}); $event.preventDefault();">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
