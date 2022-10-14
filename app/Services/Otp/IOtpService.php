<?php

namespace App\Services\Otp;

interface IOtpService {
    public function createOtp($request);
    public function whereOtp($request);
    public function verifyEmail($user, $otp, $request);
    public function deleteOtp($request);
}
