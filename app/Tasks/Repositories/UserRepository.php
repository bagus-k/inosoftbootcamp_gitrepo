<?php

namespace App\Tasks\Repositories;

use App\Helpers\MongoModel;

class UserRepository
{
    private MongoModel $users;
	public function __construct()
	{
		$this->users = new MongoModel('users');
	}

	/**
	 * Untuk mendapatkan user bedasarkan id
	 *  */
	public function getById(string $id)
	{
		$user = $this->users->find(['_id'=>$id]);
		return $user;
	}

    public function getByEmail(string $email)
	{
		$user = $this->users->find(['email'=>$email]);
		return $user;
	}

	/**
	 * Untuk membuat user
	 */
	public function create(array $data)
	{
		$dataSaved = [
			'name'=>$data['name'],
			'email'=>$data['email'],
			'password'=>$data['password'],
			'created_at'=>time()
		];

		$id = $this->users->save($dataSaved);
		return $id;
	}

	/**
	 * Untuk menyimpan user baik untuk membuat baru atau menyimpan dengan struktur bson secara bebas
	 *  */
	public function save(array $editedData)
	{
		$id = $this->users->save($editedData);
		return $id;
	}

    public function generateToken(array $user)
    {
        $token = auth() -> attempt($user);
        return $token;
    }
}