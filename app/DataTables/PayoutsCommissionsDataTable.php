<?php

namespace App\DataTables;

use App\Models\PropertyFees;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Services\DataTable;

class PayoutsCommissionsDataTable extends DataTable
{
    public function ajax()
    {
        $fees = PropertyFees::where('field', 'guest_service_charge')->first();
        $serviceCharge = $fees->value ?? 0;

        return datatables()
            ->eloquent($this->query())
            ->addColumn('payment_method_id', function ($withDrawal) {
                if ($withDrawal->payment_method_id == 4) {

                    return 'Bank';
                } else {
                    return 'PayPal';
                }
            })

            ->addColumn('user_id', function ($withDrawal) {
                $userName = ucfirst(isset($withDrawal->user->first_name) ? $withDrawal->user->first_name : ' ') . ' ' . ucfirst(isset($withDrawal->user->last_name) ? $withDrawal->user->last_name : '');
                return $userName;
            })

            ->addColumn('created_at', function ($withDrawal) {
                return dateFormat($withDrawal->created_at);
            })


            ->addColumn('subtotal', function ($withDrawal) {
                if ($withDrawal->status == 'Success') {
                    $subtotal = $withDrawal->amount;
                } else {
                    $subtotal = $withDrawal->subtotal;
                }
                return $subtotal;
            })
            ->addColumn('commission', function ($withDrawal) use ($serviceCharge) {
                $comm = 0;
                if ($withDrawal->status == 'Success') {
                    $comm = ($withDrawal->amount ?? 0) * ($serviceCharge && $serviceCharge != 0 ? ($serviceCharge / 100) : 0);
                }
                return number_format(round($comm, 2), 2);
            })
            ->addColumn('currency_id', function ($withDrawal) {
                $currency = $withDrawal->currency->code;
                return $currency;
            })
            ->addColumn('action', function ($withDrawal) {
                if ($withDrawal->status == 'Pending') {
                    return '<a href="' . url('admin/payouts/edit/' . $withDrawal->id) . '" class="btn btn-xs btn-primary" title="Edit payout"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
                } else {
                    return '<a href="' . url('admin/payouts/details/' . $withDrawal->id) . '" class="btn btn-xs btn-primary" title="Details"><i class="glyphicon glyphicon-tasks"></i></a>&nbsp;';
                }
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $from     = isset(request()->from) ? setDateForDb(request()->from) : null;
        $to       = isset(request()->to) ? setDateForDb(request()->to) : null;

        $user_id  = Request::segment(4);

        $query    = Withdrawal::query()->where('status', 'Success');
        if (isset($user_id)) {
            $query->where('user_id', '=', $user_id);
        }

        if (!empty($from)) {
            $query->whereDate('created_at', '>=', $from);
        }

        if (!empty($to)) {
            $query->whereDate('created_at', '<=', $to);
        }

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'ID', 'visible' => false])
            ->addColumn(['data' => 'user_id', 'name' => 'user_id', 'title' => 'User Name'])
            ->addColumn(['data' => 'currency_id', 'name' => 'currency_id', 'title' => 'Currency'])
            ->addColumn(['data' => 'payment_method_id', 'name' => 'payment_method_id', 'title' => 'Payment Method'])
            // ->addColumn(['data' => 'bank_name', 'name' => 'bank_name', 'title' => 'Bank Name'])
            ->addColumn(['data' => 'account_number', 'name' => 'account_number', 'title' => 'Account Number'])
            // ->addColumn(['data' => 'swift_code', 'name' => 'swift_code', 'title' => 'Swift Code'])
            ->addColumn(['data' => 'subtotal', 'name' => 'subtotal', 'title' => 'Amount'])
            ->addColumn(['data' => 'commission', 'name' => 'commission', 'title' => 'Commission'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])

            ->parameters(dataTableOptions());
    }


    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'payoutsdatatables_' . time();
    }
}
