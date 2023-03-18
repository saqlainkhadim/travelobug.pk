<?php

namespace App\DataTables;

use App\Models\Properties;
use Yajra\DataTables\Services\DataTable;
use App\Http\Helpers\Common;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivitiesAddRequestsDataTable extends DataTable
{
    public function ajax()
    {
        $activities = $this->query();
        return datatables()->of($activities)
            ->addColumn('action', function ($activity) {
                $approveUrl = url("admin/listing-activity/{$activity->id}/approve");
                $rejectUrl = url("admin/listing-activity/{$activity->id}/reject");
                $approve = "<a class='btn btn-xs btn-primary approve' href='$approveUrl' onclick=\"return confirm('Are you sure?')\"><i class='glyphicon glyphicon-ok'></i></a>";
                $reject = "<a class='btn btn-xs btn-danger reject' href='$rejectUrl' onclick=\"return confirm('Are you sure?')\"><i class='glyphicon glyphicon-remove'></i></a>";
                return "{$approve} {$reject}";
            })
            ->addColumn('host_name', function ($activity) {
                return '<a href="' . url('admin/edit-customer/' . $activity->host_id) . '">' . ucfirst($activity->user->first_name) . '</a>';
            })
            ->addColumn('name', function ($activity) {
                return '<a href="' . route('activity.listing', [$activity->id, 'basics']) . '">' . ucfirst($activity->name) . '</a>';
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
            ->rawColumns(['host_name', 'name', 'action'])
            ->make(true);
    }

    public function query()
    {
        $query = Activity::with(['user:id,first_name,profile_image'])
            ->where('approved', 0);
        // ->where('status', 'listed');

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'Id'])
            ->addColumn(['data' => 'name', 'name' => 'ame', 'title' => 'Name'])
            ->addColumn(['data' => 'host_name', 'name' => 'user.first_name', 'title' => 'Host Name'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status'])
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
