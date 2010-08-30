<div id="LeftColumn" class="column grid_3 noPrint">
	<% include LeftMenu %>
</div>
<div id="ContentArea" class="column grid_6">
	<h1>$Title</h1>
	$Content
	<div class="ContentList row">
	<% control Children %>
		<div class="ContentListItem column grid_6">
			<% if Thumbnail %><div class="ContentListImage">$Thumbnail.SetWidth(140)</div><% end_if %>		
			<h2>$Title</h2>
			<% if From %><p id="Date">$From.Long - $To.Long</p><% end_if %>
			<p>$Content.firstParagraph</p>
			<p><a href="$Link" class="ReadMore">Læs mere</a></p>
		</div>
	<% end_control %>
	</div>
</div>
<div id="RightColumn" class="column grid_3 noPrint">
	<% include Sidebar %>
</div>









