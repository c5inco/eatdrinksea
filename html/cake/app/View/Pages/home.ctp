<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<?php 
echo $this->element('header');
?>

<section class="row">
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
  </section>

<?php
echo $this->element('footer');
?>