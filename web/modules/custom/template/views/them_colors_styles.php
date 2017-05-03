<style>

html,
button,
input,
select,
textarea {
    color:<?php print $text_on_white; ?>;
}

hr { 
    border-top: 1px solid <?php print $gray; ?>;
}

html {
    background: <?php print $body_bg; ?>;
}

h1,
h2,
h3 {
    color: <?php print $title_color; ?>;
}

a {
    color:<?php print $links; ?>;
}


.wrapper {
	background-color: <?php print $wrap_bg; ?>;
    box-shadow: 0 0 100px <?php print $wrap_bg; ?>;
}

article.article table td {
    border: 1px solid <?php print $text_on_white; ?>;
}

nav.nav {
    border-bottom: 3px solid <?php print $border; ?>;
}

nav.nav a {
    color: <?php print $text_on_white; ?>;
}

nav.nav a:before {
    color: <?php print $text_on_white; ?>;
}

nav.nav a:hover {
    color: <?php print $links; ?>;
}

nav.nav a.active {
    color: <?php print $links; ?>;
}

footer.footer {
    background: url("/images/coloredclasic/footer-bg.png") repeat-x scroll 0 0 <?php print $footer_bg; ?>;
}

footer.footer a {
    color: <?php print $text_on_black; ?>;
}

.footer-content {
    color: <?php print $text_on_black; ?>;
}

section.section {   
    border: 2px solid <?php print $border; ?>;
}

section.section img.thumb {
    border-right: 2px solid <?php print $border; ?>;
}

.phone {
    color: <?php print $title_color; ?>;
}

.branches {
    border: 2px solid <?php print $border; ?>;
}





.edit_node_link_content img{ border-left:none; border-right:none; height:31px}

.edit_node_link img{ border-left:none; border-right:none; height:31px}

.link_more { color:<?php print $links; ?>;}

#leftControl { color:<?php print $menu_color; ?>;}
#leftControl:hover { color:<?php print $menu_color; ?>;}

#rightControl { color:<?php print $menu_color; ?>;}
#rightControl:hover { color:<?php print $menu_color; ?>;}

</style>