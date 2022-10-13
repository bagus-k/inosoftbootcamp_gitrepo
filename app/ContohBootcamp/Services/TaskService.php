<?php

namespace App\ContohBootcamp\Services;

use App\ContohBootcamp\Repositories\TaskRepository;

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

	/**
	 * NOTE: untuk menambahkan assigntask
	 */
	public function assignTask(array $editTask, array $formData)
	{
		if(isset($formData['assigned']))
		{
			$editTask['assigned'] = $formData['assigned'];
		}

		$id = $this->taskRepository->save( $editTask);
		return $id;
	}

	/**
	 * NOTE: untuk menghapus assigntask
	 */
	public function unassignTask(array $editTask)
	{
		$editTask['assigned'] = null;
		$id = $this->taskRepository->save( $editTask);
		return $id;
	}

	/**
	 * NOTE: untuk membuat subtask
	 */
	public function createSubtask(array $editTask, array $formData)
	{
		$id = $this->taskRepository->createSubtask( $editTask,$formData);
		return $id;
	}

	/**
	 * NOTE: untuk menghapus subtask
	 */
	public function deleteSubtask(array $existTask, string $subtaskId)
	{
		$id = $this->taskRepository->deleteSubtask( $existTask,$subtaskId);
		return $id;
	}
}