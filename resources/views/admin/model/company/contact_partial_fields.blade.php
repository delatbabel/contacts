<div class="form-group {{$errors->has('first_name') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="first_name">
        First Name <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        {!! Form::text('first_name', old('first_name', isset($contact) ? $contact->first_name : null), ['class'=>'form-control']) !!}
        @if ($errors->has('first_name'))<p style="color:red;">{!!$errors->first('first_name')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('last_name') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="last_name">
        Last Name <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        {!! Form::text('last_name', old('last_name', isset($contact) ? $contact->last_name : null), ['class'=>'form-control']) !!}
        @if ($errors->has('last_name'))<p style="color:red;">{!!$errors->first('last_name')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('email') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="email">
        Email <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        {!! Form::text('email', old('email', isset($contact) ? $contact->email : null), ['class'=>'form-control']) !!}
        @if ($errors->has('email'))<p style="color:red;">{!!$errors->first('email')!!}</p>@endif
    </div>
</div>

<div class="form-group {{$errors->has('category_id') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="category_id">
        Type <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        <select class="form-control" name="category_id" select2>
            <option value="">Please select</option>
            @foreach($contactCategories as $id => $value)
                <option value="{{ $id }}" {{ old('category_id', isset($contact) ? $contact->category_id : null) == $id ? 'selected' : null }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('category_id'))<p style="color:red;">{!!$errors->first('category_id')!!}</p>@endif
    </div>
</div>

<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('position') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="position">
        Position
    </label>
    <div class="col-md-10">
        {!! Form::text('position', old('position', isset($contact) ? $contact->position : null), ['class'=>'form-control']) !!}
        @if ($errors->has('position'))<p style="color:red;">{!!$errors->first('position')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('phone') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="phone">
        Phone
    </label>
    <div class="col-md-10">
        {!! Form::text('phone', old('phone', isset($contact) ? $contact->phone : null), ['class'=>'form-control']) !!}
        @if ($errors->has('phone'))<p style="color:red;">{!!$errors->first('phone')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('mobile') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="mobile">
        Mobile Phone
    </label>
    <div class="col-md-10">
        {!! Form::text('mobile', old('mobile', isset($contact) ? $contact->mobile : null), ['class'=>'form-control']) !!}
        @if ($errors->has('mobile'))<p style="color:red;">{!!$errors->first('mobile')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('fax') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="fax">
        Fax
    </label>
    <div class="col-md-10">
        {!! Form::text('fax', old('fax', isset($contact) ? $contact->fax : null), ['class'=>'form-control']) !!}
        @if ($errors->has('fax'))<p style="color:red;">{!!$errors->first('fax')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('timezone') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="timezone">
        Time Zone
    </label>
    <div class="col-md-10">
        {!! Form::text('timezone', old('timezone', isset($contact) ? $contact->timezone : null), ['class'=>'form-control']) !!}
        @if ($errors->has('timezone'))<p style="color:red;">{!!$errors->first('timezone')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('notes') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="notes">
        Notes
    </label>
    <div class="col-md-10">
        {!! Form::textarea('notes', old('notes', isset($contact) ? $contact->notes : null), ['class'=>'form-control']) !!}
        @if ($errors->has('notes'))<p style="color:red;">{!!$errors->first('notes')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<?php
    $value = old('extended_data', isset($contact) ? $contact->extended_data : null);
    if (is_array($value)) {
        $tmpValue = json_encode($value);
    } elseif ($value instanceof \Illuminate\Contracts\Support\Arrayable) {
        $tmpValue = json_encode($value->toArray());
    } else {
        $tmpValue = json_encode([]);
    }
?>
<div class="form-group {{$errors->has('extended_data') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="extended_data">
        Extended Data
    </label>
    <div class="col-md-10">
        {!! Form::hidden('extended_data', $tmpValue, ['id'=>'contact_extended_data']) !!}
        <div id="jsoneditor_contact_extended_data" style="height: 400px;"></div>
        @if ($errors->has('extended_data'))<p style="color:red;">{!!$errors->first('extended_data')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
@section('javascript')
    @parent
    <script type="text/javascript">
        $(function () {
            var jsonString = {!! $tmpValue !!};
            var editorJSON = new JSONEditor(document.getElementById("jsoneditor_contact_extended_data"), {
                mode: 'tree',
                modes: ['code', 'form', 'text', 'tree', 'view'],
                onChange: function () {
                    var tmpJSON = editorJSON.get();
                    $("#jsoneditor_contact_extended_data").val(JSON.stringify(tmpJSON));
                }
            }, jsonString);
        });
    </script>
@endsection
