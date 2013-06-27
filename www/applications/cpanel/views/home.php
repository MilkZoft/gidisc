<?php if(!defined("_access")) { die("Error: You don't have permission to access here..."); } ?>

<div id="home">
	<div class="slider-wrapper theme-default">
        <div id="slider" class="nivoSlider">
            <img src="<?php echo path("www/lib/files/images/slider/image01.png", true); ?>" data-thumb="<?php echo path("www/lib/files/images/slider/image01.png", true); ?>" />
            <img src="<?php echo path("www/lib/files/images/slider/image02.png", true); ?>" data-thumb="<?php echo path("www/lib/files/images/slider/image01.png", true); ?>" />
            <img src="<?php echo path("www/lib/files/images/slider/image03.png", true); ?>" data-thumb="<?php echo path("www/lib/files/images/slider/image01.png", true); ?>" />
            <img src="<?php echo path("www/lib/files/images/slider/image04.png", true); ?>" data-thumb="<?php echo path("www/lib/files/images/slider/image01.png", true); ?>" />
            <img src="<?php echo path("www/lib/files/images/slider/image05.png", true); ?>" data-thumb="<?php echo path("www/lib/files/images/slider/image01.png", true); ?>" />
            <img src="<?php echo path("www/lib/files/images/slider/image06.png", true); ?>" data-thumb="<?php echo path("www/lib/files/images/slider/image01.png", true); ?>" />
            <img src="<?php echo path("www/lib/files/images/slider/image07.png", true); ?>" data-thumb="<?php echo path("www/lib/files/images/slider/image01.png", true); ?>" />
            <img src="<?php echo path("www/lib/files/images/slider/image08.png", true); ?>" data-thumb="<?php echo path("www/lib/files/images/slider/image01.png", true); ?>" />
        </div>
        
        <div id="htmlcaption" class="nivo-html-caption">
            <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>. 
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo path("www/lib/scripts/js/nivo/jquery.nivo.slider.js", true); ?>"></script>
<script type="text/javascript">
$(window).load(function() {
    $('#slider').nivoSlider();
});
</script>