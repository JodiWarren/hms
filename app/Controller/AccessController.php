<?php
App::uses('AppController', 'Controller');
App::uses('HmsAuthenticate', 'Controller/Component/Auth');

class AccessController extends AppController 
{
/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Access';

/**
 * This controller uses the member and rfidtags model
 *
 * @var array
 */
	public $uses = array('Member', 'RfidTag');

	//! Test to see if a user is authorized to make a request.
	/*!
		@param array $user Member record for currently logged in user.
		@param CakeRequest $request The request the user is attempting to make.
		@retval bool True if the user is authorized to make the request, otherwise false.
		@sa http://api20.cakephp.org/class/cake-request
	*/
	public function isAuthorized($user, $request)
	{
		if(parent::isAuthorized($user, $request))
		{
			return true;
		}

		$memberId = $this->Member->getIdForMember($user);
		$memberIsMembershipAdmin = $this->Member->GroupsMember->isMemberInGroup( $memberId, Group::MEMBERSHIP_ADMIN );
		$memberIsOnMembershipTeam = $this->Member->GroupsMember->isMemberInGroup( $memberId, Group::MEMBERSHIP_TEAM );
		$actionHasParams = isset( $request->params ) && isset($request->params['pass']) && count( $request->params['pass'] ) > 0;
		$memberIdIsSet = is_numeric($memberId);

		$firstParamIsMemberId = ( $actionHasParams && $memberIdIsSet && $request->params['pass'][0] == $memberId );

		if (isset($request->params['pass'][0]))
		{
			$currentMember = $this->Member->getStatusForMember($memberId) == Status::CURRENT_MEMBER ? true : false;
			$viewedMemberIsCurrent = $this->Member->getStatusForMember($request->params['pass'][0]) == Status::CURRENT_MEMBER ? true : false;
		}
		else
		{
			$currentMember = false;
			$viewedMemberIsCurrent = false;
		}

		switch ($request->action) 
		{
			
			case 'view':
				return ( ($memberIsMembershipAdmin || $memberIsOnMembershipTeam || ($firstParamIsMemberId && $currentMember)) && $viewedMemberIsCurrent);

		}

		return false;
	}

	public function beforeFilter()
	{
		parent::beforeFilter();
		Configure::load('hms');
	}

	public function view($id)
	{
		// first the door entry codes for the view
		$this->set('street_door', Configure::read('hms_access_street_door'));
		$this->set('inner_door', Configure::read('hms_access_inner_door'));

		// Now let's get some member info.
		// We need basic member details, RFID tags and pins
		$rawMemberInfo = $this->Member->getMemberSummaryForMember($id, false);
		
		// Basic member info
		$memberInfo = array
		(
			'id'		=>	Hash::get($rawMemberInfo, 'Member.member_id'),
			'firstname'	=>	Hash::get($rawMemberInfo, 'Member.firstname'),
			'surname'	=>	Hash::get($rawMemberInfo, 'Member.surname'),
			'username'	=>	Hash::get($rawMemberInfo, 'Member.username'),
			'email'		=>	Hash::get($rawMemberInfo, 'Member.email'),
		);
		// send this to the view
		$this->set('member', $memberInfo);

		// RFID tags
		$rfidtags = array();
		$activeCards = 0;
		if(array_key_exists('RfidTag', $rawMemberInfo))
		{
			foreach ($rawMemberInfo['RfidTag'] as $rfidtag) 
			{
				$rfidtag = array
				(
					'id' => Hash::get($rfidtag, 'id'),
					'name' => Hash::get($rfidtag, 'name'),
					'serial' => Hash::get($rfidtag, 'rfid_serial'),
					'state' => Hash::get($rfidtag, 'state') == RfidTag::STATE_ACTIVE ? "Active" : "Inactive",
					'last_used' => Hash::get($rfidtag, 'last_used_ts'),
				);
				$activeCards += $rfidtag['state'] == "Active" ? 1 : 0;
				$rfidtags[] = $rfidtag;
			}
		}
		// send this to the view
		$this->set('rfidtags', $rfidtags);
		$this->set('activeCards', $activeCards);

		// Now to extract the Pin
		// We might not have an enrollment pin
		$pin = false;
		if(array_key_exists('Pin', $rawMemberInfo))
		{
			$state = Hash::get($rawMemberInfo, 'Pin.state');
			if ($state == Pin::STATE_ENROLL || $state == Pin::STATE_CANCELLED)
			{
				$pin = array
				(
					'id'		=>	Hash::get($rawMemberInfo, 'Pin.pin_id'),
					'pin'		=>	Hash::get($rawMemberInfo, 'Pin.pin'),
					'isActive'	=>	$state == Pin::STATE_ENROLL ? true : false,
				);
			}
		}
		// send this to the view
		$this->set('pin', $pin);
	}


}


?>