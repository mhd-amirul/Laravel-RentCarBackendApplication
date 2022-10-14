<?php

namespace App\Repository\Otp;

interface IOtpRepository {
    public function create($data);
    public function where($data);
    public function delete($data);
}
