<?php

namespace App\Services;

use App\Models\Crop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CropsService extends BaseService
{
    public function cropsList(Request $request): JsonResponse
    {
        $crops = Crop::where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                $query->where('status', '=', $request->status);
                return $query->where('name', 'LIKE', "%{$request->search}%");
            });
        });

        $totalRows = $crops->count();
        if($this->perPage == "-1") $this->perPage = $totalRows;

        $crops_list = $crops->offset($this->offSet)
            ->limit($this->perPage)
            ->orderBy($this->order, $this->dir)
            ->get();

        return $this->sendResponse([
            'farm_size_units'=>$crops_list,
            'totalRows' => $totalRows,
        ]);
    }
}
