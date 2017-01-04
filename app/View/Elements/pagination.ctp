<?php if ($this->Paginator->hasPage(2)):?>

	    <ul class="pagination">
	        <?php echo $this->Paginator->prev('← Previous', array('tag'	=>	'li'), null, array('class' => 'prev disabled', 'disabledTag'	=>	'a', 'tag'	=>	'li'));?>
	        <?php echo $this->Paginator->numbers(array('first' => false, 'last' => false, 'modulus' => 4, 'separator' => false, 'tag'	=>	'li', 'currentTag' => 'a', 'currentClass' => 'active' ));?>
	        <?php echo $this->Paginator->next('Next → ', array('tag'	=>	'li'), null, array('class' => 'next disabled', 'disabledTag'	=>	'a', 'tag'	=>	'li'));?>
	    </ul>

<?php endif;?>
