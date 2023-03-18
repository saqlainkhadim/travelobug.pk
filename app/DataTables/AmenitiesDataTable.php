<?php

/**
 * AmenitiesData Data Table
 *
 * AmenitiesData Data Table handles AmenitiesData datas.
 *
 * @category   AmenitiesData
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @link       http://techvill.net
 * @since      Version 1.3
 */

namespace App\DataTables;

use App\Models\Amenities;
use Yajra\DataTables\Services\DataTable;

class AmenitiesDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($amenities) {

                $edit = '<a href="' . url('admin/edit-amenities/' . $amenities->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/delete-amenities/' . $amenities->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="glyphicon glyphicon-trash"></i></a>';
                return $edit . ' ' . $delete;
            })
            ->editColumn('symbol', function ($amenity) {
                $symbol = "<i class=\"icon h3 icon-{$amenity->symbol}\" aria-hidden=\"true\"></i>";
                if (file_exists(public_path('images/symbols/' . $amenity->symbol))) {
                    $symbol_url = asset('public/images/symbols/' . $amenity->symbol);
                    $symbol = "<img src=\"$symbol_url\" height='20' />";
                }
                return $symbol;
            })
            ->rawColumns(['action', 'symbol'])
            ->make(true);
    }

    public function query()
    {
        $query = Amenities::select();

        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'title', 'name' => 'amenities.title', 'title' => 'Name'])
            ->addColumn(['data' => 'description', 'name' => 'amenities.description', 'title' => 'Description'])
            ->addColumn(['data' => 'symbol', 'name' => 'amenities.symbol', 'title' => 'Symbol'])
            ->addColumn(['data' => 'status', 'name' => 'amenities.status', 'title' => 'Status'])
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
        return 'amenitiesdatatables_' . time();
    }
}
