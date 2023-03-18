@extends('admin.template')
@push('css')
    <style>
        input[readonly] {
            background-color: #f5f5f5 !important;
        }
    </style>
@endpush
@section('main')
    <div class="content-wrapper">
        <section class="content">
            @include('admin.customerdetails.customer_menu')
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ 'Payment methods' }}</h3>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-footer">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table class="table-striped table" id="payout_methods">
                                                    @if (count($payouts))
                                                        <thead>
                                                            <tr class="text-truncate">
                                                                <th>Methods</th>
                                                                <th>Details/Account</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($payouts as $row)
                                                                <tr>
                                                                    <td>
                                                                        {{ $row->payment_methods->name }}
                                                                        @if ($row->selected == 'Yes')
                                                                            <span class="label label-info">Default</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        {{ $row->account_number }} ({{ $row->account_name }})
                                                                    </td>

                                                                    <td>
                                                                        {{ 'Ready' }}
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-primary btn-xs" type="button" data-toggle="modal" data-target="#viewModal{{ $row->id }}">View</button>
                                                                        <div class="modal fade" tabindex="-1" role="dialog" id="viewModal{{ $row->id }}">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header" style="border:0px solid #fff">
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <h4 class="modal-title">Payment Account Details</h4>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="row p-4">
                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group">
                                                                                                    <label for="exampleInputPassword1">Payout method</label>
                                                                                                    <input type="text" class="form-control" name="payout_type" value="{{ $row->payment_methods->name }}" readonly>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-6" id="bank">
                                                                                                <div class="form-group">
                                                                                                    <label for="exampleInputPassword1">Bank Name</label>
                                                                                                    <input type="text" class="form-control" name="bank_name" id="bank_name" value="{{ $row->bank_name }}" readonly>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-6" id="acc_holder">
                                                                                                <div class="form-group">
                                                                                                    <label for="exampleInputPassword1">Account Holder Name</label>
                                                                                                    <input type="text" class="form-control" name="bank_account_holder_name" id="bank_account_holder_name" value="{{ $row->account_name }}" readonly>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-6" id="branch">
                                                                                                <div class="form-group">
                                                                                                    <label for="exampleInputPassword1">Branch Name</label>
                                                                                                    <input type="text" class="form-control" name="branch_name" id="branch_name" value="{{ $row->bank_branch_name }}" readonly>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-6" id="acc_number">
                                                                                                <div class="form-group">
                                                                                                    <label for="exampleInputPassword1">Account Number/IBAN</label>
                                                                                                    <input type="text" class="form-control" name="bank_account_number" id="bank_account_number" value="{{ $row->account_number }}" readonly>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-6" id="branch_c">
                                                                                                <div class="form-group">
                                                                                                    <label for="exampleInputPassword1">Branch City</label>
                                                                                                    <input type="text" class="form-control" name="branch_city" id="branch_city" value="{{ $row->bank_branch_city }}" readonly>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-6" id="branch_ad">
                                                                                                <div class="form-group">
                                                                                                    <label for="exampleInputPassword1">Branch Address</label>
                                                                                                    <input type="text" class="form-control" name="branch_address" id="branch_address" value="{{ $row->bank_branch_address }}" readonly>
                                                                                                </div>
                                                                                            </div>



                                                                                            <div class="col-md-6" id="country_id">
                                                                                                <div class="form-group">
                                                                                                    <label for="exampleInputPassword1" class="control-label">Country</label>
                                                                                                    <input class="form-control" name="country" id="country" readonly="" value="Pakistan">
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-6 d-none" id="email_id">
                                                                                                <div class="form-group">
                                                                                                    <label for="exampleInputPassword1">PayPal Email ID</label>
                                                                                                    <input type="email" class="form-control" name="email" value="" required="">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer"  style="border:0px solid #fff">
                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                    </div>
                                                                                </div><!-- /.modal-content -->
                                                                            </div><!-- /.modal-dialog -->
                                                                        </div><!-- /.modal -->
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    @else
                                                        <tr><span>No data available</span></tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
