<?php
class requirement extends main {
 
    public function __construct(DB\SQL $db) {
        parent::__construct($db,'set_requirement', null); 
    }
}