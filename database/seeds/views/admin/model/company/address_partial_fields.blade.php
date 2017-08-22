<div class="form-group {{$errors->has('street') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="street">
        Street <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        {!! Form::text('street', isset($address) ? $address->street : null, ['class'=>'form-control']) !!}
        @if ($errors->has('street'))<p style="color:red;">{!!$errors->first('street')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('suburb') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="suburb">
        Suburb/Location/District
    </label>
    <div class="col-md-10">
        {!! Form::text('suburb', isset($address) ? $address->suburb : null, ['class'=>'form-control']) !!}
        @if ($errors->has('suburb'))<p style="color:red;">{!!$errors->first('suburb')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('city') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="city">
        City
    </label>
    <div class="col-md-10">
        {!! Form::text('city', isset($address) ? $address->city : null, ['class'=>'form-control']) !!}
        @if ($errors->has('city'))<p style="color:red;">{!!$errors->first('city')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('state_name') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="state_name">
        State Name
    </label>
    <div class="col-md-10">
        {!! Form::text('state_name', isset($address) ? $address->state_name : null, ['class'=>'form-control']) !!}
        @if ($errors->has('state_name'))<p style="color:red;">{!!$errors->first('state_name')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('postal_code') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="postal_code">
        Postal code
    </label>
    <div class="col-md-10">
        {!! Form::text('postal_code', isset($address) ? $address->postal_code : null, ['class'=>'form-control']) !!}
        @if ($errors->has('postal_code'))<p style="color:red;">{!!$errors->first('postal_code')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('country_code') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="country_code">
        Country <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        {!! Form::select('country_code', ['' => 'Choose a Country...']+$countryList, isset($address) ? $address->country_code : null, ['class'=>'form-control chosen-select']) !!}
        @if ($errors->has('country_code'))<p style="color:red;">{!!$errors->first('country_code')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('contact_name') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="contact_name">
        Contact Name
    </label>
    <div class="col-md-10">
        {!! Form::text('contact_name', isset($address) ? $address->contact_name : null, ['class'=>'form-control']) !!}
        @if ($errors->has('contact_name'))<p style="color:red;">{!!$errors->first('contact_name')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('contact_phone') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="contact_phone">
        Contact Phone
    </label>
    <div class="col-md-10">
        {!! Form::text('contact_phone', isset($address) ? $address->contact_phone : null, ['class'=>'form-control']) !!}
        @if ($errors->has('contact_phone'))<p style="color:red;">{!!$errors->first('contact_phone')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{$errors->has('address_type') ? 'has-error' : null}}">
            <label class="col-md-4 control-label" for="address_type">
                Address Type <span class="text-danger">*</span>
            </label>
            <div class="col-md-8">
                {!! Form::select('address_type',['' => 'Choose a Type...'] + $addressTypeList, isset($address) ? $address->pivot->address_type : null, ['class'=>'form-control chosen-select']) !!}
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
                {!! Form::select('status',['' => 'Choose a Status...'] + $addressStatusList, isset($address) ? $address->pivot->status : null, ['class'=>'form-control chosen-select']) !!}
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
                    {!! Form::text('start_date', (isset($address) && $address->pivot->start_date != '0000-00-00') ? $address->pivot->start_date : null, ['class'=> 'form-control', 'id'=>'start_date']) !!}
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
                    {!! Form::text('end_date', (isset($address) && $address->pivot->end_date != '0000-00-00') ? $address->pivot->end_date : null, ['class'=> 'form-control', 'id'=>'end_date']) !!}
                </div>
                @if ($errors->has('end_date'))
                    <p class="text-danger">{!!$errors->first('end_date')!!}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="hr-line-dashed"></div>
