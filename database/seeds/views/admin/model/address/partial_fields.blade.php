<div class="form-group {{$errors->has('street') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="street">
        Street <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        {!! Form::text('street', null, ['class'=>'form-control']) !!}
        @if ($errors->has('street'))<p style="color:red;">{!!$errors->first('street')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('suburb') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="suburb">
        Suburb/Location/District
    </label>
    <div class="col-md-10">
        {!! Form::text('suburb', null, ['class'=>'form-control']) !!}
        @if ($errors->has('suburb'))<p style="color:red;">{!!$errors->first('suburb')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('city') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="city">
        City
    </label>
    <div class="col-md-10">
        {!! Form::text('city', null, ['class'=>'form-control']) !!}
        @if ($errors->has('city'))<p style="color:red;">{!!$errors->first('city')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('state_name') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="state_name">
        State Name
    </label>
    <div class="col-md-10">
        {!! Form::text('state_name', null, ['class'=>'form-control']) !!}
        @if ($errors->has('state_name'))<p style="color:red;">{!!$errors->first('state_name')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('postal_code') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="postal_code">
        Postal code
    </label>
    <div class="col-md-10">
        {!! Form::text('postal_code', null, ['class'=>'form-control']) !!}
        @if ($errors->has('postal_code'))<p style="color:red;">{!!$errors->first('postal_code')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('country_code') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="country_code">
        Country <span class="text-danger">*</span>
    </label>
    <div class="col-md-10">
        {!! Form::select('country_code',['' => 'Choose a Country...']+$countryList, null, ['class'=>'form-control chosen-select']) !!}
        @if ($errors->has('country_code'))<p style="color:red;">{!!$errors->first('country_code')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('contact_name') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="contact_name">
        Contact Name
    </label>
    <div class="col-md-10">
        {!! Form::text('contact_name', null, ['class'=>'form-control']) !!}
        @if ($errors->has('contact_name'))<p style="color:red;">{!!$errors->first('contact_name')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="form-group {{$errors->has('contact_phone') ? 'has-error' : null}}">
    <label class="col-md-2 control-label" for="contact_phone">
        Contact Phone
    </label>
    <div class="col-md-10">
        {!! Form::text('contact_phone', null, ['class'=>'form-control']) !!}
        @if ($errors->has('contact_phone'))<p style="color:red;">{!!$errors->first('contact_phone')!!}</p>@endif
    </div>
</div>
<div class="hr-line-dashed"></div>
