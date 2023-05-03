<?php

namespace App\Services;

use App\Http\Controllers\BaseController;
use App\Models\FarmSizeUnit;
use Illuminate\Http\Request;

class FarmSizeUnitService extends BaseController
{
    public string $perPage;
    public string $pageStart;
    public string $offSet;
    public string $order;
    public string $dir;

    public function __construct()
    {
        $this->perPage = \request()->limit ?? '-1';
        $this->pageStart = \Request::get('page', 1);
        $this->offSet = ($this->pageStart * $this->perPage) - $this->perPage;
        $this->order = $request->sort_field ?? 'id';
        $this->dir = $request->sort_type ?? 'asc';
    }

    public function farmSizeUnitList(Request $request): \Illuminate\Http\JsonResponse
    {
        $farm_size_units = FarmSizeUnit::where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('name', 'LIKE', "%{$request->search}%");
            });
        });

        $totalRows = $farm_size_units->count();
        if($this->perPage == "-1") $this->perPage = $totalRows;

        $farm_size_units = $farm_size_units->offset($this->offSet)
            ->limit($this->perPage)
            ->orderBy($this->order, $this->dir)
            ->get();

        return $this->sendResponse([
            'farm_size_units'=>$farm_size_units,
            'totalRows' => $totalRows,
        ]);
    }
}
