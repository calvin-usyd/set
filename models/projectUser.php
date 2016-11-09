<?php
class projectUser extends main {
 
    public function __construct(DB\SQL $db) {
        parent::__construct($db,'set_project_user', null); 
    }
}