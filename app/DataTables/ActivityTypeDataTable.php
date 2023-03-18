<?php

namespace App\DataTables;

use App\Models\ActivityType;
use Yajra\DataTables\Services\DataTable;

class ActivityTypeDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($activityType) {
                $edit = '<a href="' . url('admin/settings/edit-activity-type/' . $activityType->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/settings/delete-activity-type/' . $activityType->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="glyphicon glyphicon-trash"></i></a>';
                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = ActivityType::query();
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'name', 'name' => 'activity_types.name', 'title' => 'Name'])
            ->addColumn(['data' => 'description', 'name' => 'activity_types.description', 'title' => 'Description'])
            ->addColumn(['data' => 'status', 'name' => 'activity_types.status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }

    protected function filename()
    {
        return 'activitytypedatatables_' . time();
    }
}
