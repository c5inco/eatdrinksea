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
	<a href="coffee" title="coffee" class="categoryLink">
	      <div class='tile'>
	        <div class='graphic coffee'></div>
	        <div class='caption'>coffee</div>
	      </div>      
	</a>
	<a href="bpts" title="burgers, pizza, tacos, sandwiches" class="categoryLink">
	      <div class='tile'>
	        <div class='graphic bpts'></div>
	        <div class='caption'>bpts
        		<span class="bptsSubCaption">(burgers, pizza, tacos, sandwiches)</span>
	        </div>
	      </div>      
	</a>
	<a href="beer" title="beer" class="categoryLink">
	      <div class='tile'>
	        <div class='graphic beer'></div>
	        <div class='caption'>beer</div>
	      </div>      
	</a>
	<a href="local" title="pacific northwest" class="categoryLink">
	      <div class='tile'>
	        <div class='graphic pnw'></div>
	        <div class='caption'>pnw</div>
	      </div>      
	</a>
  </section>

<?php
echo $this->element('footer');
?>