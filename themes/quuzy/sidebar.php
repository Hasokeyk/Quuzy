<div class="sidebar">
	<ul>
		<li <?=$urlParse['fullLink']=='/'?'class="active"':''?>>
			<a href="/">
				<div class="icon">
					<i class="fad fa-home"></i>
				</div>
				<div class="text">
					Home
				</div>
			</a>
		</li>
		<li <?=$urlParse['fullLink']=='/last-posts/'?'class="active"':''?>>
			<a href="/last-posts/">
				<div class="icon">
					<i class="fad fa-images"></i>
				</div>
				<div class="text">
					Last Posts
				</div>
			</a>
		</li>
		<li <?=$urlParse['fullLink']=='/instagram/'?'class="active"':''?>>
			<a href="/instagram/">
				<div class="icon">
					<i class="fad fa-users"></i>
				</div>
				<div class="text">
					Last Users
				</div>
			</a>
		</li>
	</ul>
</div>