<?php
class SetProjectUserController extends SetAccountController
{
	/**
	  POST /pUserDelete
	  PARAMS:
		@@projectId
		@@projUserId
	**/
	public function delete($f3){
		$msg = array('fail', 'Unable to delete the user!');
		
		$projectId = $f3->get('POST.projectId');
		
		if ($f3->exists('POST.projUserId')){
			$this->projectUser->delete('projUserId', $f3->get('POST.projUserId'));
			
			$msg = array('success', 'Data deleted successfully!');
		}
		echo json_encode($msg);
		
		die();
	}
	
	/**
	  POST /pUserAdd
	  PARAMS:
		@@projectId
		@@username
	**/
	public function add($f3){
		$username = $f3->get('POST.username');
		
		$msg = array('fail', 'Unable to add user: ' . $username);
		
		$projectId = $f3->get('POST.projectId');
		
		if ($f3->exists('POST.username') && $f3->exists('POST.projectId')){
			
			//CHECK IF THIS USERNAME IS REGISTERED IN iLAB 
			$resultUser = $this->users->getByArray(array('username=?', $username));
			
			$msg = array('fail', 'This username is not registered in iLab!');
			
			if (count($resultUser) > 0){
				//CHECK IF SAME DATA EXISTS
				$resultProjUser = $this->projectUser->getByArray(array('username=? and projectId=?', $username, $projectId));
				
				$msg = array('fail', 'The information is already exists!');
			
				if (count($resultProjUser) == 0){
					$this->projectUser->add();
					
					$msg = array('success', 'Data updated successfully!');
				}
			}
		}
		echo json_encode($msg);
		
		die();
	}
	
	/**
	  POST /pUser
	  PARAMS:
		@@projectId
	**/
	public function view($f3){
		if ($f3->exists('POST.projectId')){
			$projectId = $f3->get('POST.projectId');
			
			$f3->set('results', $this->getAll($projectId));
			
			$f3->set('projectId', $projectId);
			
			$f3->set('Name', $f3->get('POST.projectName'));
			
			$f3->set('navTab', 'user');
		
			$f3->set('inc', 'projectUser.htm');
			
		}else{
			$f3->reroute('/project');
		}
	}
	
	private function getAll($projectId){
		return $this->projectUser->getByArray(array('projectId=?', $projectId));
	}
}	