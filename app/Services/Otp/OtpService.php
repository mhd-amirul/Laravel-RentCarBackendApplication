<?php

namespace App\Services\Otp;

use App\Helpers\arrNested;
use App\Helpers\ResponseFormatter;
use App\Repository\Otp\IOtpRepository;
use App\Services\Otp\IOtpService;
use Carbon\Carbon;
use Exception;

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
                "user" => arrNested::userInformation($request),
                "otp" => rand(1000, 9999)
            ];
            return $this->otpRepository->create($data);
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "createOtp");
        }
    }

    public function whereOtp($request)
    {
        try {
            return $this->otpRepository->where($request);
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "whereOtp");
        }
    }

    public function verifyEmail($user, $otp, $request)
    {
        try {
            if ($user) {
                if ($otp && $user->email == $otp["user"]["email"] && $otp->otp == $request->otp) {
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
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "verifyEmail");
        }
    }

    public function deleteOtp($request)
    {
        try {
            return $this->otpRepository->delete($request);
        } catch (Exception $th) {
            throw ResponseFormatter::throwErr($th, "deleteOtp");
        }
    }
}
