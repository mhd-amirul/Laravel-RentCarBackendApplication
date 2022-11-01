<?php

namespace App\Services\userAgreement;

use App\Helpers\arrNested;
use App\Helpers\ResponseFormatter;
use App\Repository\userAgreement\IUserAgreementRepository;

class UserAgreementService implements IUserAgreementService
{
    private $userAgreementRepository;
    public function __construct(IUserAgreementRepository $userAgreementRepository)
    {
        return $this->userAgreementRepository = $userAgreementRepository;
    }

    public function whereUserAgreement($request)
    {
        try {
            return $this->userAgreementRepository->where($request);
        } catch (\Exception $th) {
            return ResponseFormatter::throwErr($th, "whereUserAgreement");
        }

    }

    public function createUserAgreement($request)
    {
        try {
            $data = $request->all();
            $data["user"] = arrNested::userInformation(auth()->user());
            $data["status"] = $request->status;
            $data["description"] = "this user agree with our condition and term";
            return $this->userAgreementRepository->create($data);
        } catch (\Exception $th) {
            return ResponseFormatter::throwErr($th, "createUserAgreement");
        }
    }
}
