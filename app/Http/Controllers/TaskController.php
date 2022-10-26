<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tasks\Services\TaskService;

class TaskController extends Controller
{
    private TaskService $taskService;
	public function __construct() {
		$this->taskService = new TaskService();
	}

	public function showTasks()
	{
		$tasks = $this->taskService->getTasks();
		return response()->json($tasks);
	}

	public function createTask(Request $request)
	{
		$request->validate([
			'title'=>'required|string|min:3',
			'description'=>'required|string',
            'assigned'=>'required|string'
		]);

		$data = [
			'title'=>$request->post('title'),
			'description'=>$request->post('description'),
            'assigned'=>$request->post('assigned')
		];

		$dataSaved = [
			'title'=>$data['title'],
			'description'=>$data['description'],
			'assigned'=>$data['assigned'],
			'created_at'=>time()
		];

		$id = $this->taskService->addTask($dataSaved);
		$task = $this->taskService->getById($id);

		return response()->json($task);
	}

    public function updateTask(Request $request)
	{

		$request->validate([
			'task_id'=>'required|string',
			'title'=>'string',
			'description'=>'string',
			'assigned'=>'string',
		]);

		$taskId = $request->post('task_id');
		$formData = $request->only('title', 'description', 'assigned');
		$task = $this->taskService->getById($taskId);

		$this->taskService->updateTask($task, $formData);

		$task = $this->taskService->getById($taskId);

		return response()->json($task);
	}


	// TODO: deleteTask()
	public function deleteTask($taskId)
	{
		$id = $this->taskService->getById($taskId);
		if(!$id)
		{
			return response()->json([
				"message"=> "Task ".$taskId." tidak ada"
			], 401);
		} else {
			$this->taskService->deleteTask($taskId);
			return response()->json([
				'message'=> 'Success delete task '.$taskId
			]);
		}
	}

	// TODO: searchTaskByTitle()
	public function searchTask($title)
	{
		$id = $this->taskService->getByTitle($title);
		if(!$id)
		{
			return response()->json([
				"message"=> "Task dengan judul ".$title." tidak ada",
				"id"=> $id
			], 401);
		} else {
			return response()->json($id);
		}
	}
}
