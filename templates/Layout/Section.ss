<div id="ContentArea">
	<h1>$Title</h1>
	$Content
	<div class="ContentList row">
	<% control Children %>
		<div class="ContentListItem clickable" onclick="location.href='$Link'">		
			<h2>$Title</h2>
			<% if From %><p id="Date">$From.Long - $To.Long</p><% end_if %>
			<p>$Content.firstParagraph</p>
			<p><a href="$Link" class="ReadMore">Læs mere</a></p>
		</div>
	<% end_control %>
	</div>
</div>






