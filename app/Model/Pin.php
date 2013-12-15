<?php

	App::uses('AppModel', 'Model');

	/**
	 * Model for all pin data
	 *
	 *
	 * @package       app.Model
	 */
	class Pin extends AppModel 
	{	
		const STATE_ACTIVE = 10;    //!< This pin can be used for entry (up until the expiry date), cannot be used to register a card.
	    const STATE_EXPIRED = 20;   //!< Pin has expired and can no longer be used for entry.
	    const STATE_CANCELLED = 30; //!< This pin cannot be used for entry, and has likely been used to activate an RFID card.
	    const STATE_ENROLL = 40;    //!< This pin may be used to enrol an RFID card.

		public $useTable = 'pins';	//!< Specify the table to use.
		public $primaryKey = 'pin_id';	//!< Specify the promary key to use.

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
	        'pin' => array(
	            'length' => array(
	        		'rule' => array('between', 1, 12),
	        		'message' => 'Pin must be between 1 and 12 characters long',
	        	),
	        ),
	        'state' => array(
	            'length' => array(
	        		'rule' => array('between', 1, 11),
	        		'message' => 'State must be between 1 and 11 characters long',
	        	),
	        	'type' => array(
	        		'rule' => 'naturalNumber',
	        		'message' => 'State must be a number',
	        	),
	        	'content' => array(
	        		'rule' => array('inList', array(10, 20, 30, 40)),
	        		'message' => 'State can only be 10, 20, 30 or 40',
	        	),
	        ),
	        'member_id' => array(
	        	 'length' => array(
	        		'rule' => array('maxLength', 11),
	        		'message' => 'Member id must be no more than 11 characters long',
	        	),
	        	'content' => array(
	        		'rule' => 'naturalNumber',
	        		'message' => 'Member id must be a number',
	        	),
	        ),
	    );

	    //! Generate a random pin.
	    /*!
	    	@retval int A random pin.
	    */
		public static function generatePin()
		{
			# Currently a PIN is a 4 digit number between 1000 and 9999
			return rand(1000, 9999);
		}


		//! Generate a unique (at the time this function was called) pin.
		/*!
			@retval int A random pin that was not in the database at the time this function was called.
		*/
		public function generateUniquePin()
		{
			# A loop hiting the database? Why not...
			$pin = 0;
			do
			{
				$pin = Pin::generatePin();
			} while ( $this->find( 'count', array( 'conditions' => array( 'Pin.pin' => $pin ) ) ) > 0 );

			return $pin;
		}

		//! Create a new pin record
		/*!
			@param int $memberId The id of the member to create the pin for.
			@retval bool True if creation was successful, false otherwise.
		*/
		public function createNewRecord($memberId)
		{
			if(is_numeric($memberId) && $memberId > 0)
			{
				$this->Create();

				$data = array( 'Pin' => 
					array(
						'pin' => $this->generateUniquePin(),
						'state' => Pin::STATE_ENROLL,
					)
				);

				return ($this->save($data) != false);
			}
			return false;
		}
	}
?>