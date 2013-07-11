<?php
/* Breadcrumbs */
$this->Html->addCrumb('MemberVoice', '/membervoice/ideas');

/* Load our CSS */
$this->Html->css("MemberVoice.mvideas", null, array('inline' => false));

/* Enclose all HTML to isolate css */
?>

<div class="memberVoice">

<?php
/* Need some way to change category */

/* Add idea form will go here, but not yet! */

/* Show the ideas, if we've got any! */
if (count($ideas) > 0):
	?>
<ul class="mvIdeas">
<?php
	foreach ($ideas as $idea):
?>

<li class="mvIdea">

<div class="mvIdeaDetail">
	<h2><?php echo($this->Html->link($idea['Idea']['idea'], array( 'plugin' => 'membervoice', 'controller' => 'ideas', 'action' => 'idea', $idea['Idea']['id'] ))); ?></h2>
	<p><?php echo($idea['Idea']['description']); ?></p>
	<div class="mvMeta">
		<p><?php
			echo(count($idea['Comment']) . " Comment");
			echo(count($idea['Comment']) == 1 ? "" : "s");
		?></p>
	</div>
</div>

<div class="mvIdeaVotes">
	<div class="mvVoteCount">
		<strong><?php echo($idea['Idea']['votes']); ?></strong>
		<span>vote<?php echo($idea['Idea']['votes'] == 1 ? "" : "s"); ?></span>
	</div>

	<?php echo($this->element('vote', array('id' => $idea['Idea']['id']))); ?>

</div>


</li>

<?php
	endforeach;
	?>
</ul>
<?php
endif;
?>


<?php
/* End isolation block */
?>
</div>

<?php

debug($ideas);

?>