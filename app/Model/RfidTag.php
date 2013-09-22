<?php

App::uses('AppModel', 'Model');

/**
 * Model for all RFID Tags
 *
 *
 * @package       app.Model
 */
class RfidTag extends AppModel 
{
	const STATE_ACTIVE = 10; //!< Active card state
	const STATE_INACTIVE = 20; //!< Inactive card state

	public $useTable = 'rfid_tags'; //!< Specify the table to use.
	public $primaryKey = 'id'; //!< Specify the primary key to use.

	//! Let's get a more useful timestamp
	public $virtualFields = array(
		'last_used_ts' => 'UNIX_TIMESTAMP(last_used)',
	);

	//! We belong to a Member.
	/*!
		Member join type is inner as it makes no sense to have a pin that has no Member.
	*/
	public $belongsTo = array(
		'Member' => array(
			'className' => 'Member',
			'foreignKey' => 'member_id',
			'type' => 'inner'
		)
	);

	//! Validation rules.
	public $validate = array(
		'member_id' => array(
			'length' => array(
				'rule' => array('maxLength', 11),
				'message' => 'Member id must be no more than 11 characters long',
			),
			'content' => array(
				'rule' => 'numeric',
				'message' => 'Member id must be a number',
			),
		),
		'name' => array(
			'length' => array(
				'rule' => array('between', 1, 100),
				'message' => 'name must be between 1 and 100 characters long',
			),
		),
		'rfid_serial' => array(
			'length' => array(
				'rule' => array('between', 1, 50),
				'message' => 'name must be between 1 and 50 characters long',
			),
		),
		'state' => array(
			'length' => array(
				'rule' => array('between', 1, 11),
				'message' => 'State must be between 1 and 11 characters long',
			),
			'content' => array(
				'rule' => 'numeric',
				'message' => 'State must be a number',
			),
		),
	);


}