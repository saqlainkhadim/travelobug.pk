@extends('admin.template')
@section('main')
  <div class="content-wrapper">
  <!-- Main content -->
  <section class="content-header">
          <h1>
          List Your Activity
          <small>List Your Activity</small>
        </h1>
        <ol class="breadcrumb">
    <li><a href="{{url('/')}}/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
  </section>

    <section class="content">
    <div class="row">
        <div class="col-md-3 settings_bar_gap">
          @include('admin.activities.activity_bar')
        </div>
        <div class="col-md-9">
      <form method="post" action="{{url('admin/activity/listing/'.$result->id.'/'.$step)}}" class='signup-form login-form' accept-charset='UTF-8'>
      {{ csrf_field() }}
      <div class="box box-info">
      <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <h4>{{trans('messages.listing_basic.basic_info')}}</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label class="label-large">{{trans('messages.listing_basic.activity_type')}}</label>
              <select name="activity_type" data-saving="basics1" class="form-control">
                  @foreach($activity_type as $key => $value)
                    <option value="{{ $key }}" {{ ($key == $result->activity_type) ? 'selected' : '' }}>{{ $value }}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label class="label-large">Recomended</label>
              <select name="recomended" id="basics-select-recomended" class="form-control">
                  <option value="1" {{ ( $result->recomended == 1) ? 'selected' : '' }}>Yes</option>
                  <option value="0" {{ ( $result->recomended == 0) ? 'selected' : '' }}>No</option>
              </select>
            </div>
          </div>
          <div class="row">
          <br>
            <div class="col-md-12 text-right">
              <button type="submit" class="btn btn-large btn-primary next-section-button">
                {{trans('messages.listing_basic.next')}}
              </button>
            </div>
          </div>
        </div>
        </div>
        </div>
      </div>
    </form>
    </div>
    </section>
    <!-- /.content -->
 <div class="clearfix"></div>
    </div>
@stop
