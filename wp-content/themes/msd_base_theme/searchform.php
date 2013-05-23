<form method="get" class="searchform" id="searchform" action="<?php bloginfo('url'); ?>/">
<div><input type="text" class="field" value="<?php the_search_query(); ?>" name="s" id="s" 
onblur="if (this.value == '') {this.value = 'Search';}" 
onfocus="if (this.value == 'Search') {this.value = '';}" />
<input type="submit" class="submit" id="searchsubmit" value="Search" />
</div>
</form>