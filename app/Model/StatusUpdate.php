<?php

	App::uses('AppModel', 'Model');

	/**
	 * Model for all status update data
	 *
	 *
	 * @package       app.Model
	 */
	class StatusUpdate extends AppModel 
	{	
		public $useTable = 'status_updates'; //!< Specify table.
		public $primaryKey = 'id'; //!< Specify primary key.

		//! We belong to two Members and two Statuses.
		/*!
			Member is the Member the status update was performed on.
			MemberAdmin is the Member that performed the update status action.
			OldStatus is the previous Status of Member.
			NewStatus is the current Status of Member.
		*/
	    public $belongsTo = array(
	    	'Member' => array(
				'className' => 'Member',
				'foreignKey' => 'member_id'
			),
			'MemberAdmin' => array(
				'className' => 'Member',
				'foreignKey' => 'admin_id',
			),
			'OldStatus' => array(
				'className' => 'Status',
				'foreignKey' => 'old_status',
			),
			'NewStatus' => array(
				'className' => 'Status',
				'foreignKey' => 'new_status',
			),
    	);

    	//! Create a new status update record.
    	/*
			@param int $memberId The id of the member who's having their status updated.
			@param int $adminId The id of the member who is doing the updating.
			@param int $oldStatus The members previous status.
			@param int $newStatus The members new status.
			@retval bool True if creation was successful, false otherwise.
		*/
		public function createNewRecord($memberId, $adminId, $oldStatus, $newStatus)
		{
			if(	isset($memberId) && isset($adminId) && isset($oldStatus) && isset($newStatus) &&
				is_numeric($memberId) && is_numeric($adminId) && is_numeric($oldStatus) && is_numeric($newStatus))
			{
				$this->Create();

				$data = array(
					'StatusUpdate' => array(
						'member_id' => $memberId,
						'admin_id' => $adminId,
						'old_status' => $oldStatus,
						'new_status' => $newStatus,
						'timestamp' => date('Y-m-d H:i:s'),
					)
				);

				return ($this->save($data) != false);
			}

			return false;
		}
	}
?>