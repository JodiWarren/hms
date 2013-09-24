<!-- File: /app/View/Access/view.ctp -->

<?php
	$this->Html->addCrumb('Members', '/members');
	$this->Html->addCrumb(isset($member['username']) ? $member['username'] : $member['email'], '/members/view/' . $member['id']);
	$this->Html->addCrumb('Hackspace Access', '/access/view/' . $member['id']);
?>

<h3>Door Codes</h3>
<table style="width: 50%">
	<tbody>
		<tr>
			<td><strong>Street Door</strong></td>
			<td><?php echo($street_door); ?></td>
		</tr>
		<tr>
			<td><strong>Inner Door</strong></td>
			<td><?php echo($inner_door); ?></td>
		</tr>
	</tbody>
</table>

<h3>Your Cards</h3>
<table>
	<tbody>
		<tr>
			<th>Status</th>
			<th>Name</th>
			<th>Last Used</th>
			<th>Actions</th>
		</tr>
		<?php
		foreach ($rfidtags as $rfidtag)
		{
			$class = $rfidtag['state'] == "Inactive" ? ' class="negative"' : '';
		?>
		<tr>

			<td<?php echo($class); ?>><?php echo($rfidtag['state']); ?></td>
			<td<?php echo($class); ?>><?php echo($rfidtag['name']); ?></td>
			<td<?php echo($class); ?>>
			<?php
				if ($rfidtag['last_used'] > 0)
				{
					echo(date("l, jS F Y @ H:i", $rfidtag['last_used']));
				}
				else
				{
					echo("Not yet used");
				}
			?></td>
			<td>&nbsp;</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>

<h3>Set Up a New Card</h3>

<p>You can have up to three active cards on your account at any one time, but remember, they should only be used by current Hackspace Members.</p>

<?php

if ($activeCards < 3)
{
	if ($pin['isActive'])
	{
		?>
		<p>To register a new card, you simply need to take it to the Hackspace, and follow these simple steps.</p>
		<ul>
			<li>Hold it up to the card reader and wiat until the display says "Access denied".</li>
			<li>Enter your enrollment pin: <strong><?php echo($pin['pin']); ?></strong>, and the card will be registered.</li>
			<li>You can then come back to this page to name your card.</li>
		</ul>
		<?php
	}
	else
	{
		?>
		<p>Before you can register a new card, you need to reactivate your enrollment pin,</p>
		<?php
	}
}
else
{
?>
<p>You currently have three active cards.  You will need to deactivate or delete one of these to add a new card.</p>
<?php
}
?>