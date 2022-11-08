<?php

namespace App\Repository\userAgreement;

interface IUserAgreementRepository {
    public function create($data);
    public function whereOne($store, $user);
    public function delete($userAgremeent);
}
