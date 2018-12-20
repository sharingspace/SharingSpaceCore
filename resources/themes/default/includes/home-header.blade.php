<header class="header header-desktop style-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="header-wrap">
                    <div class="header-left">
                        <div class="branding">
                            <div class="branding__logo">
                                <a href="./">
                                    <img src="/frontend/images/logo_light.png" alt="Moody" class="main-logo" />
                                    <img src="/frontend/images/logo.png" alt="Moody" class="dark-logo" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="header-right">
                        <div class="header-social-networks d-none d-sm-block">
                            <a class="hint--bounce hint--bottom white" aria-label="Facebook" href="https://facebook.com" target="_blank">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a class="hint--bounce hint--bottom white" aria-label="Twitter" href="https://twitter.com" target="_blank">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a class="hint--bounce hint--bottom white" aria-label="Instagram" href="https://www.instagram.com" target="_blank">
                                <i class="fa fa-instagram"></i>
                            </a>
                            <a class="hint--bounce hint--bottom white" aria-label="Dribbble" href="https://www.dribbble.com" target="_blank">
                                <i class="fa fa-dribbble"></i>
                            </a>
                        </div>
                        <div id="page-open-mobile-menu" class="page-open-mobile-menu">
                            <div><i></i></div>
                        </div>
                    </div>
                    <div class="page-navigation-wrap">
                        <div class="navigation page-navigation">
                            <nav class="menu menu--primary">
                                <ul>
                                    @foreach($menus as $menu)
                                    <li class="menu-item-has-children mega-menu">
                                        <a href="{{route('frontend.slug',$menu->page->slug)}}">
                                            <span class="menu-item-title">{{ucfirst($menu->name)}}</span>
                                        </a>                                        
                                    </li>
                                    @endforeach
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<div id="page-mobile-main-menu" class="page-mobile-main-menu">
    <div class="page-mobile-menu-header">
        <div class="page-mobile-menu-logo">
            <a href="./">
                <img src="/frontend/images/logo.png" alt=""/>
            </a>
        </div>
        <div id="page-close-mobile-menu" class="page-close-mobile-menu">
            <div><i></i></div>
        </div>
    </div>
    <ul class="mobile-menu">
        <li>
            <a href="javascript:void(0)">
                <span class="menu-item-title">Home</span>
                <span class="toggle-sub-menu"> </span>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Home 1</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="creative-agency.html">Creative Agency</a></li>
                        <li><a href="modern-agency.html">Modern Agency</a></li>
                        <li><a href="marketing-agency.html">Marketing Agency</a></li>
                        <li><a href="creative-studio.html">Creative Studio</a></li>
                        <li><a href="start-up.html">Start Up</a></li>
                        <li><a href="digital-agency.html">Digital Agency</a></li>
                        <li><a href="business-classic.html">Business Classic</a></li>
                        <li><a href="personal-freelance.html">Personal Freelance</a></li>
                        <li><a href="./">SEO Marketing</a></li>
                        <li><a href="business-corporate.html">Business Corporate</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Home 2</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="multipurpose.html">Multipurpose</a></li>
                        <li><a href="app-mobile.html">App Mobile</a></li>
                        <li><a href="restaurant.html">Restaurant</a></li>
                        <li><a href="architect.html">Architect</a></li>
                        <li><a href="minimal-portfolio.html">Minimal Portfolio</a></li>
                        <li><a href="classic-blog.html">Classic Blog</a></li>
                        <li><a href="portfolio-1.html">Portfolio 1</a></li>
                        <li><a href="portfolio-2.html">Portfolio 2</a></li>
                        <li><a href="left-menu.html">Left Menu</a></li>
                        <li><a href="presentation.html">Presentation</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Home 3</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="modern.html">Modern</a></li>
                        <li><a href="fullscreen-portfolio-slider.html">Fullscreen Portfolio Slider</a></li>
                        <li><a href="portfolio-fullscreen-split-slider.html">Portfolio Fullscreen Split Slider</a></li>
                        <li><a href="portfolio-fullscreen-split-slider-2.html">Portfolio Fullscreen Split Slider 2</a></li>
                        <li><a href="portfolio-fullscreen-slider-center.html">Portfolio Fullscreen Slider Center</a></li>
                        <li><a href="product.html">Product</a></li>
                        <li><a href="interior-shop.html">Interior Shop</a></li>
                        <li><a href="modern-shop.html">Modern Shop</a></li>
                        <li><a href="stylish-shop.html">Stylish Shop</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)">
                <span class="menu-item-title">Pages</span>
                <span class="toggle-sub-menu"> </span>
            </a>
            <ul class="sub-menu">
                <li><a href="about-me.html">About Me</a></li>
                <li><a href="about-me-2.html">About Me 2</a></li>
                <li><a href="about-us-1.html">About Us 1</a></li>
                <li><a href="about-us-2.html">About Us 2</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="contact-2.html">Contact 2</a></li>
                <li><a href="our-services.html">Our Services</a></li>
                <li><a href="our-services-2.html">Our Services 2</a></li>
                <li><a href="pricing-package.html">Pricing Package</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)">
                <span class="menu-item-title">Elements</span>
                <span class="toggle-sub-menu"> </span>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Element 1</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="buttons.html">Buttons</a></li>
                        <li><a href="charts.html">Charts</a></li>
                        <li><a href="counters.html">Counters</a></li>
                        <li><a href="contact-forms.html">Contact Forms</a></li>
                        <li><a href="pricing.html">Pricing</a></li>
                        <li><a href="list.html">List</a></li>
                        <li><a href="google-map.html">Google Map</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Element 2</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="accordion-toggles.html">Accordion &amp; Toggles</a></li>
                        <li><a href="typography.html">Typography</a></li>
                        <li><a href="carousel.html">Carousel</a></li>
                        <li><a href="testimonials.html">Testimonials</a></li>
                        <li><a href="light-gallery.html">Light Gallery</a></li>
                        <li><a href="gradation.html">Gradation</a></li>
                        <li><a href="rows-columns.html">Rows &amp; Columns</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Element 3</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="timeline.html">Timeline</a></li>
                        <li><a href="icon-boxes.html">Icon Boxes</a></li>
                        <li><a href="info-boxes.html">Info Boxes</a></li>
                        <li><a href="flip-boxes.html">Flip Boxes</a></li>
                        <li><a href="typed-text.html">Typed Text</a></li>
                        <li><a href="countdown.html">Countdown</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Element 4</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="popup-video.html">Popup Video</a></li>
                        <li><a href="pricing-list.html">Pricing List</a></li>
                        <li><a href="tabs.html">Tabs</a></li>
                        <li><a href="team-member.html">Team Member</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)">
                <span class="menu-item-title">Blog</span>
                <span class="toggle-sub-menu"> </span>
            </a>
            <ul class="sub-menu">
                <li><a href="blog-standard.html">Blog Standard</a></li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Blog Grid</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="blog-grid-with-post-format.html">3 Columns</a></li>
                        <li><a href="blog-grid-with-sidebar.html">With Sidebar</a></li>
                    </ul>
                </li>
                <li><a href="blog-grid-overlay-image.html">Blog Grid Overlay Image</a></li>
                <li><a href="blog-grid-classic.html">Blog Grid Classic</a></li>
                <li><a href="blog-grid-simple.html">Blog Grid Simple</a></li>
                <li><a href="blog-grid-left-image.html">Blog Grid Left Image</a></li>
                <li><a href="blog-grid-modern.html">Blog Grid Modern</a></li>
                <li><a href="blog-grid-flip-box.html">Blog Grid Flip Box</a></li>
                <li><a href="blog-carousel.html">Blog Carousel</a></li>
                <li><a href="blog-magazine.html">Blog Magazine</a></li>
                <li><a href="blog-metro.html">Blog Metro</a></li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Single</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="blog-detail-left-sidebar.html">Blog Left Sidebar</a></li>
                        <li><a href="blog-detail-right-sidebar.html">Blog Right Sidebar</a></li>
                        <li><a href="blog-with-image-header.html">Blog With Image Header</a></li>
                        <li><a href="blog-image-post.html">Image Post</a></li>
                        <li><a href="blog-gallery-post.html">Gallery Post</a></li>
                        <li><a href="blog-youtube-post.html">Youtube Post</a></li>
                        <li><a href="blog-vimeo-post.html">Vimeo Post</a></li>
                        <li><a href="blog-audio-post.html">Audio Post</a></li>
                        <li><a href="blog-link-post.html">Link Post</a></li>
                        <li><a href="blog-quote-post.html">Quote Post</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)">
                <span class="menu-item-title">Portfolio</span>
                <span class="toggle-sub-menu"> </span>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Classic</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="portfolio-grid-3-columns.html">3 Columns</a></li>
                        <li><a href="portfolio-grid-3-columns-no-gutter.html">3 Columns – No Gutter</a></li>
                        <li><a href="portfolio-grid-4-columns.html">4 Columns</a></li>
                        <li><a href="portfolio-grid-4-columns-no-gutter.html">4 Columns – No Gutter</a></li>
                        <li><a href="portfolio-grid-5-columns.html">5 Columns</a></li>
                        <li><a href="portfolio-grid-5-columns-no-gutter.html">5 Columns – No Gutter</a></li>
                    </ul>
                </li>
                <li><a href="grid-with-caption.html">Grid With Caption</a></li>
                <li><a href="portfolio-justified-gallery.html">Justified Gallery</a></li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Masonry</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="portfolio-grid-masonry-3-columns.html">3 Columns</a></li>
                        <li><a href="portfolio-grid-masonry-3-columns-no-gutter.html">3 Columns – No Gutter</a></li>
                        <li><a href="portfolio-grid-masonry-4-columns.html">4 Columns</a></li>
                        <li><a href="portfolio-grid-masonry-4-columns-no-gutter.html">4 Columns – No Gutter</a></li>
                        <li><a href="portfolio-grid-masonry-5-columns.html">5 Columns</a></li>
                        <li><a href="portfolio-grid-masonry-5-columns-no-gutter.html">5 Columns – No Gutter</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Metro</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="portfolio-metro-3-columns.html">3 Columns</a></li>
                        <li><a href="portfolio-metro-4-columns.html">4 Columns</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Carousel</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="portfolio-carousel-3-columns.html">3 Columns</a></li>
                        <li><a href="portfolio-carousel-4-columns.html">4 Columns</a></li>
                        <li><a href="portfolio-carousel-5-columns.html">5 Columns</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="menu-item-title">Single</span>
                        <span class="toggle-sub-menu"> </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="portfolio-left-detail.html">Left Details</a></li>
                        <li><a href="portfolio-right-detail.html">Right Details</a></li>
                        <li><a href="portfolio-image-gallery.html">Image Gallery</a></li>
                        <li><a href="portfolio-video.html">Video</a></li>
                        <li><a href="portfolio-image-slider.html">Image Slider</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)">
                <span class="menu-item-title">Shop</span>
                <span class="toggle-sub-menu"> </span>
            </a>
            <ul class="sub-menu">
                <li><a href="shop.html">Shop No Sidebar</a></li>
                <li><a href="shop-left-sidebar.html">Shop Left Sidebar</a></li>
                <li><a href="shop-right-sidebar.html">Shop Right Sidebar</a></li>
                <li><a href="my-account.html">My account</a></li>
                <li><a href="checkout.html">Checkout</a></li>
                <li><a href="cart-empty.html">Empty Cart</a></li>
                <li><a href="cart.html">Cart</a></li>
                <li><a href="shop-detail.html">Single Product</a></li>
            </ul>
        </li>
    </ul>
</div>