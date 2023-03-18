@extends('admin.template')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Activities
                <small>Add Requests</small>
            </h1>
            @include('admin.common.breadcrumb')
        </section>

        <!-- Main content -->
        <section class="content">
            <!--Filtering Box Start -->

            <!--Filtering Box End -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Activities Add Requests</h3>
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('activity.amenities') }}">View Amenities</a>
                                @if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'add_properties'))
                                <a class="btn btn-success" href="{{ route('activity.add') }}">Add Activities</a>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                {!! $dataTable->table(['class' => 'table table-striped table-hover dt-responsive', 'width' => '100%', 'cellspacing' => '0']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('public/backend/plugins/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/Responsive-2.2.2/js/dataTables.responsive.min.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endpush

@section('validate_script')
    <script type="text/javascript">
        // Date Time range picker for filter
        $(function() {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            dateRangeBtn(startDate, endDate, dt = 1);
            formDate(startDate, endDate);

            $(document).ready(function() {
                $('#dataTableBuilder_length').after(
                    `<div id="exportArea" class="col-md-4 col-sm-4 ">
                        <div class="btn btn-group btn-refresh">
                            <a href="" id="tablereload" class="form-control">
                                <span><i class="fa fa-refresh"></i></span>
                            </a>
                        </div>
                    </div>`
                );
            });

            //reload Datatable
            $(document).on("click", "#tablereload", function(event) {
                event.preventDefault();
                $("#dataTableBuilder").DataTable().ajax.reload();
            });
        });
    </script>
@endsection
