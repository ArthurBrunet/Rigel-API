<?php


namespace App\Service;


class JWTService {

    private const ONE_HOUR = 3600;

    public function getToken($fullToken) {
        return substr($fullToken,7);
    }

    public function decodeToken($fullToken) {
        $token = $this->getToken($fullToken);
        $tokenParts = explode(".", $token);
        $tokenPayload = base64_decode($tokenParts[1]);
        return json_decode($tokenPayload);
    }

    public function getRole($fullToken) {
        $jwtPayload = $this->decodeToken($fullToken);
        return $jwtPayload->roles;
    }

    public function checkIfAdmin($fullToken) {
        $roles = $this->getRole($fullToken);
        if (in_array("ROLE_ADMIN", $roles))
            return true;
        else
            return false;
    }

    public function getUsername($fullToken) {
        $jwtPayload = $this->decodeToken($fullToken);
        return $jwtPayload->username;
    }

    public function checkIfTokenValid($fullToken) {
        $jwtPayload = $this->decodeToken($fullToken);
        if ($jwtPayload->iat + self::ONE_HOUR <= $jwtPayload->exp) {
            return false;
        } else {
            return true;
        }
    }
}