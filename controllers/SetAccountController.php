<?php
class SetAccountController extends SetController
{	
	function afterroute($f3) { 
		if (!$f3->exists('SESSION.user') || $f3->get('SESSION.user') == ''){
			$f3->reroute('/login');
		}
		
		if (!$f3->exists('SESSION.guiTheme')){
			$f3->set('SESSION.guiTheme', 'slate');
		}
		
		echo Template::instance()->render('layoutAccount.htm');
    }

}	