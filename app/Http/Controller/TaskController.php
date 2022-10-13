<?php

namespace App\Http\Controller;

use App\ContohBootcamp\Services\TaskService;
use App\Helpers\MongoModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller {
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
			'description'=>'required|string'
		]);

		$data = [
			'title'=>$request->post('title'),
			'description'=>$request->post('description')
		];

		$dataSaved = [
			'title'=>$data['title'],
			'description'=>$data['description'],
			'assigned'=>null,
			'subtasks'=> [],
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
			'subtasks'=>'array',
		]);

		$taskId = $request->post('task_id');
		$formData = $request->only('title', 'description', 'assigned', 'subtasks');
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

	// TODO: assignTask()
	public function assignTask(Request $request)
	{
		$request->validate([
			'task_id'=>'required',
			'assigned'=>'required'
		]);

		$taskId = $request->post('task_id');
		$id = $this->taskService->getById($taskId);
		if(!$id)
		{
			return response()->json([
				"message"=> "Task ".$id." tidak ada"
			], 401);
		}
		else
		{
			$formData = $request->only('assigned');
			$this->taskService->assignTask($id, $formData);
			$task = $this->taskService->getById($taskId);
			return response()->json($task);
		}
	}

	// TODO: unassignTask()
	public function unassignTask($taskId)
	{
		$id = $this->taskService->getById($taskId);
		if(!$id)
		{
			return response()->json([
				"message"=> "Task ".$id." tidak ada"
			], 401);
		}
		else
		{
			$this->taskService->unassignTask($id);
			$task = $this->taskService->getById($taskId);
			return response()->json($task);
		}
	}

	// TODO: createSubtask()
	public function createSubtask(Request $request)
	{

		$request->validate([
			'task_id'=>'required',
			'title'=>'required|string',
			'description'=>'required|string'
		]);

		$taskId = $request->post('task_id');
		$id = $this->taskService->getById($taskId);
		if(!$id)
		{
			return response()->json([
				"message"=> "Task ".$id." tidak ada"
			], 401);
		}
		else
		{
			$formData = $request->only('title','description');
			$this->taskService->createSubtask($id, $formData);
			$task = $this->taskService->getById($taskId);
			return response()->json($task);
		}
	}

	// TODO deleteSubTask()
	public function deleteSubtask($taskId, $subtaskId)
	{
		$id = $this->taskService->getById($taskId);
		if(!$id)
		{
			return response()->json([
				"message"=> "Task ".$taskId." tidak ada"
			], 401);
		} else {
			$this->taskService->deleteSubtask($id,$subtaskId);
			$id = $this->taskService->getById($taskId);
			return response()->json($id);
		}
	}

}