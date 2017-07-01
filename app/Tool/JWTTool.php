<?php

namespace App\Tool;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class JWTTool{
    const KEY = 'dawndevil';

    public static function build($username, $is_teacher){
        $signer = new Sha256();
        $token = (new Builder())->setIssuer('https://www.seeonce.cn') // Configures the issuer (iss claim)
                          ->setAudience('https://www.seeonce.cn') // Configures the audience (aud claim)
                          ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                          ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                          ->setNotBefore(time()) // Configures the time that the token can be used (nbf claim)
                          ->setExpiration(time() + 3600) // Configures the expiration time of the token (nbf claim)
                          ->set('username', $username) // Configures a new claim, called "uid"
                          ->set('is_teacher', $is_teacher) // Configures a new claim, called "uid"
                          ->sign(new Sha256(), self::KEY)
                          ->getToken(); // Retrieves the generated token

        return (string)$token;
    }

    public static function verify($token_str){
        $token = (new Parser())->parse($token_str);

        return $token->verify(new Sha256(), self::KEY);
    }

    public static function decode($token_str){
        $token = (new Parser())->parse($token_str);

        return [
          'username' => $token->getClaim('username'),
          'is_teacher' => $token->getClaim('is_teacher')
        ];
    }
}
