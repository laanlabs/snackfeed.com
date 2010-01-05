<div id="search-wrapper" style="padding-left: 10px">
	<form id="search-form" method="get" action="/shows/detail/<?= $id ?>?" name="search_form">
		<input type="hidden" name="_v" value="search" />
		<div id="search-box">
			<input id="search-input" type="search" results="10" placeholder="what are you looking for?" name="q" value="<?= $q ?>" />
			</div>
		<div id="search-button" style="padding-top: 10px">
			<div id="button-submit" style="width:200px" >
				<a href="javascript:document.search_form.submit();">search in this show</a>
			</div>
		</div>

	</form>
</div>


<br clear="both" />
<br clear="both" />
<br clear="both" />