<?php

namespace App\Tasks\Services;

use App\Tasks\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;

	public function __construct() {
		$this->userRepository = new UserRepository();
	}
	
	/**
	 * NOTE: menambahkan task
	 */
	public function addUser(array $data)
	{
		$taskId = $this->userRepository->create($data);
		return $taskId;
	}

	/**
	 * NOTE: UNTUK mengambil data task
	 */
	public function getById(string $taskId)
	{
		$task = $this->userRepository->getById($taskId);
		return $task;
	}

    public function getByEmail(string $email)
	{
		$task = $this->userRepository->getByEmail($email);
		return $task;
	}

    public function generateToken(array $user)
    {
        $token = $this->userRepository->generateToken($user);
        return $token;
    }
}