<?php

namespace App\Services\User;

interface IUserService {
    public function createUser($request);
    public function whereUser($request);
    public function updateUser($user, $request);
    public function checkPassword($user, $request);
    public function sendMail($user, $otp);
    public function saveUser($user);
    public function logoutUser();
}
