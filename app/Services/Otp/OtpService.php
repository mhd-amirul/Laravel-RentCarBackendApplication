<?php

namespace App\Services\Otp;

use App\Helpers\ResponseFormatter;
use App\Repository\Otp\IOtpRepository;
use App\Services\Otp\IOtpService;
use Carbon\Carbon;

class OtpService implements IOtpService
{
    private $otpRepository;
    public function __construct(IOtpRepository $otpRepository)
    {
        return $this->otpRepository = $otpRepository;
    }

    public function createOtp($request)
    {
        try {
            $data = [
                "email" => $request->email,
                "otp" => rand(1000, 9999)
            ];
            return $this->otpRepository->create($data);
        } catch (\Exception $th) {
            throw ResponseFormatter::throwErr();
        }
    }

    public function whereOtp($request)
    {
        try {
            return $this->otpRepository->where($request);
        } catch (\Exception $th) {
            throw ResponseFormatter::throwErr();
        }
    }

    public function verifyEmail($user, $otp, $request)
    {
        try {
            if ($user) {
                if ($otp && $user->email == $otp->email && $otp->otp == $request->otp) {
                    return [
                        "status" => "success",
                        "data" => Carbon::now()
                    ];
                } else {
                    return [ "status" => "otpfail" ];
                }
            } else {
                return [ "status" => "userfail" ];
            }
        } catch (\Exception $th) {
            throw ResponseFormatter::throwErr();
        }
    }

    public function deleteOtp($request)
    {
        try {
            return $this->otpRepository->delete($request);
        } catch (\Exception $th) {
            throw ResponseFormatter::throwErr();
        }
    }
}
