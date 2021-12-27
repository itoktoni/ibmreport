<x-date :array="['date']" />

<div class="form-group">

    <label class="col-md-2 col-sm-2 control-label">From Date</label>
    <div class="col-md-4">
        <div class="input-group">
            <input type="text" name="from" value="{{ request()->get('from') ?? date('Y-m-d') }}" class="date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>

    <label class="col-md-2 col-sm-2 control-label">To Date</label>
    <div class="col-md-4">
        <div class="input-group">
            <input type="text" name="to" value="{{ request()->get('to') ?? date('Y-m-d') }}" class="date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', __('Customer'), ['class' => 'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-md-4 col-sm-4 {{ $errors->has('customer_id') ? 'has-error' : ''}}">
        {{ Form::select('customer_id', $customer, request()->get('customer_id') ?? null, ['class'=> 'form-control ']) }}
        {!! $errors->first('customer_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', __('Sales'), ['class' => 'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-md-4 col-sm-4 {{ $errors->has('email') ? 'has-error' : ''}}">
        {{ Form::select('email', $sales, request()->get('email') ?? null, ['class'=> 'form-control ']) }}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', __('Status'), ['class' => 'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-md-4 col-sm-4 {{ $errors->has('order_status') ? 'has-error' : ''}}">
        {{ Form::select('order_status', $status, request()->get('order_status') ?? null, ['class'=> 'form-control ']) }}
        {!! $errors->first('order_status', '<p class="help-block">:message</p>') !!}
    </div>
</div>


@isset($preview)

<hr>
@includeIf(Views::form(request()->get('name'), $template, $folder))

@endif