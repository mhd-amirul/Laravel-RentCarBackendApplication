<?php

namespace App\Services\userAgreement;

use App\Helpers\arrNested;
use App\Helpers\ResponseFormatter;
use App\Repository\userAgreement\IUserAgreementRepository;
use Exception;

class UserAgreementService implements IUserAgreementService
{
    private $userAgreementRepository;
    public function __construct(IUserAgreementRepository $userAgreementRepository)
    {
        return $this->userAgreementRepository = $userAgreementRepository;
    }

    public function whereUserAgreementOne($store, $user)
    {
        try {
            return $this->userAgreementRepository->whereOne($store, $user);
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "whereUserAgreement");
        }
    }

    public function createUserAgreement($request, $store)
    {
        try {
            $data = $request->all();
            $data["user_id"] = $store["user_id"];
            $data["store_id"] = $store["_id"];
            $data["status"] = $request->status;
            $data["description"] = "this user agree with our condition and term";
            return $this->userAgreementRepository->create($data);
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "createUserAgreement");
        }
    }

    public function deleteUserAgreement($store)
    {
        try {
            $userAgreement = $this->userAgreementRepository->whereOne($store["_id"], $store["user_id"]);
            return $this->userAgreementRepository->delete($userAgreement);
        } catch (Exception $th) {
            return ResponseFormatter::throwErr($th, "deleteUserAgreement");
        }
    }
}
