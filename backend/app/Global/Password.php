<?php

namespace App\Globals;

class Password
{
    public string $error = '';
    protected object $user;

    /**
     * Check Password Requirements
     *
     * @param String $newPassword
     * @param String $passwordConfirm
     * @return boolean
     */
    public function verifyPassword(String $newPassword): bool
    {
        // Setup your Password Settings here
        $characters = [
            'logic' => 7,
            'required' => true,];
        $upperCase = [
            'logic' => preg_match('@[A-Z]@', $newPassword), 
            'required' => false];
        $lowerCase = [
            'logic' => preg_match('@[a-z]@', $newPassword),
            'required' => true];
        $oneNumber = [
            'logic' => preg_match('@[0-9]@', $newPassword),
            'required' => true];
        $specialChars = [
            'logic' => preg_match('@[^\w]@', $newPassword),
            'required' => false];

        return $this->checkPassword(
            $characters, 
            $upperCase, 
            $lowerCase, 
            $oneNumber, 
            $specialChars, 
            $newPassword, 
        );
    }

    private function checkPassword($characters, $upperCase, $lowerCase, $oneNumber, $specialChars, string $newPassword) {
        if((strlen($newPassword) < $characters['logic']) && ($characters['required'])) {
            $this->error = 'Password needs at least ' . $characters['logic'] . ' Characters';
            return false;
        } 
        elseif(!$upperCase['logic'] && $upperCase['required']) {
            $this->error = 'Password needs at least one Upper-Case letter';
            return false;
        } 
        elseif(!$lowerCase['logic'] && $lowerCase['required']) {
            $this->error = 'Password needs at least one Lower-Case letter';
            return false;
        } 
        elseif(!$oneNumber['logic'] && $oneNumber['required']) {
            $this->error = 'Password needs at least one Number';
            return false;
        } 
        elseif(!$specialChars['logic'] && $specialChars['required']) {
            $this->error = 'Password needs at least one Special-Character';
            return false;
        } 
        return true;
    }
}
