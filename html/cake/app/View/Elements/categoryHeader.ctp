<?php echo $this->Html->link("<header>
<div class='banner'>
<img src='/img/banner-text.svg'class='text'/>
<img src='/img/banner-graphic.svg' class='graphic'/>
</div>
</header>"
, array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?>
<nav class="categoryNav">
<?php echo $this->Html->link("<div class='tile'>
	<div class='inner'>
	  <div class='graphic coffee'></div>
	  <div class='caption'>coffee</div> 
	</div>
</div>"
, array('controller' => 'Pages', 'action' => 'category', $category = 'coffee'), array('escape' => false)); ?>
<?php echo $this->Html->link("<div class='tile'>
	<div class='inner'>
	  <div class='graphic bpts'></div>
	  <div class='caption'>bpts</div>  
	</div>
</div>"
, array('controller' => 'Pages', 'action' => 'category', $category = 'bpts'), array('escape' => false)); ?>
<?php echo $this->Html->link("    <div class='tile'>
	<div class='inner'>
	  <div class='graphic beer'></div>
	  <div class='caption'>beer</div>
	</div>
</div>"
, array('controller' => 'Pages', 'action' => 'category', $category = 'beer'), array('escape' => false)); ?>
<?php echo $this->Html->link("<div class='tile'>
	<div class='inner'>
	  <div class='graphic pnw'></div>
	  <div class='caption'>pnw</div>
	</div>
</div>"
, array('controller' => 'Pages', 'action' => 'category', $category = 'local'), array('escape' => false)); ?>
</nav>