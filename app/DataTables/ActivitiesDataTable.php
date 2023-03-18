<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\Http\Helpers\Common;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivitiesDataTable extends DataTable
{
    public function ajax()
    {
        $activities = $this->query();
        return datatables()->of($activities)
            ->addColumn('action', function ($activity) {
                $edit = $delete = '';
                if (Common::has_permission(Auth::guard('admin')->user()->id, 'edit_properties')) {
                    $edit = '<a href="' . route('activity.listing', [$activity->id, 'basics'])  . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(Auth::guard('admin')->user()->id, 'delete_property')) {
                    $delete = '<a href="' . route('activity.delete', $activity->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="glyphicon glyphicon-trash"></i></a>';
                }
                return $edit . $delete;
            })
            ->addColumn('host_name', function ($activity) {
                return '<a href="' . url('admin/edit-customer/' . $activity->host_id) . '">' . ucfirst($activity->user->first_name) . '</a>';
            })
            ->addColumn('name', function ($activity) {
                return '<a href="' . route('activity.listing', [$activity->id, 'basics']) . '">' . ucfirst($activity->name) . '</a>';
            })
            ->addColumn('approved_btn', function ($activity) {
                $approved_status = '';
                if ($activity->approved == 0) {
                    $approved_status = '<a class="btn btn-danger p-1 btn-xs" href="' . route('activity.listing.approved.status', $activity->id) . '" title="Click to Approve">' . trans('Pending') . '</a>';
                } else {
                    $approved_status = '<span class="label bg-primary">' . trans('Approved') . '</span>';
                }
                return $approved_status;
            })
            ->addColumn('created_at', function ($activity) {
                return dateFormat($activity->created_at);
            })
            ->addColumn('recomended', function ($activity) {
                if ($activity->recomended == 1) {
                    return 'Yes';
                }
                return 'No';
            })
            ->rawColumns(['host_name', 'name', 'approved_btn', 'action'])
            ->make(true);
    }

    public function query()
    {
        $user_id    = Request::segment(4);
        $status     = isset(request()->status) ? request()->status : null;
        $from = isset(request()->from) ? setDateForDb(request()->from) : null;
        $to = isset(request()->to) ? setDateForDb(request()->to) : null;

        $query = Activity::with(['user:id,first_name,profile_image']);
        if (isset($user_id)) {
            $query->where('host_id', '=', $user_id);
        }
        if (!request()->has('reset_btn')) {
            if ($from) {
                $query->whereDate('created_at', '>=', $from);
            }
            if ($to) {
                $query->whereDate('created_at', '<=', $to);
            }
            if ($status) {
                $query->where('status', '=', $status);
            }
        }
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'Id'])
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Name'])
            ->addColumn(['data' => 'host_name', 'name' => 'user.first_name', 'title' => 'Host Name'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status'])
            ->addColumn(['data' => 'approved_btn', 'name' => 'approved', 'title' => 'Approve Status'])
            ->addColumn(['data' => 'recomended', 'name' => 'recomended', 'title' => 'Recomended'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => 'Date'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }


    protected function filename()
    {
        return 'propertydatatables_' . time();
    }
}
