<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('street') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="street">
        Street <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        <?php
            $street = old('street', isset($address) ? $address->street : null);
        ?>
        {!! Form::text('street', $street, ['class'=>'form-control', 'ng-model'=>'vm.form.street', 'ng-init'=>'vm.initFieldValue("street", "' . $street . '")']) !!}
        @if ($errors->has('street'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('street') ? 'has-error' : null}}')">{!!$errors->first('street')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('suburb') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="suburb">
        Suburb/Location/District
    </label>
    <div class="col-md-10">
        <?php
            $suburb = old('suburb', isset($address) ? $address->suburb : null);
        ?>
        {!! Form::text('suburb', $suburb, ['class'=>'form-control', 'ng-model'=>'vm.form.suburb', 'ng-init'=>'vm.initFieldValue("suburb", "' . $suburb . '")']) !!}
        @if ($errors->has('suburb'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('suburb') ? 'has-error' : null}}')">{!!$errors->first('suburb')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('city') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="city">
        City
    </label>
    <div class="col-md-10">
        <?php
            $city = old('city', isset($address) ? $address->city : null);
        ?>
        {!! Form::text('city', $city, ['class'=>'form-control', 'ng-model'=>'vm.form.city', 'ng-init'=>'vm.initFieldValue("city", "' . $city . '")']) !!}
        @if ($errors->has('city'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('city') ? 'has-error' : null}}')">{!!$errors->first('city')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('state_name') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="state_name">
        State Name
    </label>
    <div class="col-md-10">
        <?php
            $stateName = old('state_name', isset($address) ? $address->state_name : null);
        ?>
        {!! Form::text('state_name', $stateName, ['class'=>'form-control', 'ng-model'=>'vm.form.state_name', 'ng-init'=>'vm.initFieldValue("state_name", "' . $stateName . '")']) !!}
        @if ($errors->has('state_name'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('state_name') ? 'has-error' : null}}')">{!!$errors->first('state_name')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('postal_code') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="postal_code">
        Postal code
    </label>
    <div class="col-md-10">
        <?php
            $postalCode = old('postal_code', isset($address) ? $address->postal_code : null);
        ?>
        {!! Form::text('postal_code', $postalCode, ['class'=>'form-control', 'ng-model'=>'vm.form.postal_code', 'ng-init'=>'vm.initFieldValue("postal_code", "' . $postalCode . '")']) !!}
        @if ($errors->has('postal_code'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('postal_code') ? 'has-error' : null}}')">{!!$errors->first('postal_code')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('country_code') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="country_code">
        Country <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        <?php
            $countryCode = old('country_code', isset($address) ? $address->country_code : null);
        ?>
        {!! Form::select('country_code', ['' => 'Choose a Country...']+$countryList, $countryCode, ['class'=>'form-control chosen-select', 'ng-model'=>'vm.form.country_code', 'ng-init'=>'vm.initFieldValue("country_code", "' . $countryCode . '")']) !!}
        @if ($errors->has('country_code'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('country_code') ? 'has-error' : null}}')">{!!$errors->first('country_code')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('contact_name') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="contact_name">
        Contact Name
    </label>
    <div class="col-md-10">
        <?php
            $contactName = old('contact_name', isset($address) ? $address->contact_name : null);
        ?>
        {!! Form::text('contact_name', $contactName, ['class'=>'form-control', 'ng-model'=>'vm.form.contact_name', 'ng-init'=>'vm.initFieldValue("contact_name", "' . $contactName . '")']) !!}
        @if ($errors->has('contact_name'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('contact_name') ? 'has-error' : null}}')">{!!$errors->first('contact_name')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('contact_phone') ? 'has-error' : null}}')}">
    <label class="col-md-2 control-label" for="contact_phone">
        Contact Phone
    </label>
    <div class="col-md-10">
        <?php
            $contactPhone = old('contact_phone', isset($address) ? $address->contact_phone : null);
        ?>
        {!! Form::text('contact_phone', $contactPhone, ['class'=>'form-control', 'ng-model'=>'vm.form.contact_phone', 'ng-init'=>'vm.initFieldValue("contact_phone", "' . $contactPhone . '")']) !!}
        @if ($errors->has('contact_phone'))<p class="text-danger" ng-if="vm.showError('{{$errors->has('contact_phone') ? 'has-error' : null}}')">{!!$errors->first('contact_phone')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('address_type') ? 'has-error' : null}}')}">
            <label class="col-md-4 control-label" for="address_type">
                Address Type <span class="text-danger">*</span>
            </label>
            <div class="col-md-8">
                <?php
                    $addressType = old('address_type', isset($address) ? $address->pivot->address_type : null);
                ?>
                {!! Form::select('address_type',['' => 'Choose a Type...'] + $addressTypeList, $addressType, ['class'=>'form-control chosen-select', 'ng-model'=>'vm.form.pivot.address_type', 'ng-init'=>'vm.initFieldValue("pivot.address_type", "' . $addressType . '")']) !!}
                @if ($errors->has('address_type'))
                    <p class="text-danger" ng-if="vm.showError('{{$errors->has('address_type') ? 'has-error' : null}}')">{!!$errors->first('address_type')!!}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('status') ? 'has-error' : null}}')}">
            <label class="col-md-4 control-label" for="status">
                Address Status <span class="text-danger">*</span>
            </label>
            <div class="col-md-8">
                <?php
                    $addressStatus = old('status', isset($address) ? $address->pivot->status : null);
                ?>
                {!! Form::select('status',['' => 'Choose a Status...'] + $addressStatusList, $addressStatus, ['class'=>'form-control chosen-select', 'ng-model'=>'vm.form.pivot.status', 'ng-init'=>'vm.initFieldValue("pivot.status", "' . $addressStatus . '")']) !!}
                @if ($errors->has('status'))
                    <p class="text-danger" ng-if="vm.showError('{{$errors->has('status') ? 'has-error' : null}}')">{!!$errors->first('status')!!}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('start_date') ? 'has-error' : null}}')}">
            <label class="col-md-4 control-label" for="start_date">
                Start Date
            </label>
            <div class="col-md-8">
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <?php
                        $startDate = old('start_date', (isset($address) && $address->pivot->start_date != '0000-00-00') ? $address->pivot->start_date : null);
                    ?>
                    {!! Form::text('start_date', $startDate, ['class'=> 'form-control date-picker', 'id'=>'start_date', 'ng-model'=>'vm.form.pivot.start_date', 'ng-init'=>"vm.initFieldValue('pivot.start_date', '" . $startDate . "')"]) !!}
                </div>
                @if ($errors->has('start_date'))
                    <p class="text-danger" ng-if="vm.showError('{{$errors->has('start_date') ? 'has-error' : null}}')">{!!$errors->first('start_date')!!}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group" ng-class="{'has-error': vm.showError('{{$errors->has('end_date') ? 'has-error' : null}}')}">
            <label class="col-md-4 control-label" for="end_date">
                End Date
            </label>
            <div class="col-md-8">
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <?php
                        $endDate = old('start_date', (isset($address) && $address->pivot->end_date != '0000-00-00') ? $address->pivot->end_date : null);
                    ?>
                    {!! Form::text('end_date', $endDate, ['class'=> 'form-control date-picker', 'id'=>'end_date', 'ng-model'=>'vm.form.pivot.end_date', 'ng-init'=>"vm.initFieldValue('pivot.end_date', '" . $endDate . "')"]) !!}
                </div>
                @if ($errors->has('end_date'))
                    <p class="text-danger" ng-if="vm.showError('{{$errors->has('end_date') ? 'has-error' : null}}')">{!!$errors->first('end_date')!!}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="hr-line-dashed"></div>
