<?php
class setting extends main {
 
    public function __construct(DB\SQL $db) {
        parent::__construct($db,'set_user_setting', null); 
    }
}