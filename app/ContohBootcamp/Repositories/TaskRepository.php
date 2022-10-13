<?php
namespace App\ContohBootcamp\Repositories;

use App\Helpers\MongoModel;

class TaskRepository
{
	private MongoModel $tasks;
	public function __construct()
	{
		$this->tasks = new MongoModel('tasks');
	}

	/**
	 * Untuk mengambil semua tasks
	 */
	public function getAll()
	{
		$tasks = $this->tasks->get([]);
		return $tasks;
	}

	/**
	 * Untuk mendapatkan task bedasarkan id
	 *  */
	public function getById(string $id)
	{
		$task = $this->tasks->find(['_id'=>$id]);
		return $task;
	}

	/**
	 * Untuk membuat task
	 */
	public function create(array $data)
	{
		$dataSaved = [
			'title'=>$data['title'],
			'description'=>$data['description'],
			'assigned'=>null,
			'subtasks'=> [],
			'created_at'=>time()
		];

		$id = $this->tasks->save($dataSaved);
		return $id;
	}

	/**
	 * Untuk menyimpan task baik untuk membuat baru atau menyimpan dengan struktur bson secara bebas
	 *  */
	public function save(array $editedData)
	{
		$id = $this->tasks->save($editedData);
		return $id;
	}
	
	/**
	 * Untuk menghapus task 
	 *  */
	public function delete(string $id)
	{
		$id = $this->tasks->deleteQuery(['_id'=>$id]);
		return $id;
	}

	/**
	 * Untuk membuat subtask
	 */
	public function createSubtask(array $task, array $subtask)
	{
		$subtasks = isset($task['subtasks']) ? $task['subtasks'] : [];
		$subtasks[] = [
				'_id'=> (string) new \MongoDB\BSON\ObjectId(),
				'title'=>$subtask['title'],
				'description'=>$subtask['description']
			];

		$task['subtasks'] = $subtasks;

		$id = $this->tasks->save($task);
		return $id;
	}
	
	/**
	 * Untuk menghapus subtask 
	 *  */
	public function deleteSubtask(array $existTask, string $subtaskId)
	{
		$subtasks = isset($existTask['subtasks']) ? $existTask['subtasks'] : [];

		// Pencarian dan penghapusan subtask
		$subtasks = array_filter($subtasks, function($subtask) use($subtaskId) {
			if($subtask['_id'] == $subtaskId)
			{
				return false;
			} else {
				return true;
			}
		});
		$subtasks = array_values($subtasks);
		$existTask['subtasks'] = $subtasks;

		$id = $this->tasks->save( $existTask);
		return $id;
	}
}