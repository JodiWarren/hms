<?php

	class RfidTagFixture extends CakeTestFixture 
	{
		public $useDbConfig = 'test';
		public $import = 'RfidTag';

		public $records = array(
			array('id' => 1, 'member_id' => 1, 'name' => 'Primary Card', 'rfid_serial' => '1015274259'),
			array('id' => 2, 'member_id' => 2, 'name' => 'Primary Card', 'rfid_serial' => '1033621742'),
			array('id' => 3, 'member_id' => 3, 'name' => 'Primary Card', 'rfid_serial' => '106377805'),
			array('id' => 4, 'member_id' => 4, 'name' => 'Primary Card', 'rfid_serial' => '1119334343'),
			array('id' => 5, 'member_id' => 5, 'name' => 'Primary Card', 'rfid_serial' => '109278178'),
			array('id' => 6, 'member_id' => 6, 'name' => 'Primary Card', 'rfid_serial' => '117229888'),
			
		);
	}

?>