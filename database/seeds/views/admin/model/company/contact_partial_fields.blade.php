<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('first_name') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="first_name">
        First Name <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        <?php
            $firstName = old('first_name', isset($contact) ? $contact->first_name : null);
        ?>
        {!! Form::text('first_name', $firstName, ['class'=>'form-control', 'ng-model'=>'vm.form.first_name', 'ng-init'=>'vm.initFieldValue("first_name", "' . $firstName . '")']) !!}
        @if ($errors->has('first_name'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('first_name') ? 'has-error' : null}}')">{!!$errors->first('first_name')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('last_name') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="last_name">
        Last Name <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        <?php
            $lastName = old('last_name', isset($contact) ? $contact->last_name : null);
        ?>
        {!! Form::text('last_name', $lastName, ['class'=>'form-control', 'ng-model'=>'vm.form.last_name', 'ng-init'=>'vm.initFieldValue("last_name", "' . $lastName . '")']) !!}
        @if ($errors->has('last_name'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('last_name') ? 'has-error' : null}}')">{!!$errors->first('last_name')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('email') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="email">
        Email <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        <?php
            $email = old('email', isset($contact) ? $contact->email : null);
        ?>
        {!! Form::text('email', $email, ['class'=>'form-control', 'ng-model'=>'vm.form.email', 'ng-init'=>'vm.initFieldValue("email", "' . $email . '")']) !!}
        @if ($errors->has('email'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('email') ? 'has-error' : null}}')">{!!$errors->first('email')!!}</p>@endif
    </div>
</div>

<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('category_id') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="category_id">
        Type <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        <?php
            $categoryId = old('category_id', isset($contact) ? $contact->category_id : null);
        ?>
        <select class="form-control" name="category_id" select2 ng-model="vm.form.category_id" ng-init="vm.initFieldValue('category_id', '{{$categoryId }}')">
            <option value="">Please select</option>
            @foreach($contactCategories as $id => $value)
                <option value="{{ $id }}" {{ $categoryId == $id ? 'selected' : null }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('category_id'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('category_id') ? 'has-error' : null}}')">{!!$errors->first('category_id')!!}</p>@endif
    </div>
</div>

<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('position') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="position">
        Position
    </label>
    <div class="col-md-10">
        <?php
            $position = old('position', isset($contact) ? $contact->position : null);
        ?>
        {!! Form::text('position', $position, ['class'=>'form-control', 'ng-model'=>'vm.form.position', 'ng-init'=>'vm.initFieldValue("position", "' . $position . '")']) !!}
        @if ($errors->has('position'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('position') ? 'has-error' : null}}')">{!!$errors->first('position')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('phone') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="phone">
        Phone
    </label>
    <div class="col-md-10">
        <?php
            $phone = old('phone', isset($contact) ? $contact->phone : null);
        ?>
        {!! Form::text('phone', $phone, ['class'=>'form-control', 'ng-model'=>'vm.form.phone', 'ng-init'=>'vm.initFieldValue("phone", "' . $phone . '")']) !!}
        @if ($errors->has('phone'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('phone') ? 'has-error' : null}}')">{!!$errors->first('phone')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('mobile') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="mobile">
        Mobile Phone
    </label>
    <div class="col-md-10">
        <?php
            $mobile = old('mobile', isset($contact) ? $contact->mobile : null);
        ?>
        {!! Form::text('mobile', $mobile, ['class'=>'form-control', 'ng-model'=>'vm.form.mobile', 'ng-init'=>'vm.initFieldValue("mobile", "' . $mobile . '")']) !!}
        @if ($errors->has('mobile'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('mobile') ? 'has-error' : null}}')">{!!$errors->first('mobile')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('fax') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="fax">
        Fax
    </label>
    <div class="col-md-10">
        <?php
            $fax = old('fax', isset($contact) ? $contact->fax : null);
        ?>
        {!! Form::text('fax', $fax, ['class'=>'form-control', 'ng-model'=>'vm.form.fax', 'ng-init'=>'vm.initFieldValue("fax", "' . $fax . '")']) !!}
        @if ($errors->has('fax'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('fax') ? 'has-error' : null}}')">{!!$errors->first('fax')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('timezone') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="timezone">
        Time Zone
    </label>
    <div class="col-md-10">
        <?php
            $timezone = old('timezone', isset($contact) ? $contact->timezone : null);
        ?>
        {!! Form::text('timezone', $timezone, ['class'=>'form-control', 'ng-model'=>'vm.form.timezone', 'ng-init'=>'vm.initFieldValue("timezone", "' . $timezone . '")']) !!}
        @if ($errors->has('timezone'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('timezone') ? 'has-error' : null}}')">{!!$errors->first('timezone')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('notes') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="notes">
        Notes
    </label>
    <div class="col-md-10">
        <?php
            $notes = old('notes', isset($contact) ? $contact->notes : null);
        ?>
        {!! Form::textarea('notes', $notes, ['class'=>'form-control', 'ng-model'=>'vm.form.notes', 'ng-init'=>'vm.initFieldValue("notes", "' . $notes . '")']) !!}
        @if ($errors->has('notes'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('notes') ? 'has-error' : null}}')">{!!$errors->first('notes')!!}</p>@endif
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
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('extended_data') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="extended_data">
        Extended Data
    </label>
    <div class="col-md-10">
        {!! Form::hidden('extended_data', $tmpValue, ['id'=>'contact_extended_data', 'ng-init'=>'vm.initFieldValue("extended_data", "' . $tmpValue . '")', 'ng-model'=>'vm.form.extended_data', 'ng-value'=>'vm.form.extended_data']) !!}
        <div ng-jsoneditor ng-model="vm.form.extended_data" options="{mode: 'tree', modes: ['code', 'form', 'text', 'tree', 'view']}" prefer-text="true" style="height: 400px;"></div>
        @if ($errors->has('extended_data'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('extended_data') ? 'has-error' : null}}')">{!!$errors->first('extended_data')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
