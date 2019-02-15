<nav aria-label="Page navigation">
	<ul class="pagination">
		<li{if $page le 1} class="disabled"{/if}>
			<a href="{$uri_prfix}{$page-1}" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
			</a>
		</li>
		
		{for $var=1 to $pagesCount}
			<li{if $var eq $page} class="active"{/if}><a href="{$uri_prfix}{$var}">{$var}</a></li>
		{/for}
		
		<li{if $page ge $pagesCount} class="disabled"{/if}>
			<a href="{$uri_prfix}{$page+1}" aria-label="Next">
				<span aria-hidden="true">&raquo;</span>
			</a>
		</li>
	</ul>
</nav>