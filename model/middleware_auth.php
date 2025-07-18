<?php

    class middleware{

    public static function decode_token($token){
        $jwt = parse_ini_file(UTILS . 'jwt.ini');
        $secret = $jwt['JWT_SECRET'];

        $JWT = new JWT;
        $token_dec = $JWT->decode($token, $secret);
        $rt_token = json_decode($token_dec, TRUE);
        return $rt_token;
    }

    public static function create_token($username){
        $jwt = parse_ini_file(UTILS . 'jwt.ini');
        $header = $jwt['JWT_HEADER'];
        $secret = $jwt['JWT_SECRET'];
        $payload = '{"iat":"' . time() . '","exp":"' . time() + (600) . '","username":"' . $username . '"}';

        $JWT = new JWT;
        $token = $JWT->encode($header, $payload, $secret);
        return $token;
    }

    public static function create_token_provider($username, $provider){
        $jwt = parse_ini_file(UTILS . 'jwt.ini');
        $header = $jwt['JWT_HEADER'];
        $secret = $jwt['JWT_SECRET'];
        $payload = '{"iat":"' . time() . '","exp":"' . time() + (600) . '","username":"' . $username . '","provider":"' . $provider . '"}';

        $JWT = new JWT;
        $token = $JWT->encode($header, $payload, $secret);
        return $token;
    }

    public static function create_token_2h($param){
        $jwt = parse_ini_file(UTILS . 'jwt.ini');
        $header = $jwt['JWT_HEADER'];
        $secret = $jwt['JWT_SECRET'];
        $payload = '{"iat":"' . time() . '","exp":"' . time() + (7200) . '","username":"' . $param . '"}';

        $JWT = new JWT;
        $token = $JWT->encode($header, $payload, $secret);
        return $token;
    }

    public static function decode_username($get_token){
		$jwt = parse_ini_file(UTILS . "jwt.ini");
		$secret = $jwt['secret'];
		$token = $get_token;

		$JWT = new JWT;
		$json = $JWT -> decode($token, $secret);
		$json = json_decode($json, TRUE);

        $decode_user = $json['name'];
        return $decode_user;
    }

	public static function decode_exp($get_token){
		$jwt = parse_ini_file(UTILS . "jwt.ini");
		$secret = $jwt['secret'];
		$token = $get_token;

		$JWT = new JWT;
		$json = $JWT -> decode($token, $secret);
		$json = json_decode($json, TRUE);

        $decode_exp = $json['exp'];
        return $decode_exp;
    }

    } // middleware