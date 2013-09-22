<?php
	$conn = $this->_getDbConnection('default', true);

	$this->_logMessage('Adding `name` to `rfid_tags`');
	$this->_runQuery($conn, "ALTER TABLE  `rfid_tags` ADD  `name` VARCHAR( 100 ) NOT NULL AFTER  `member_id`");

	$this->_logMessage('Setting card name for existing cards');
	$this->_runQuery($conn, "UPDATE `rfid_tags` SET `name`='Primary Card'");

	$this->_logMessage('Removing existing primary key from `rfid_tags`');
	$this->_runQuery($conn, "ALTER TABLE  `rfid_tags` DROP PRIMARY KEY");

	$this->_logMessage('Create new primary key');
	$this->_runQuery($conn, "ALTER TABLE  `rfid_tags` ADD  `id` INT AUTO_INCREMENT NOT NULL FIRST, ADD PRIMARY KEY(id)");

	$this->_logMessage('Add the index back in, not primary this time');
	$this->_runQuery($conn, "ALTER TABLE  `rfid_tags` ADD INDEX (`rfid_serial`, `state`)");
?>