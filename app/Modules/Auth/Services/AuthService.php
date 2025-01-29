<?php

namespace App\Modules\Auth\Services;

use PDOException;
use App\Support\JWTConfig;
use App\Modules\Auth\Repositories\AuthRepository;

class AuthService
{


    public function register($request): array
    {
        try {
            $hashedClave = password_hash($request->getClave(), PASSWORD_BCRYPT);
            return AuthRepository::create($request->getUsuario(), $hashedClave, $request->getRol());
        } catch (PDOException $e) {
            throw new \Exception('Error al registrar el usuario. Inténtalo más tarde.');
        }
    }

    public function update($request): bool
    {
        try {
            $hashedClave = password_hash($request->getClave(), PASSWORD_BCRYPT);
            return AuthRepository::update($request->getUsuario(), $hashedClave, $request->getId(), $request->getRol());
        } catch (PDOException $e) {
            throw new \Exception('Error al actualizar el usuario. Inténtalo más tarde.');
        }
    }

    public function updateUser($request): bool
    {
        try {
            return AuthRepository::updateUser($request->getUsuario(), $request->getId(), $request->getRol());
        } catch (PDOException $e) {
            throw new \Exception('Error al actualizar el usuario. Inténtalo más tarde.');
        }
    }

    public function login($request): array
    {
        try {
            $user = AuthRepository::findUserByName($request->getUsuario());
            if (!$user) {
                throw new \Exception('Invalid credentials');
            }

            if (!password_verify($request->getClave(), $user['user']['clave'])) {
                throw new \Exception('Invalid credentials');
            }

            $token = JWTConfig::generateToken($user['user']['id']);

            AuthRepository::updateToken($user['user']['id'], $token);

            return ["token" => $token];
        } catch (PDOException $e) {
            throw new \Exception('Error en la base de datos: ' . $e->getMessage());
        }
    }



    public function logout($authHeader)
    {
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            throw new \Exception('Token not provided');
        }

        $token = $matches[1];
        $user = AuthRepository::ClearToken($token);

        if (!$user) {
            throw new \Exception('Invalid token or already logged out');
        }
    }


    public function me($authHeader)
    {
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            throw new \Exception('Token not provided');
        }

        $token = $matches[1];
        $user = AuthRepository::findUserByToken($token);

        if (!$user) {
            throw new \Exception('Invalid token or user not found');
        }
        return $user;
    }

    public function permisos($authHeader, $key)
    {
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            throw new \Exception('Token not provided');
        }

        $token = $matches[1];
        $permisos = AuthRepository::findUserPermissions($token, $key);        
        
        return $permisos;
    }
}
