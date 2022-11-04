<?php

namespace App\Repository\userAgreement;

interface IUserAgreementRepository {
    public function create($data);
    public function where($data);
    public function delete();
}
