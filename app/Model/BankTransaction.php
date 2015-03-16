<?php
/**
 * 
 * PHP 5
 *
 * Copyright (C) HMS Team
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     HMS Team
 * @package       app.Model
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppModel', 'Model');

/**
 * Model for all account data
 */
class BankTransaction extends AppModel {

/**
 * Specify the table to use
 * @var string
 */
	public $useTable = 'bank_transactions';

/**
 * Specify the primary key to use.
 * @var string
 */
	public $primaryKey = 'bank_transaction_id';	//!< Specify the primary key to use.
/**
 * Specify 'belongs to' associations.
 * @var array
 */
	public $belongsTo = array(
			'AccountBT' => array(
			'className' => 'Account',
			'foreignKey' => 'account_id',
			'type' => 'inner'
			)
		);
/**
 * Validation rules.
 * @var array
 */
	public $validate = array(
		'bank_transactions_id' => array(
			'content' => array(
				'rule' => 'numeric',
				'message' => 'Only numbers are allowed',
			),
			'length' => array(
				'rule' => array('between', 1, 11),
				'message' => 'Number must be between 1 and 11 characters long',
			),
		),
		'ammount' => array(
			'content' => array(
				'rule' => 'numeric',
				'message' => 'Only numbers are allowed',
			),
		),
        'description' => array(
			'rule' => 'notEmpty',
			'message' => 'Must have a description',
		),
		'account_id' => array(
			'length' => array(
				'rule' => array('between', 1, 11),
				'message' => 'Account id must be between 1 and 12 characters long',
			),
			'content' => array(
				'rule' => 'numeric',
				'message' => 'Account id must be a number',
			),
		),
        'datetime' => array(
            'rule' => 'date',
            'allowEmpty' => false,
            'message' => 'Must have a valid date'
        ),
        
	);
}
