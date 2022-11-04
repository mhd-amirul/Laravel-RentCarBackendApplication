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

    public function where($data)
    {
        return $this->userAgreement->where("user", "exists", ["email", $data])->first();
    }

    public function delete()
    {
        $this->userAgreement = $this->where(auth()->user()->email);
        return $this->userAgreement->delete();
    }
}
