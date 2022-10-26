<?php
namespace App\Tasks\Repositories;

use App\Helpers\MongoModel;
use Symfony\Component\Console\Input\Input;
use DB;

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
	 * Untuk mendapatkan task bedasarkan pencarian title
	 *  */
	public function getByTitle(string $title)
	{
		$task = DB::collection('tasks')->where('title','LIKE','%'.$title.'%')->get();
		// $task = $this->tasks->search(['title'=>$title]);
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
            'assigned'=>$data['assigned'],
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
}