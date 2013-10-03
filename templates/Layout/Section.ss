<div class="row">
	<div class="large-6 columns push-3">
		<h1>$Title</h1>
		$Content
		<div class="row">
		<% control ContentList %>
			<% include ContentListItem %>
		<% end_control %>
		</div>
	</div>
	<div class="large-3 columns push-3 hide-on-print hide-for-small">
		<ul class="large-block-grid-1">
			<% include Teasers %>
		</ul>
	</div>
	<div class="large-3 columns pull-9">
		<% include SideNav %>
	</div>
</div>