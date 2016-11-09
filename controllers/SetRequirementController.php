<?php
class SetRequirementController extends SetAccountController
{
	/**
	  POST /requirementDelete
	  PARAMS:
		@@projectId
		@@requireId
	**/
	public function delete($f3){
		$msg = array('fail', 'Unable to delete the requirement');
		
		$projectId = $f3->get('POST.projectId');
		
		if ($f3->exists('POST.requireId')){
			$this->requirement->delete('requireId', $f3->get('POST.requireId'));
			
			$msg = array('success', $this->getAll($projectId));
		}
		
		echo json_encode($msg);
		
		die();
	}
	/**
	  POST /requirementAdd
	  PARAMS:
		@@projectId
		@@name
		@@description
	**/
	/*public function add($f3){
		$msg = array('fail', 'Unable to add requirement');
		
		$projectId = $f3->get('POST.projectId');
		
		if ($f3->exists('POST.name') && $f3->exists('POST.description')){
			
			$this->requirement->add();
			
			$msg = array('success', $this->getAll($projectId));
		}
		
		echo json_encode($msg);
		
		die();
	}*/
	
	/**
	  POST /requirementEdit
	  PARAMS:
		@@projectId
		@@requireId
		@@name
		@@description
	**/
	public function editAdd($f3){
		//$projectId = $f3->get('POST.projectId');
		
		$msg = array('fail', 'Please provide all required informations.');
		
		if ($f3->exists('POST.name') && $f3->exists('POST.description')){
			if ($f3->exists('POST.requireId') && $f3->get('POST.requireId') > 0)
			{
				$msg = array('fail', 'Unable to edit requirement');
				
				$this->requirement->edit('requireId', $f3->get('POST.requireId'));
				
			}else{
				$msg = array('fail', 'Unable to add requirement');
				
				$this->requirement->add();
			}
			//$msg = array('success', $this->getAll($projectId));
			$msg = array('success', 'Data updated successfully!');
		}
		
		echo json_encode($msg);
		
		die();
	}
	
	/**
	  POST /requirement
	  PARAMS:
		@@projectId
	**/
	public function view($f3){
		if ($f3->exists('POST.projectId')){
			$projectId = $f3->get('POST.projectId');
			
			$f3->set('results', $this->getAll($projectId));
			
			$f3->set('projectId', $projectId);
			
			$f3->set('projectName', $f3->get('POST.projectName'));
			
			$f3->set('navTab', 'requirement');
		
			$f3->set('inc', 'requirement.htm');
			
		}else{
			$f3->reroute('/project');
		}
	}
	
	private function getAll($projectId){
		return $this->requirement->getByArray(array('projectId=?', $projectId));
	}
}	