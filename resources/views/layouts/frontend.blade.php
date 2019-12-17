<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html> <!--<![endif]-->

<!-- Mirrored from www.soaptheme.net/html/travelo/hotel-index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Jun 2017 07:41:58 GMT -->
<head>
    <!-- Page Title -->
    <title>KNOWLEDGE.VN</title>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="keywords" content="" />
    <meta name="description" content="">
    <meta name="author" content="BLOOMGOO.VN">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ url('favicon.ico') }}" type="image/x-icon">

    <!-- Theme Styles -->
    <link rel="stylesheet" href="/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="/frontend/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/frontend/css/animate.min.css">

    <!-- Current Page Styles -->
    <link rel="stylesheet" type="text/css" href="/frontend/components/revolution_slider/css/settings.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/frontend/components/revolution_slider/css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/frontend/components/jquery.bxslider/jquery.bxslider.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/frontend/components/flexslider/flexslider.css" media="screen" />
    <link id="main-style" rel="stylesheet" href="/frontend/css/style-light-blue.css">

    <!-- Main Style -->
    <link id="main-style" rel="stylesheet" href="/frontend/css/jquery-accordion-menu.css">

    <!-- Updated Styles -->
    <link rel="stylesheet" href="/frontend/css/updates.css">

    <!-- Responsive Styles -->
    <link rel="stylesheet" href="/frontend/css/responsive.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />

    <!-- Custom Styles -->
    <link rel="stylesheet" href="/frontend/css/custom.css">

    <!-- CSS for IE -->
    <!--[if lte IE 9]>
    <link rel="stylesheet" type="text/css" href="/frontend/css/ie.css" />
    <![endif]-->
</head>
<body>

<div id="page-wrapper">
    @include('layouts.frontend.header')
    @include('layouts.frontend.popup')
    @yield('page_title')
    <section id="content">
        {{--<div class="container">--}}
        {{--@include('flash::message')--}}
        {{--</div>--}}
        @yield('content')
    </section>

    @include('layouts.frontend.footer')
</div>

<!-- Javascript -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script type="text/javascript" src="/frontend/js/jquery.noconflict.js"></script>
<script type="text/javascript" src="/frontend/js/modernizr.2.7.1.min.js"></script>
<script type="text/javascript" src="/frontend/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/frontend/js/jquery.placeholder.js"></script>
<script type="text/javascript" src="/frontend/js/jquery-ui.1.10.4.min.js"></script>
<script type="text/javascript" src="/frontend/js/scripts.js"></script>

<!-- format money -->
<script type="text/javascript" src="/frontend/js/jquery.priceformat.min.js"></script>

<!-- Select2 -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<!-- Twitter Bootstrap -->
<script type="text/javascript" src="/frontend/js/bootstrap.js"></script>

<!-- load revolution slider scripts -->
<script type="text/javascript" src="/frontend/components/revolution_slider/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="/frontend/components/revolution_slider/js/jquery.themepunch.revolution.min.js"></script>

<!-- load BXSlider scripts -->
<script type="text/javascript" src="/frontend/components/jquery.bxslider/jquery.bxslider.min.js"></script>

<!-- load FlexSlider scripts -->
<script type="text/javascript" src="/frontend/components/flexslider/jquery.flexslider-min.js"></script>

<!-- parallax -->
<script type="text/javascript" src="/frontend/js/jquery.stellar.min.js"></script>

<!-- waypoint -->
<script type="text/javascript" src="/frontend/js/waypoints.min.js"></script>

<!-- load page Javascript -->
<script type="text/javascript" src="/frontend/js/theme-scripts.js"></script>
<script type="text/javascript" src="/frontend/js/scripts.js"></script>

<!-- App level -->
<script type="text/javascript" src="/frontend/js/app.js"></script>
<script type="text/javascript" src="/frontend/js/jquery-accordion-menu-bloomgoo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js"></script>

<script>
    jQuery(function() {
        jQuery("img").lazyload({
            event : "sporty"
        });
    });

    jQuery(window).bind("load", function() {
        var timeout = setTimeout(function() {
            jQuery("img").trigger("sporty")
        }, 100);
    });
</script>

</body>
</html>

