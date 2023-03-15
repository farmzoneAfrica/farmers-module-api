<?php

namespace App\Http\Controllers;

use App\Models\LocalGovernment;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = $request->limit ?? '-1';
        $pageStart = \Request::get('page', 1);
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField ?? 'id';
        $dir = $request->SortType ?? 'asc';

        $states = State::where('id', 1)->where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('name', 'LIKE', "%{$request->search}%");
            });
        });

        $totalRows = $states->count();
        if($perPage == "-1") $perPage = $totalRows;

        $states = $states->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'states' => $states,
            'totalRows' => $totalRows,
        ]);
    }


    /**
     * @param Request $request
     * @param string $state_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function lgas(Request $request, string $state_id): \Illuminate\Http\JsonResponse
    {
        $perPage = $request->limit ?? '-1';
        $pageStart = \Request::get('page', 1);
        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField ?? 'id';
        $dir = $request->SortType ?? 'asc';

        $lgas = LocalGovernment::where('state_id', '=', $state_id) ->where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('name', 'LIKE', "%{$request->search}%");
            });
        });

        $totalRows = $lgas->count();
        if($perPage == "-1") $perPage = $totalRows;

        $lgas = $lgas->offset($offSet)
            ->limit($perPage)
            ->orderBy($order, $dir)
            ->get();

        return response()->json([
            'lgas' => $lgas,
            'totalRows' => $totalRows,
        ]);
    }
}
