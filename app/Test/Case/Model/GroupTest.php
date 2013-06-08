<?php

    App::uses('Pin', 'Model');

    class GroupTest extends CakeTestCase 
    {
        public $fixtures = array( 'app.Group', 'app.Member', 'app.GroupsMember' );

        public function setUp() 
        {
        	parent::setUp();
            $this->Group = ClassRegistry::init('Group');
        }

        public function testGetDescription()
        {
            $this->assertIdentical( Hash::get($this->Group->getDescription(1), 'Group.grp_description'), 'Full Access', 'Returned incorrect title for group 1.' );
            $this->assertIdentical( $this->Group->getDescription(0), false, 'Returned incorrect title for group 0.' );
            $this->assertIdentical( $this->Group->getDescription(null), false, 'Returned incorrect title for group null.' );
        }
    }

?>