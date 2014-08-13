<a href="/">
	<header>
	<div class='banner'>
	<img src='/img/banner-text.svg'class='text'/>
	<img src='/img/banner-graphic.svg' class='graphic'/>
	</div>
	</header>
</a>
<nav class="categoryNav">
	<div class="nav-inner">
		<a href="/coffee" title="coffee" class="catNavLink">
			<div class='tile'>
				<div class='inner coffee'>
				  <div class='graphic coffee'></div>
				  <div class='caption'>coffee</div> 
				</div>
			</div>
		</a>
		<a href="/bpts" title="burgers, pizza, tacos, sandwiches" class="catNavLink">
			<div class="tile">
				<div class='inner bpts'>
				  <div class='graphic bpts'></div>
				  <div class='caption'>bpts</div>  
				</div>
			</div>
		</a>
		<a href="/beer" title="beer" class="catNavLink">
			<div class='tile'>
				<div class='inner beer'>
				  <div class='graphic beer'></div>
				  <div class='caption'>beer</div>
				</div>
			</div>
		</a>
		<a href="/local" title="pacific northwest" class="catNavLink">
			<div class='tile'>
				<div class='inner local'>
				  <div class='graphic pnw'></div>
				  <div class='caption'>pnw</div>
				</div>
			</div>
		</a>
	</div>
</nav>
<script type="text/html" id="spots-tmpl">
	<section class="spotCard">
		<div class="inner">
			<input type="hidden" class="spotID" value="{{id}}" />
			<div class="displayField spotName"><a href="{{& website}}">{{name}}</a></div>
			<div class="displayField spotAddress"><a href="{{addressURL}}">{{address}}, {{zip}}</a></div>
			<div class="displayField spotPhone"><a href="tel:{{phone}}">{{phone_styled}}</a></div>
			<div class="displayField spotTwitter"><a class="" href="{{& twitter}}">@{{twitter_handle}}</a></div>
			<div class="displayField">
				<span>Multiple Locations?</span>
				<span class="spotMultipleLocations">{{multipleLocations}}</span>
			</div>
			<div class="likeHolder">
				<span class="likesLabel"># of likes?</span>
				<div class="displayField spotLikes">{{likes}}</div>
				{{& likeBtn}}
			</div>
			<div class="rankingNumber">{{ranking}}</div>
		</div>
	</section>
</script>
<div id="location-address"></div>
<a id="sort-button" href="javascript:sortSpots()">Sort by my location</a>