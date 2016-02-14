<% require javascript("framework/thirdparty/jquery/jquery.js") %>
<% require javascript("quickfeedback/js/button-group.js") %>
<div class="field" style="overflow: auto;" {$AttributesHTML}>
	<% loop $Options %>
  		<button id="Field{$Name}-{$Value}" name="Field{$Name}-{$Value}" type="button" value="{$Value}" class="btn<% if $isChecked %> checked<% end_if %>">{$Title}</button>
	<% end_loop %>
	<input id="{$id}" type="hidden" name="{$Name}" value="" />
</div>
