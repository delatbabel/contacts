<div class="ibox">
    <div class="ibox-title">
        <h5>Contacts
            <small>Information</small>
        </h5>
        <div class="ibox-tools">
            <button id="add-contact" class="btn btn-xs btn-primary">Add Contact</button>
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open([
                        'class'   => 'form-horizontal form-contact',
                        'enctype' => 'multipart/form-data',
                        'route'   => ['admin_save_item',$config->getOption('name'),$itemId],
                    ]) !!}
                {!! Form::hidden('contact_id', isset($contact) ? $contact->id : null) !!}
                {!! Form::hidden('mode', 'contact') !!}
                {!! Form::hidden('delete', 0) !!}
                @include('admin.model.company.contact_partial_fields')
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
                        <th>Name</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($model->contacts()->get() as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->sorted_name}}</td>
                            <td>{{$item->category->name}}</td>
                            <td>
                                <a href="{{ route('admin_get_item', ['model' => $config->getOption('name'), $itemId, 'contact_id' => $item->id]) }}" class="btn btn-xs btn-sd-default btn-edit">
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
            var ContactHandle = function () {
                // Show form when there are errors
                var _mode = '{{old('mode', $mode)}}';
                var _hasError = {{count($errors)}};
                var _hasContact = {{ isset($contact) ? "true" : "false" }};
                var _addressForm = $(".form-contact");

                var HandlePlugins = function () {
                    // Chosen
                    $('.chosen-select').chosen({
                        width: '100%'
                    });
                };
                var ModeHandle = function () {
                    if (_mode == 'contact' && (_hasContact || _hasError)) {
                        _addressForm.show();
                    }
                    else {
                        _addressForm.hide();
                    }
                };
                var resetForm = function () {
                    $('input:hidden[name="contact_id"]', _addressForm).val(null);
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
                    $('#add-contact').click(function () {
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
                        if (!confirm('Do you want to remove this item ?')) {
                            return;
                        }
                        var objData = $(this).data();
                        $('input:hidden[name="delete"]', _addressForm).val(1);
                        $('input:hidden[name="address_id"]', _addressForm).val(objData.id);
                        _addressForm.submit();
                    });

                    // Handle expire action
                    $('.btn-expire').click(function () {
                        var objData = $(this).data();
                        $('input:hidden[name="expire"]', _addressForm).val(1);
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
            ContactHandle.init();
        });
    </script>
@endsection
