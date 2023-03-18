@extends('admin.template')
@section('main')
<div class="content-wrapper">
      <!-- Main content -->
<section class="content-header">
    <h1>
        Description
        <small>Description</small>
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="{{url('/')}}/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a>
      </li>
    </ol>
</section>

<section class="content">
    <div class="col-md-3 settings_bar_gap">
      @include('admin.activities.activity_bar')
    </div>

  <div class="col-md-9">

  <form method="post" action="{{url('admin/activity/listing/'.$result->id.'/'.$step)}}" class='signup-form login-form' accept-charset='UTF-8'>
    {{ csrf_field() }}
    <div class="box box-info">
    <div class="box-body">

      <div class="row">
        <div class="col-md-8">
          <h4>{{trans('messages.listing_description.neighborhood')}}</h4>
          <label class="label-large">{{trans('messages.listing_description.detail')}} {{trans('messages.listing_description.description')}}</label>
          <textarea class="form-control" name="description" rows="4" placeholder="">{{ $result->description->description }}</textarea>
        </div>
      </div>

      <br>
      <div class="row mt20">
        <div class="col-md-6 text-left">
            <a data-prevent-default="" href="{{ url('admin/activity/listing/'.$result->id.'/description') }}" class="btn btn-large btn-primary">{{trans('messages.listing_description.back')}}</a>
        </div>
        <div class="col-md-6 text-right">
          <button type="submit" class="btn btn-large btn-primary next-section-button">
          {{trans('messages.listing_basic.next')}}
          </button>
        </div>
      </div>
    </div>
  </div>

  </form>

  </section>
    <div class="clearfix"></div>
</div>
@stop
