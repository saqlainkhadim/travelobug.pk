<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;
use App\Http\Helpers\Common as Helpers;

class CustomerDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($users) {

                $edit = Helpers::has_permission(Auth::guard('admin')->user()->id, 'edit_customer') ? '<a href="' . url('admin/edit-customer/' . $users->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;' : '';

                return $edit;
            })
            ->editColumn('first_name', function ($users) {
                return '<a href="' . url('admin/edit-customer/' . $users->id) . '">' . ucfirst($users->first_name) . '</a>';
            })
            ->editColumn('last_name', function ($users) {
                return '<a href="' . url('admin/edit-customer/' . $users->id) . '">' . ucfirst($users->last_name) . '</a>';
            })
            ->editColumn('formatted_phone', function ($users) {
                if ($users->formatted_phone == '') return '-';
                return '<a href="' . url('admin/edit-customer/' . $users->id) . '">' . $users->formatted_phone . '</a>';
            })
            ->editColumn('is_verified', function ($user) {
                $approved_status = '';
                if (!$user->is_verified) {
                    $approved_status = '<a class="btn btn-danger p-1 btn-xs" href="' . url("admin/verify-customer/{$user->id}") . '" title="Click to Approve">' . trans('Unverified') . '</a>';
                } else {
                    $approved_status = '<span class="label bg-primary"><i class="fa fa-shield mr-3"></i> ' . trans('Verified') . '</span>';
                }
                return $approved_status;
            })
            ->addColumn('created_at', function ($users) {
                return dateFormat($users->created_at);
            })
            ->rawColumns(['first_name', 'last_name', 'formatted_phone', 'action', 'is_verified'])
            ->make(true);
    }

    public function query()
    {
        $status   = isset(request()->status) ? request()->status : null;
        $from     = isset(request()->from) ? setDateForDb(request()->from) : null;
        $to       = isset(request()->to) ? setDateForDb(request()->to) : null;
        $customer = isset(request()->customer) ? request()->customer : null;

        $query    = User::select();

        if (!empty($from)) {
            $query->whereDate('created_at', '>=', $from);
        }
        if (!empty($to)) {
            $query->whereDate('created_at', '<=', $to);
        }
        if (!empty($status)) {
            $query->where('status', '=', $status);
        }
        if (!empty($customer)) {
            $query->where('id', '=', $customer);
        }

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'ID'])

            ->addColumn(['data' => 'first_name', 'name' => 'first_name', 'title' => 'First Name'])
            ->addColumn(['data' => 'last_name', 'name' => 'last_name', 'title' => 'Last Name'])
            ->addColumn(['data' => 'formatted_phone', 'name' => 'formatted_phone', 'title' => 'Phone'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => 'Email'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false])
            ->addColumn(['data' => 'is_verified', 'name' => 'is_verified', 'title' => 'Verification', 'orderable' => true, 'searchable' => false])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }


    protected function filename()
    {
        return 'customersdatatables_' . time();
    }
}
