<?php

namespace App\Repository\Otp;

use App\Models\otpCode;
use App\Repository\Otp\IOtpRepository;

class OtpRepository implements IOtpRepository
{
    private $otp;
    public function __construct(otpCode $otp)
    {
        return $this->otp = $otp;
    }

    public function create($data)
    {
        return $this->otp->create($data);
    }

    public function where($data)
    {
        return $this->otp->where('user', 'exists', ['email', $data])->first();
    }

    public function delete($data)
    {
        $data = $this->where($data);
        return $data->delete();
    }
}
