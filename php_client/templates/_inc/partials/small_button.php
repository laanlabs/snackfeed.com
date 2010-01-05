<?

	if (!$partial_options["link"]) $small_button_link = "#";
	if (!$partial_options["id"]) $small_button_link = "small-button";
	if (!$partial_options["text"]) $small_button_link = "button";

?><div class="small-light-button-body" >
	<a id="<?= $partial_options["id"] ?>" href="<?= $partial_options["link"] ?>"  class="small-light-button-a" 
		><?= $partial_options["text"] ?></a></div>
		<div class="small-light-button-r" ></div>