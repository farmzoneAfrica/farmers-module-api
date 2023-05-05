<?php

namespace App\Services\Farmers;

use App\Models\FarmSizeUnit;
use App\Services\BaseService;
use Illuminate\Http\Request;

class FarmSizeUnitService extends BaseService
{
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
