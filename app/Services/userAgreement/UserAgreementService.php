<?php

namespace App\Services\userAgreement;

use App\Helpers\arrNested;
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
        return $this->userAgreementRepository->where($request);
    }

    public function createUserAgreement($request)
    {
        $data = $request->all();
        $data["user"] = arrNested::userInformation(auth()->user());
        $data["status"] = $request->status;
        $data["description"] = "This user agree with our user service and privacy term";
        return [
            "section" => 1,
            "data" => $this->userAgreementRepository->create($data)
        ];
    }
}
