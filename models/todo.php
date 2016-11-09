<?php
class todo extends main {
 
    public function __construct(DB\SQL $db) {
        parent::__construct($db,'set_todo', null); 
    }
}