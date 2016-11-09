<?php
class SetFrontPageController extends SetController{
	
	function index($f3){
		
		if (!$f3->exists('SESSION.user') || $f3->get('SESSION.user') == ''){
			$f3->set('inc', 'login.htm');
			
		}else{
			$f3->reroute('/project');
		}
	}
	
	function login($f3){
		if ($f3->exists('POST.cred') && $f3->exists('POST.password')){
			$cred = $f3->get('POST.cred');
			
			$result = $this->users->getByArray(array('username=? or email=?', $cred, $cred));
			$validPass = 0;
			
			if (count($result) > 0){
				$crypt = \Bcrypt::instance();
				$validPass = $crypt->verify($f3->get('POST.password'), $result[0]['password']);			
			}
			
			if ($validPass){
				$username = $result[0]['username'];
				
				$this->setting->getById('username', $username);
		
				$f3->set('SESSION.user', $username);
				$f3->set('SESSION.guiTheme', $this->setting->guiTheme);
				
				$f3->reroute('/project');
				
			}else{
				$f3->set('err_message', 'Invalid access credential. please try again!');
			}
		}
		$f3->set('inc', 'login.htm');
	}
	
	function logout($f3){
		$f3->clear('SESSION');
		$f3->clear('COOKIE');
		
		$f3->set('SESSION.user',null);
		
		$f3->reroute('/');
	}
	
	function register($f3){
		if ($f3->exists('POST.username') && 
			$f3->exists('POST.email') && 
			$f3->exists('POST.password')
		){
			$result = $this->users->getByArray(array('username=? or email=?', $f3->get('POST.username'), $f3->get('POST.email')));
			
			if (count($result) > 0){
				$f3->set('err_message', 'Your username or email has been taken, please try again.');
				
			}else{
				$crypt = \Bcrypt::instance();
				
				$f3->set('POST.password', $crypt->hash($f3->get('POST.password')));
				
				$this->users->add();

				$f3->set('SESSION.user', $f3->get('POST.username'));
				
				$f3->reroute('/project');
			}
		}
		
		$f3->set('inc', 'register.htm');
	}
	
	function setGuiTheme($f3){
		$user = $f3->get('SESSION.user');
		$theme = $f3->get('POST.guiTheme');
		
		$f3->set('POST.username', $user);
		
		$f3->set('SESSION.guiTheme', $theme);
		
		$this->setting->getById('username', $user);
		
		if ($this->setting->guiTheme == null){
			
			$this->setting->add();
			
		}elseif ($this->setting->guiTheme != $theme){
			
			$this->setting->edit('username', $user);
		}
		
		echo 'Theme was set to '.$f3->get('SESSION.guiTheme');
		
		die();
	}
}