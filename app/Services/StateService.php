<?php


namespace App\Services;


use App\Models\LocalGovernment;
use App\Models\State;
use App\Models\Ward;
use Illuminate\Http\Request;

class StateService extends BaseService
{
    public function states(Request $request)
    {
        $states = State::where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('name', 'LIKE', "%{$request->search}%");
            });
        });

        $totalRows = $states->count();
        if($this->perPage == "-1") $this->perPage = $totalRows;

        $states = $states->offset($this->offSet)
            ->limit($this->perPage)
            ->orderBy($this->order, $this->dir)
            ->get();

        return $this->sendResponse([
            'states'=>$states,
            'totalRows' => $totalRows,
        ]);
    }

    public function lgas(Request $request, $state_id)
    {
        $lgas = LocalGovernment::where('state_id', '=', $state_id) ->where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('name', 'LIKE', "%{$request->search}%");
            });
        });

        $totalRows = $lgas->count();
        if($this->perPage == "-1") $this->perPage = $totalRows;

        $lgas = $lgas->offset($this->offSet)
            ->limit($this->perPage)
            ->orderBy($this->order, $this->dir)
            ->get();

        return $this->sendResponse([
            'lgas' => $lgas,
            'totalRows' => $totalRows,
        ]);
    }

    public function wards(Request $request, $lga_id)
    {
        $wards = Ward::where('local_government_id', '=', $lga_id) ->where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('name', 'LIKE', "%{$request->search}%");
            });
        });

        $totalRows = $wards->count();
        if($this->perPage == "-1") $this->perPage = $totalRows;

        $wards = $wards->offset($this->offSet)
            ->limit($this->perPage)
            ->orderBy($this->order, $this->dir)
            ->get();

        return $this->sendResponse([
            'wards' => $wards,
            'totalRows' => $totalRows,
        ]);
    }
}
