<?php


namespace App\Services\Auth;


use App\Events\FarmerRegistered;
use App\Http\Controllers\BaseController;
use App\Http\Requests\FarmerRegisterRequest;
use App\Models\User;

class FarmerRegisterServices extends BaseController
{
    public function register(FarmerRegisterRequest $request)
    {
        $user = User::updateOrCreate(
            ['phone' => $request->phone],
            [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'state_id' => $request->state_id,
            'local_government_id' => $request->local_government_id,
            'ward_id' => $request->ward_id,
            'user_type_id'=>1
        ]);

        FarmerRegistered::dispatch($user);
        return $this->sendResponse($user, 'Registration successfully');
    }
}
