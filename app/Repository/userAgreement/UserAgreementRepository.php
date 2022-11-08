<?php

namespace App\Repository\userAgreement;

use App\Models\User;
use App\Models\userAgreement;
use App\Repository\User\IUserRepository;

class UserAgreementRepository implements IUserAgreementRepository
{
    private $userAgreement;
    public function __construct(userAgreement $userAgreement)
    {
        return $this->userAgreement = $userAgreement;
    }

    public function create($data)
    {
        return $this->userAgreement->create($data);
    }

    public function whereOne($store, $user)
    {
        // return $this->userAgreement->where("user", "exists", ["email", $email])->first();
        return $this->userAgreement->where(
        [
            "store_id" => $store,
            "user_id" => $user
        ])->first();
    }

    public function delete($userAgreement)
    {
        return $userAgreement->delete();
    }
}
