<?php
class SetTodoController extends SetAccountController
{
	/**
	  POST /todoDelete
	  PARAMS:
		@@projectId
		@@toDoId
	**/
	public function delete($f3){
		$msg = array('fail', 'Unable to delete the todo');
		
		$projectId = $f3->get('POST.projectId');
		
		if ($f3->exists('POST.toDoId')){
			$this->todo->delete('toDoId', $f3->get('POST.toDoId'));
			
			$msg = array('success', $this->getAll($projectId));
		}
		
		echo json_encode($msg);
		
		die();
	}
	
	/**
	  POST /todoAdd
	  PARAMS:
		@@projectId
		@@name
		@@description
	**/
	/*public function add($f3){
		$msg = array('fail', 'Unable to add todo');
		
		$projectId = $f3->get('POST.projectId');
		
		if ($f3->exists('POST.name') && $f3->exists('POST.description')){
			
			$this->todo->add();
			
			$msg = array('success', $this->getAll($projectId));
		}
		
		echo json_encode($msg);
		
		die();
	}*/
	
	/**
	  POST /todoEdit
	  PARAMS:
		@@projectId
		@@toDoId
		@@name
		@@description
	**/
	public function editAdd($f3){
		
		$msg = array('fail', 'Please provide all required informations.');
		
		//$projectId = $f3->get('POST.projectId');
		
		if ($f3->exists('POST.name') && $f3->exists('POST.description')){
			
			if ($f3->exists('POST.toDoId') && $f3->get('POST.toDoId') > 0){
			
				$msg = array('fail', 'Unable to edit todo');
				
				$this->todo->edit('toDoId', $f3->get('POST.toDoId'));
				
			}else{
				$msg = array('fail', 'Unable to add todo');
				
				$this->todo->add();
			}
			
			$msg = array('success', 'Data updated successfully!');
		}
		
		echo json_encode($msg);
		
		die();
	}
	
	/**
	  POST /todo
	  PARAMS:
		@@projectId
	**/
	public function view($f3){
		if ($f3->exists('POST.projectId')){
			$projectId = $f3->get('POST.projectId');
			
			$f3->set('results', $this->getAll($projectId));
			
			$f3->set('projectId', $projectId);
			
			$f3->set('projectName', $f3->get('POST.projectName'));
			
			$f3->set('navTab', 'todo');
		
			$f3->set('inc', 'todo.htm');
			
		}else{
			$f3->reroute('/project');
		}
	}
	
	private function getAll($projectId){
		return $this->todo->getByArray(array('projectId=?', $projectId));
	}
}