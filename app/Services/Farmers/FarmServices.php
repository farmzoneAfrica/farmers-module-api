<?php

namespace App\Services\Farmers;

use App\Http\Requests\Farmers\CreateFarmPostRequest;
use App\Models\Crop;
use App\Models\CropStatus;
use App\Models\Farm;
use App\Models\FarmCrop;
use App\Models\FarmSizeUnit;
use Illuminate\Http\Request;

class FarmServices extends \App\Services\BaseService
{
    public function createFarm(CreateFarmPostRequest $request)
    {
        $data = $request->all();
        $farm_data = [
            'user_id' => auth()->user()->id,
            'name'=>$data['name'],
            'location_address'=>$data['location_address'],
            'longitude'=>$data['longitude'],
            'latitude'=>$data['latitude'],
            'size'=>$data['size'],
            'farm_size_unit_id'=>$data['size_unit'],
            'status'=>$data['status'],
        ];

        $farm = Farm::create($farm_data);

        //submit farm data to db
        $crops = $data['crops'];
        $farm_crops_data = [];
        foreach ($crops as $crop) {
            $crops_data = [
                'user_id' => auth()->user()->id,
                'farm_id' => $farm->id,
                'crop_id' => $crop['crop'],
                'crop_status_id' => $crop['status'],
                'last_changed' => now(),
            ];
            $farm_crops_data[] = FarmCrop::create($crops_data);
        }

        $farm = [
            'farm'=>$farm,
            'crops'=>$farm_crops_data
        ];

        return $this->sendResponse($farm, 'Farm created successfully');
    }

    public function userFarmsList(Request $request)
    {
        $farms = Farm::where('user_id', auth()->user()->id)->where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('name', 'LIKE', "%{$request->search}%");
            });
        })->where(function ($query) use ($request) {
            return $query->when($request->filled('farm_id'), function ($query) use ($request) {
                return $query->whereId($request->farm_id);
            });
        })->latest();

        $totalRows = $farms->count();
        if($this->perPage == "-1") $this->perPage = $totalRows;

        $farms_list = $farms->offset($this->offSet)
            ->limit($this->perPage)
            ->orderBy($this->order, $this->dir)
            ->get();

        $farm_data = [];
        foreach ($farms_list as $farm) {
            $crops_list = FarmCrop::where('farm_id', $farm->id)->get();
            $farm_data[] = [
                'id' => $farm->id,
                'user_id' => $farm->user_id,
                'name'=> $farm->name,
                "latitude" => $farm->latitude,
                "longitude" => $farm->longitude,
                "location_address" => $farm->location_address,
                "landmark" => $farm->landmark,
                "size" => $farm->size,
                "size_unit" => FarmSizeUnit::whereId($farm->farm_size_unit_id)->first()->name,
                "status" => $farm->status,
                "created_at" => $farm->created_at,
                "updated_at" => $farm->updated_at,
                "crops" => $crops_list
            ];
        }

        return $this->sendResponse([
            'farms'=>$farm_data,
            'totalRows' => $totalRows,
        ]);
    }
}
