<?php

namespace App\DataTables;

use App\Models\ActivityAmenity;
use Yajra\DataTables\Services\DataTable;

class ActivityAmenitiesDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($amenity) {
                $edit = '<a href="' . url('admin/activity/edit-amenity/' . $amenity->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/activity/delete-amenity/' . $amenity->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="glyphicon glyphicon-trash"></i></a>';
                return $edit . ' ' . $delete;
            })
            ->editColumn('symbol', function ($amenity) {
                $symbolUrl = asset('public/images/symbols/' . $amenity->symbol);
                return "<img src='$symbolUrl' width='20px'/>";
            })
            ->rawColumns(['action', 'symbol'])
            ->make(true);
    }

    public function query()
    {
        $query = ActivityAmenity::select();

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'title', 'name' => 'activity_amenities.title', 'title' => 'Name'])
            ->addColumn(['data' => 'description', 'name' => 'activity_amenities.description', 'title' => 'Description'])
            ->addColumn(['data' => 'symbol', 'name' => 'activity_amenities.symbol', 'title' => 'Symbol'])
            ->addColumn(['data' => 'status', 'name' => 'activity_amenities.status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }

    protected function getColumns()
    {
        return [
            'id',
            'created_at',
            'updated_at',
        ];
    }

    protected function filename()
    {
        return 'amenities_datatables_' . time();
    }
}
