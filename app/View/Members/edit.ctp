<!-- File: /app/View/Member/edit.ctp -->

<?php
	$this->Html->addCrumb('Members', '/members');
	$this->Html->addCrumb('Edit ' . $this->data['Member']['name'], '/members/edit/' . $this->data['Member']['member_id']);
?>

<?
	echo $this->Form->create('Member');
	echo $this->Form->hidden('member_id');
	echo $this->Form->input('name');
	echo $this->Form->input('email');
	echo $this->Form->input('handle');
	echo $this->Form->input('unlock_text');
	echo $this->Form->input('member_status', array( 
			'options' => $statuses, 
			'type' => 'select',
			'selected' => $this->Html->value('Status.Status'),
		) 
	);

	echo $this->Form->input('address_1', array( 'label' => 'Address part 1 (House name/number and street)' ) );
	echo $this->Form->input('address_2', array( 'label' => 'Address part 2' ) );
	echo $this->Form->input('address_city', array( 'label' => 'City' ) );
	echo $this->Form->input('address_postcode', array( 'label' => 'Postcode' ) );

	echo $this->Form->input('contact_number' );

	echo $this->Form->input('account_id', array( 
			'options' => $accounts,
			'label' => 'Account [ Payment Ref ]',
		) 
	);

	echo '<fieldset>';
	echo '<legend>Groups</legend>';

	echo $this->Form->input('Group',array(
            'label' => __(' ',true),
            'type' => 'select',
            'multiple' => 'checkbox',
            'options' => $groups,
            'selected' => $this->Html->value('Group.Group'),
        )); 

	echo '</fieldset>';

	# Pin details
	echo $this->Form->input('Pin.pin', array( 'readonly' => 'readonly' ));

	echo $this->Form->end('Update Member');
?>