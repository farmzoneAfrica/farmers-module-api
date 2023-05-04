<?php

namespace App\Services;

use App\Models\Crop;
use App\Models\CropStatus;
use App\Models\FarmCrop;
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
            'crops'=>$crops_list,
            'totalRows' => $totalRows,
        ]);
    }

    public function cropStatuses(Request $request)
    {
        $crops_statuses = CropStatus::where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                $query->where('status', '=', $request->status);
                return $query->where('name', 'LIKE', "%{$request->search}%");
            });
        });

        $totalRows = $crops_statuses->count();
        if($this->perPage == "-1") $this->perPage = $totalRows;

        $crops_statuses_list = $crops_statuses->offset($this->offSet)
            ->limit($this->perPage)
            ->orderBy($this->order, $this->dir)
            ->get();

        return $this->sendResponse([
            'crop_statuses'=>$crops_statuses_list,
            'totalRows' => $totalRows,
        ]);
    }

    public function farmCropsList(Request $request)
    {
        $farm_crops = FarmCrop::where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                $query->where('farm_id', '=', $request->farm_id);
                $query->where('crop_id', '=', $request->crop_id);
                $query->where('crop_status_id', '=', $request->crop_status_id);
                return $query->where('name', 'LIKE', "%{$request->search}%");
            });
        });

        $totalRows = $farm_crops->count();
        if($this->perPage == "-1") $this->perPage = $totalRows;

        $farm_crops_list = $farm_crops->offset($this->offSet)
            ->limit($this->perPage)
            ->orderBy($this->order, $this->dir)
            ->get();

        return $this->sendResponse([
            'crop_statuses'=>$farm_crops_list,
            'totalRows' => $totalRows,
        ]);
    }
}
