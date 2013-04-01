  
  	<?php echo $this->Html->link("<header>
    <div class='banner'>
      <img src='/img/banner-text.svg'class='text'/>
      <img src='/img/banner-graphic.svg' class='graphic'/>
    </div>
  </header>"
	, array('controller' => 'Pages', 'action' => 'display'), array('escape' => false)); ?>