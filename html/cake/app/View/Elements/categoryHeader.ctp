<a href="/">
	<header>
	<div class='banner'>
	<img src='/img/banner-text.svg'class='text'/>
	<img src='/img/banner-graphic.svg' class='graphic'/>
	</div>
	</header>
</a>
<nav class="categoryNav">
<a href="/coffee">
	<div class='tile'>
		<div class='inner'>
		  <div class='graphic coffee'></div>
		  <div class='caption'>coffee</div> 
		</div>
	</div>
</a>
<a href="/bpts">
	<div class="tile">
		<div class='inner'>
		  <div class='graphic bpts'></div>
		  <div class='caption'>bpts</div>  
		</div>
	</div>
</a>
<a href="/beer">
	<div class='tile'>
		<div class='inner'>
		  <div class='graphic beer'></div>
		  <div class='caption'>beer</div>
		</div>
	</div>
</a>
<a href="/local">
	<div class='tile'>
		<div class='inner'>
		  <div class='graphic pnw'></div>
		  <div class='caption'>pnw</div>
		</div>
	</div>
</a>
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
				<div class="likeButton">Like</div>
				<div class="displayField spotLikes">{{likes}}</div>
			</div>
			<div class="rankingNumber"></div>
		</div>
	</section>
</script>
<div class="location-filter">
	<a id="location-button" href="javascript:sortByLocation()">Sort by My Location</a>
	<span id="location-address"></span>
</div>