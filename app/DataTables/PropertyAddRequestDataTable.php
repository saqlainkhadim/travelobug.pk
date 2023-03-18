<?php

namespace App\DataTables;

use App\Models\Properties;
use Yajra\DataTables\Services\DataTable;
use App\Http\Helpers\Common;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class PropertyAddRequestDataTable extends DataTable
{
    public function ajax()
    {
        $properties = $this->query();
        return datatables()
            ->of($properties)
            ->addColumn('action', function ($properties) {
                $approveUrl = url("admin/listing-property/{$properties->id}/approve");
                $rejectUrl = url("admin/listing-property/{$properties->id}/reject");
                $approve = "<a class='btn btn-xs btn-primary approve' href='$approveUrl' onclick=\"return confirm('Are you sure?')\"><i class='glyphicon glyphicon-ok'></i></a>";
                $reject = "<a class='btn btn-xs btn-danger reject' href='$rejectUrl' onclick=\"return confirm('Are you sure?')\"><i class='glyphicon glyphicon-remove'></i></a>";
                return $approve . $reject;
            })
            ->addColumn('host_name', function ($properties) {
                return '<a href="' . url('admin/edit-customer/' . $properties->host_id) . '">' . ucfirst($properties->users->first_name) . '</a>';
            })
            ->addColumn('name', function ($properties) {
                return '<a href="' . url('admin/listing/' . $properties->id . '/basics') . '">' . ucfirst($properties->name) . '</a>';
            })
            ->addColumn('created_at', function ($properties) {
                return dateFormat($properties->created_at);
            })
            ->addColumn('recomended', function ($properties) {
                if ($properties->recomended == 1) {
                    return 'Yes';
                }
                return 'No';
            })
            ->editColumn('category', function ($row) {
                return $row->category ? propertyCategory($row->category) : '-';
            })
            ->rawColumns(['host_name', 'name', 'action'])
            ->make(true);
    }

    public function query()
    {
        $user_id    = Request::segment(4);
        $status     = isset(request()->status) ? request()->status : null;
        $from = isset(request()->from) ? setDateForDb(request()->from) : null;
        $to = isset(request()->to) ? setDateForDb(request()->to) : null;
        $space_type = isset(request()->to) ? setDateForDb(request()->to) : null;

        $query = Properties::with(['users:id,first_name,profile_image'])
            ->where('approved', 0);
        // ->where('status', 'listed');
        if (isset($user_id)) {
            $query->where('host_id', '=', $user_id);
        }
        if (!request()->has('reset_btn')) {
            if (request('category')) {
                $query->where('category', '=', request('category'));
            }
            if ($from) {
                $query->whereDate('created_at', '>=', $from);
            }
            if ($to) {
                $query->whereDate('created_at', '<=', $to);
            }
            if ($status) {
                $query->where('status', '=', $status);
            }
            if ($space_type) {
                $query->where('space_type', '=', $space_type);
            }
        }
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'Id'])
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Name'])
            ->addColumn(['data' => 'host_name', 'name' => 'users.first_name', 'title' => 'Host Name'])
            ->addColumn(['data' => 'category', 'name' => 'category', 'title' => 'Category'])
            ->addColumn(['data' => 'space_type_name', 'name' => 'space_type_name', 'title' => 'Space Type'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status'])
            ->addColumn(['data' => 'recomended', 'name' => 'recomended', 'title' => 'Recomended'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => 'Date'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }


    protected function filename()
    {
        return 'property_datatables_' . time();
    }
}
