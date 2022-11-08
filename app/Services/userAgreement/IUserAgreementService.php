<?php

namespace App\Services\userAgreement;

interface IUserAgreementService {
    public function createUserAgreement($request, $store);
    public function whereUserAgreementOne($store, $user);
    public function deleteUserAgreement($store);
}
