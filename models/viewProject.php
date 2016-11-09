<?php
class viewProject extends main {
 
    public function __construct(DB\SQL $db) {
        parent::__construct($db,'set_view_project', null); 
    }
}