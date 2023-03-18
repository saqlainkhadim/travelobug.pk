<?php

namespace App\DataTables;

use App\Models\StartingCities;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SettingAddressesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editUrl = url('admin/settings/edit-address/' . $row->id);
                $editButton = '<a href="' . $editUrl . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>';
                $deleteUrl = url('admin/settings/delete-address/' . $row->id);
                $deleteButton = '<a href="' . $deleteUrl . '" class="btn btn-xs btn-danger delete-warning"><i class="glyphicon glyphicon-trash"></i></a>';
                return "{$editButton}&nbsp;{$deleteButton}";
            })
            ->editColumn('name', function ($row) {
                $editUrl = url('admin/settings/edit-address/' . $row->id);
                return '<a href="' . $editUrl . '">' . $row->name . '</a>';
            })
            ->rawColumns(['action', 'name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DailyEarningBalance $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StartingCities $model)
    {
        return $model
            ->select('id', 'name', 'image')
            ->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('starting-cities-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Blfrtip')
            ->orderBy(1)
            ->lengthChange(true)
            ->lengthMenu([10, 25, 50, 100])
            ->buttons(
                Button::make('print'),
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex')->title('#')->addClass('text-center'),
            Column::make('name', 'name')->title('Name'),
            Column::computed('action')->title('Action')->addClass('text-center')->exportable(false)->printable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'starting_cities_' . date('YmdHis');
    }
}
