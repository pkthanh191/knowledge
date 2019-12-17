<header id="header" class="navbar-static-top">
    @include('layouts.frontend.top_menu')

    <div class="main-header">

        <a href="#mobile-menu-01" data-toggle="collapse" class="mobile-menu-toggle">
            Mobile Menu Toggle
        </a>

        <div class="container">
            <h1 class="logo navbar-brand">
                <a href="/" title="KNOWLEDGE.VN">
                    <img data-original="/frontend/images/logo.png" alt="KNOWLEDGE.VN" />
                </a>
            </h1>

            <nav id="main-menu" role="navigation">
                @include('layouts.frontend.menu')
            </nav>
        </div>

        <nav id="mobile-menu-01" class="mobile-menu collapse">
            @include('layouts.frontend.mobile_menu')
            @include('layouts.frontend.top_mobile_menu')
        </nav>
    </div>
</header>