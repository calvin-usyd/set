<?php
class SetProjectController extends SetAccountController
{
	/**
	  POST /projectDelete
	  PARAMS:
		@@projectId
	**/
	public function delete($f3){
		$msg = array('fail', 'Unable to delete the project');
		
		$projectId = $f3->get('POST.projectId');
		
		if ($f3->exists('POST.projectId')){
			$this->project->delete('projectId', $f3->get('POST.projectId'));
			
			$msg = array('success', $this->getAll($projectId));
		}
		
		echo json_encode($msg);
		
		die();
	}
	
	/**
	  POST /projectAdd
	  PARAMS:
		@@projectId
		@@name
		@@description
	**/
	/*public function add($f3){
		$msg = array('fail', 'Unable to add project');
		
		$projectId = $f3->get('POST.projectId');
		
		if ($f3->exists('POST.name') && $f3->exists('POST.description')){
			
			$this->project->add();
			
			//Save to project_user
			$username = $f3->get('SESSION.user');
			
			$f3->set('POST.username', $username);
			
			$f3->set('POST.projectId', $this->project->projectId);
			
			$this->projectUser->add();
			
			$msg = array('success', $this->getAll($projectId));
		}
		
		echo json_encode($msg);
		
		die();
	}*/
	
	/**
	  POST /projectEdit
	  PARAMS:
		@@projectId
		@@projectId
		@@name
		@@description
	**/
	public function editAdd($f3){
		
		$projectId = $f3->get('POST.projectId');
		
		if ($f3->exists('POST.name') && $f3->exists('POST.description')){
			//EDIT 
			if ($f3->exists('POST.projectId') && $f3->get('POST.projectId') > 0){
			
				$msg = array('fail', 'Unable to edit project');
				
				$this->project->edit('projectId', $f3->get('POST.projectId'));
				
			}else{
				//ADD
				$msg = array('fail', 'Unable to add project');
		
				$this->project->add();
				
				//Save to project_user
				$username = $f3->get('SESSION.user');
				
				$f3->set('POST.username', $username);
				
				$f3->set('POST.projectId', $this->project->projectId);
				
				$this->projectUser->add();
			}
			
			//$msg = array('success', $this->getAll($projectId));
			$msg = array('success', 'Data updated successfully!');
		}
		
		echo json_encode($msg);
		
		die();
	}
	
	/**
	  GET /project
	  PARAMS:
		@@projectId
	**/
	public function view($f3){
		$username = $f3->get("SESSION.user");
		
		$f3->set('results', $this->getAll($username));
		
		$f3->set('navTab', 'project');
		
		$f3->set('inc', 'home.htm');
	}
	
	private function getAll($username){
		return $this->viewProject->getByArray(array('username=?', $username));
	}
	
	public function viewAllUnderProject($f3){
		$projectIdArr = array('projectId=?', $f3->get('PARAMS.projectId'));
		$this->viewProject->getByArray($projectIdArr);
		
		$f3->set('resultsProject', $this->viewProject);
		$f3->set('resultsTodo', $this->todo->getByArray($projectIdArr));
		$f3->set('resultsProjectUser', $this->projectUser->getByArray($projectIdArr));
		
		$f3->set('inc', 'project.htm');
	}
	
	public function setTabSession($f3){
		$f3->set('SESSION.tab', $f3->get('POST.type'));
		die();
	}
}