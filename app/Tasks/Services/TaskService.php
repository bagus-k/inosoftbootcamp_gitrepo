<?php

namespace App\Tasks\Services;

use App\Tasks\Repositories\TaskRepository;

class TaskService {
	private TaskRepository $taskRepository;

	public function __construct() {
		$this->taskRepository = new TaskRepository();
	}

	/**
	 * NOTE: untuk mengambil semua tasks di collection task
	 */
	public function getTasks()
	{
		$tasks = $this->taskRepository->getAll();
		return $tasks;
	}

	/**
	 * NOTE: menambahkan task
	 */
	public function addTask(array $data)
	{
		$taskId = $this->taskRepository->create($data);
		return $taskId;
	}

	/**
	 * NOTE: UNTUK mengambil data task
	 */
	public function getById(string $taskId)
	{
		$task = $this->taskRepository->getById($taskId);
		return $task;
	}

	public function getByTitle(string $title)
	{
		$task = $this->taskRepository->getByTitle($title);
		return $task;
	}

    /**
	 * NOTE: untuk update task
	 */
	public function updateTask(array $editTask, array $formData)
	{
		if(isset($formData['title']))
		{
			$editTask['title'] = $formData['title'];
		}

		if(isset($formData['description']))
		{
			$editTask['description'] = $formData['description'];
		}

        if(isset($formData['assigned']))
		{
			$editTask['assigned'] = $formData['assigned'];
		}

		$id = $this->taskRepository->save( $editTask);
		return $id;
	}

	/**
	 * NOTE: untuk menghapus task
	 */
	public function deleteTask(string $taskId)
	{
		$id = $this->taskRepository->delete($taskId);
		return $id;
	}
}