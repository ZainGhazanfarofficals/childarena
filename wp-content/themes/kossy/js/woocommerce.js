(function($) {
    "use strict";
    
    $.extend($.apusThemeCore, {
        /**
         *  Initialize scripts
         */
        woo_init: function() {
            var self = this;

            self.loginRegister();

            self.cartOffcanvas();

            self.showFilter();

            self.addToCartAction();
            
            self.getProductAjax();
            
            self.searchProduct();

            self.productDetail();
            
            self.initQuickview();

            self.initSidebar();

            self.initSatches();
            
            $( 'body' ).on( 'found_variation', function( event, variation ) {
                self.variationsImageUpdate(variation);
            });

            $( 'body' ).on( 'reset_image', function( event, variation ) {
                self.variationsImageUpdate(variation);
            });

            self.initFilter();
        },

        showFilter: function() {
            $('.show-filter').on('click', function(e){
                e.preventDefault();
                 $(".shop-top-sidebar-wrapper").toggle(300);
            });
        },

        cartOffcanvas: function() {
            $('.apus-topcart .mini-cart').on('click', function(e){
                e.preventDefault();
                if ( $('.dropdown-menu-right').hasClass('active') ) {
                    $('.dropdown-menu-right').removeClass('active');
                    $('.overlay-dropdown-menu-right').removeClass('active');
                } else {
                    $('.dropdown-menu-right').addClass('active');
                    $('.overlay-dropdown-menu-right').addClass('active');
                }
            });
            $('.overlay-dropdown-menu-right, .widget_shopping_cart_heading').on('click', function(){
                $('.dropdown-menu-right').removeClass('active');
                $('.overlay-dropdown-menu-right').removeClass('active');
            });
        },
        addToCartAction: function() {
            jQuery('body').bind('added_to_cart', function( fragments, cart_hash ){
                $('.dropdown-menu-right').addClass('active');
                $('.overlay-dropdown-menu-right').addClass('active');
            });
        },
        getProductAjax: function() {
            var self = this;
            $('[data-load="ajax"] a').on('click', function(e){
                e.preventDefault();
                var $href = $(this).attr('href');

                $(this).parent().parent().find('li').removeClass('active');
                $(this).parent().addClass('active');

                var main = $($href);
                if ( main.length > 0 ) {
                    if ( main.data('loaded') == false ) {
                        main.parent().addClass('loading');
                        main.data('loaded', 'true');

                        $.ajax({
                            url: kossy_ajax.ajaxurl,
                            type:'POST',
                            dataType: 'html',
                            data:  {
                                action: 'kossy_ajax_get_products',
                                settings: main.data('settings'),
                                tab: main.data('tab')
                            }
                        }).done(function(reponse) {
                            main.html( reponse );
                            main.parent().removeClass('loading');
                            main.parent().find('.tab-pane').removeClass('active');
                            main.addClass('active');

                            if ( main.find('.slick-carousel') ) {
                                self.initSlick(main.find('.slick-carousel'));
                            }
                            self.layzyLoadImage();
                        });
                        return true;
                    } else {
                        main.parent().removeClass('loading');
                        main.parent().find('.tab-pane').removeClass('active');
                        main.addClass('active');

                        var $slick = $("[data-carousel=slick]", main);
                        if ($slick.length > 0 && $slick.hasClass('slick-initialized')) {
                            $slick.slick('refresh');
                        }
                        self.layzyLoadImage();
                    }
                }
            });
        },

        loginRegister: function(){
            $('body').on( 'click', '.register-login-action', function(e){
                //e.preventDefault();
                var action = $(this).attr('href');
                setCookie('kossy_login_register', action, 0.5);
                $('.register_login_wrapper').removeClass('active');
                $(action).addClass('active');
            } );
        },
        searchProduct: function(){
            $('.apus-autocompleate-input').typeahead({
                    'hint': true,
                    'highlight': true,
                }, {
                    name: 'search',
                    source: function (query, processSync, processAsync) {
                        processSync([kossy_woo_options.empty_msg]);
                        $('.twitter-typeahead').addClass('loading');
                        return $.ajax({
                            url: kossy_woo_options.ajaxurl, 
                            type: 'GET',
                            data: {
                                's': query,
                                'category': $('.apus-search-form .dropdown_product_cat').val(),
                                'action': 'kossy_autocomplete_search'
                            },
                            dataType: 'json',
                            success: function (json) {
                                $('.twitter-typeahead').removeClass('loading');
                                return processAsync(json);
                            }
                        });
                    },
                    templates: {
                        empty : [
                            '<div class="empty-message">',
                            kossy_woo_options.empty_msg,
                            '</div>'
                        ].join('\n'),
                        suggestion: Handlebars.compile( kossy_woo_options.template )
                    },
                }
            );
            $('.apus-autocompleate-input').on('typeahead:selected', function (e, data) {
                e.preventDefault();
                setTimeout(function(){
                    $('.apus-autocompleate-input').val(data.title);    
                }, 5);
                
                return false;
            });
        },
        productDetail: function(){
            
            // review click link
            $('.woocommerce-review-link').on('click', function(){
                $('.woocommerce-tabs a[href="#tabs-list-reviews"]').trigger('click');
                $('html, body').animate({
                    scrollTop: $("#reviews").offset().top
                }, 1000);
                return false;
            });

            if ($('.details-product.layout-v4 .sticky-this').length > 0) {
                if ($(window).width() > 991) {
                    $('.details-product.layout-v4 .sticky-this').stick_in_parent({
                        parent: ".product-v-wrapper",
                        spacer: false,
                        offset_top: 100
                    });
                }
            }
            
        },
        initQuickview: function(){
            var self = this;
            $('a.quickview').on('click', function (e) {
                e.preventDefault();
                var $self = $(this);
                $self.parent().parent().parent().addClass('loading');
                var product_id = $(this).data('product_id');
                var url = kossy_woo_options.ajaxurl + '?action=kossy_quickview_product&product_id=' + product_id;
                
                $.get(url,function(data,status){
                    $.magnificPopup.open({
                        mainClass: 'apus-mfp-zoom-in apus-quickview',
                        items : {
                            src : data,
                            type: 'inline'
                        }
                    });
                    // variation
                    if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
                        $( '.variations_form' ).each( function() {
                            $( this ).wc_variation_form().find('.variations select:eq(0)').trigger('change');
                        });
                    }

                    self.initSlick($(".quickview-slick"));

                    $self.parent().parent().parent().removeClass('loading');
                });
            });
        },
        initSidebar: function() {
            // view more categories
            $('.widget_product_categories ul.product-categories').each(function(e){
                var height = $(this).outerHeight();
                if ( height > 260 ) {
                    var view_more = '<a href="javascript:void(0);" class="view-more-list-cat view-more"><span>'+kossy_woo_options.view_more_text+'</span> <i class="fa fa-angle-double-right"></i></a>';
                    $(this).parent().append(view_more);
                    $(this).addClass('hideContent');
                }
            });

            $('body').on('click', '.view-more-list-cat', function() {
               
                var $this = $(this); 
                var $content = $this.parent().find(".product-categories"); 
                
                if ( $this.hasClass('view-more') ) {
                    var linkText = kossy_woo_options.view_less_text;
                    $content.removeClass("hideContent").addClass("showContent");
                    $this.removeClass("view-more").addClass("view-less");
                } else {
                    var linkText = kossy_woo_options.view_more_text;
                    $content.removeClass("showContent").addClass("hideContent");
                    $this.removeClass("view-less").addClass("view-more");
                };

                $this.find('span').text(linkText);
            });

            // view more for filter
            $('.woocommerce-widget-layered-nav-list').each(function(e){
                var height = $(this).outerHeight();
                if ( height > 260 ) {
                    var view_more = '<a href="javascript:void(0);" class="view-more-list view-more"><span>'+kossy_woo_options.view_more_text+'</span> <i class="fa fa-angle-double-right"></i></a>';
                    $(this).parent().append(view_more);
                    $(this).addClass('hideContent');
                }
            });

            $('body').on('click', '.view-more-list', function() {
               
                var $this = $(this); 
                var $content = $this.parent().find(".woocommerce-widget-layered-nav-list"); 
                
                if ( $this.hasClass('view-more') ) {
                    var linkText = kossy_woo_options.view_less_text;
                    $content.removeClass("hideContent").addClass("showContent");
                    $this.removeClass("view-more").addClass("view-less");
                } else {
                    var linkText = kossy_woo_options.view_more_text;
                    $content.removeClass("showContent").addClass("hideContent");
                    $this.removeClass("view-less").addClass("view-more");
                };

                $this.find('span').text(linkText);
            });
        },
        initSatches: function() {
            $( 'body' ).on( 'click', '.swatches-wrapper li a', function() {
                var $parent = $(this).closest('.product-block');
                var $image = $parent.find('.image img');
                
                if ( $(this).attr( 'data-image_src' ) ) {
                    $image.attr('src', $(this).attr( 'data-image_src' ) );
                }
                if ( $(this).attr( 'data-image_srcset' ) ) {
                    $image.attr('srcset', $(this).attr( 'data-image_srcset' ) );
                }
                if ( $(this).attr( 'data-image_sizes') ) {
                    $image.attr('sizes', $(this).attr( 'data-image_sizes' ) );
                }
            });
        },
        variationsImageUpdate: function( variation ) {
            var $form             = $('.variations_form'),
                $product          = $form.closest( '.product' ),
                $product_gallery  = $product.find( '.apus-woocommerce-product-gallery-wrapper' ),
                $gallery_img      = $product.find( '.apus-woocommerce-product-gallery-thumbs img:eq(0)' ),
                $product_img_wrap = $product_gallery.find( '.woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder' ).eq( 0 ),
                $product_img      = $product_img_wrap.find( '.wp-post-image' ),
                $product_link     = $product_img_wrap.find( 'a' ).eq( 0 );


            if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
                
                if ( $( '.apus-woocommerce-product-gallery-thumbs img[src="' + variation.image.thumb_src + '"]' ).length > 0 ) {
                    $( '.apus-woocommerce-product-gallery-thumbs img[src="' + variation.image.thumb_src + '"]' ).trigger( 'click' );
                    $form.attr( 'current-image', variation.image_id );
                    return;
                } else {
                    $product_img.wc_set_variation_attr( 'src', variation.image.src );
                    $product_img.wc_set_variation_attr( 'height', variation.image.src_h );
                    $product_img.wc_set_variation_attr( 'width', variation.image.src_w );
                    $product_img.wc_set_variation_attr( 'srcset', variation.image.srcset );
                    $product_img.wc_set_variation_attr( 'sizes', variation.image.sizes );
                    $product_img.wc_set_variation_attr( 'title', variation.image.title );
                    $product_img.wc_set_variation_attr( 'alt', variation.image.alt );
                    $product_img.wc_set_variation_attr( 'data-src', variation.image.full_src );
                    $product_img.wc_set_variation_attr( 'data-large_image', variation.image.full_src );
                    $product_img.wc_set_variation_attr( 'data-large_image_width', variation.image.full_src_w );
                    $product_img.wc_set_variation_attr( 'data-large_image_height', variation.image.full_src_h );
                    $product_img_wrap.wc_set_variation_attr( 'data-thumb', variation.image.src );
                    $gallery_img.wc_set_variation_attr( 'src', variation.image.thumb_src );
                    $gallery_img.wc_set_variation_attr( 'srcset', variation.image.thumb_srcset );

                    $product_link.wc_set_variation_attr( 'href', variation.image.full_src );
                    $gallery_img.removeAttr('srcset');
                    $('.apus-woocommerce-product-gallery').slick('slickGoTo', 0);
                    
                }
            } else {
                $product_img.wc_reset_variation_attr( 'src' );
                $product_img.wc_reset_variation_attr( 'width' );
                $product_img.wc_reset_variation_attr( 'height' );
                $product_img.wc_reset_variation_attr( 'srcset' );
                $product_img.wc_reset_variation_attr( 'sizes' );
                $product_img.wc_reset_variation_attr( 'title' );
                $product_img.wc_reset_variation_attr( 'alt' );
                $product_img.wc_reset_variation_attr( 'data-src' );
                $product_img.wc_reset_variation_attr( 'data-large_image' );
                $product_img.wc_reset_variation_attr( 'data-large_image_width' );
                $product_img.wc_reset_variation_attr( 'data-large_image_height' );
                $product_img_wrap.wc_reset_variation_attr( 'data-thumb' );
                $gallery_img.wc_reset_variation_attr( 'src' );
                $product_link.wc_reset_variation_attr( 'href' );
            }

            window.setTimeout( function() {
                $( window ).trigger( 'resize' );
                $form.wc_maybe_trigger_slide_position_reset( variation );
                $product_gallery.trigger( 'woocommerce_gallery_init_zoom' );
            }, 20 );
        },
        initFilter: function() {
            var self = this;
            self.filterScrollbarsInit();
            $('.apus-shop-header').on('click', '#apus-categories a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'));
            });
            $('.apus-shop-header').on('click', '.shop-top-sidebar-wrapper .widget_product_categories a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'));
            });
            $('.apus-shop-header').on('click', '.shop-top-sidebar-wrapper .woocommerce-widget-layered-nav-list a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'));
            });
            $('.apus-shop-header').on('click', '.shop-top-sidebar-wrapper .apus-price-filter a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'));
            });
            $('.apus-shop-header').on('click', '.shop-top-sidebar-wrapper .apus-product-sorting a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'));
            });
            $('.apus-shop-header').on('click', '.shop-top-sidebar-wrapper .widget_orderby a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'), false, true);
            });
            $('body').on('click', '.apus-results a', function(e){
                e.preventDefault();
                self.shopGetPage($(this).attr('href'), false, true);
            });

            // ajax pagination
            if ( $('.ajax-pagination').length ) {
                self.ajaxPaginationLoad();
            }

            // filter action
            $('body').on('click', '#apus-filter-menu .filter-action', function(e) {
                e.preventDefault();
                $('.apus-sidebar-header').slideToggle(300);
                if ( $(this).find('i').hasClass('icon-equalizer') ) {
                    $(this).find('i').removeClass('icon-equalizer').addClass('icon-close');
                } else {
                    $(this).find('i').removeClass('icon-close').addClass('icon-equalizer');
                }
                if ($('.apus-shop-header').hasClass('filter-active')) {
                    $('.apus-shop-header').removeClass('filter-active');
                } else {
                    $('.apus-shop-header').addClass('filter-active');
                }
            });
        },
        shopGetPage: function(pageUrl, isBackButton, isProductTag){
            var self = this;
            if (self.shopAjax) { return false; }
            
            if (pageUrl) {
                // Remove any visible shop notices
                //self.shopRemoveNotices();                                             
                
                // Set current shop URL (used to reset search and product-tag AJAX results)
                self.shopSetCurrentUrl(isProductTag);
                
                // Show 'loader' overlay
                self.shopShowLoader();
                
                // Make sure the URL has a trailing-slash before query args (301 redirect fix)
                pageUrl = pageUrl.replace(/\/?(\?|#|$)/, '/$1');
                
                // Set browser history "pushState" (if not back button "popstate" event)
                if (!isBackButton) {
                    self.setPushState(pageUrl);
                }
                
                self.shopAjax = $.ajax({
                    url: pageUrl,
                    data: {
                        load_type: 'full'
                    },
                    dataType: 'html',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    
                    method: 'POST', // Note: Using "POST" method for the Ajax request to avoid "load_type" query-string in pagination links
                    
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Apus: AJAX error - shopGetPage() - ' + errorThrown);
                        
                        // Hide 'loader' overlay (after scroll animation)
                        self.shopHideLoader();
                        
                        self.shopAjax = false;
                    },
                    success: function(response) {
                        // Update shop content
                        self.shopUpdateContent(response);
                        
                        self.shopAjax = false;
                    }
                });
                
            }
        },
        shopHideLoader: function(){
            $('body').find('#apus-shop-products-wrapper').removeClass('loading');
        },
        shopShowLoader: function(){
            $('body').find('#apus-shop-products-wrapper').addClass('loading');
        },
        setPushState: function(pageUrl) {
            window.history.pushState({apusShop: true}, '', pageUrl);
        },
        shopSetCurrentUrl: function(isProductTag) {
            var self = this;
            
            // Exclude product-tag page URL's
            if (!self.isProductTagUrl) {
                // Set current page URL
                self.searchAndTagsResetURL = window.location.href;
            }
            
            // Is the current URL a product-tag URL?
            self.isProductTagUrl = (isProductTag) ? true : false;
        },
        /**
         *  Shop: Update shop content with AJAX HTML
         */
        shopUpdateContent: function(ajaxHTML) {
            var self = this,
                $ajaxHTML = $('<div>' + ajaxHTML + '</div>'); // Wrap the returned HTML string in a dummy 'div' element we can get the elements
            
            // Page title - wp_title()
            var wpTitle = $ajaxHTML.find('#apus-wp-title').text();
            if (wpTitle.length) {
                // Update document/page title
                document.title = wpTitle;
            }
            
            // Extract elements
            var $categories = $ajaxHTML.find('#apus-categories'),
                $sidebar = $ajaxHTML.find('.shop-top-sidebar-wrapper'),
                $shop = $ajaxHTML.find('#apus-shop-products-wrapper');
                                            
            // Prepare/replace categories
            if ($categories.length) { 
                var $shopCategories = $('#apus-categories');
                
                $shopCategories.replaceWith($categories); 
            }
            // Prepare/replace sidebar filters
            if ($sidebar.length) {
                var $shopSidebar = $('.shop-top-sidebar-wrapper');
                $shopSidebar.replaceWith($sidebar);
                self.filterScrollbarsInit();
            }
            
            // Replace shop
            if ($shop.length) {
                $('#apus-shop-products-wrapper').replaceWith($shop);
            }

            // Load images (init Unveil)
            self.layzyLoadImage();
            // Isoto Load
            self.initIsotope();
            // paging
            self.ajaxPaginationLoad();

            setTimeout(function() {
                // Hide 'loader' overlay (after scroll animation)
                self.shopHideLoader();
            }, 100);
        },
        filterScrollbarsInit: function() {
            $('.apus-woocommerce-widget-layered-nav .dropdown-menu').perfectScrollbar();
            $('.apus-widget_price_filter .dropdown-menu').perfectScrollbar();
            $('.apus_widget_product_sorting .dropdown-menu').perfectScrollbar();
        },
        /**
         *  Shop: Initialize infinite load
         */
        ajaxPaginationLoad: function() {
            var self = this,
                $infloadControls = $('.ajax-pagination'),                   
                nextPageUrl;
            
            // Used to check if "infload" needs to be initialized after Ajax page load
            self.shopInfLoadBound = true;
            
            
            self.infloadScroll = ($infloadControls.hasClass('infinite-action')) ? true : false;
            
            if (self.infloadScroll) {
                self.infscrollLock = false;
                
                var pxFromWindowBottomToBottom,
                    pxFromMenuToBottom = Math.round($(document).height() - $infloadControls.offset().top);
                    //bufferPx = 0;
                
                /* Bind: Window resize event to re-calculate the 'pxFromMenuToBottom' value (so the items load at the correct scroll-position) */
                var to = null;
                $(window).resize(function() {
                    if (to) { clearTimeout(to); }
                    to = setTimeout(function() {
                        pxFromMenuToBottom = Math.round($(document).height() - $infloadControls.offset().top);
                    }, 100);
                });
                
                $(window).scroll(function(){
                    if (self.infscrollLock) {
                        return;
                    }
                    
                    pxFromWindowBottomToBottom = 0 + $(document).height() - ($(window).scrollTop()) - $(window).height();
                    
                    // If distance remaining in the scroll (including buffer) is less than the pagination element to bottom:
                    if ((pxFromWindowBottomToBottom/* - bufferPx*/) < pxFromMenuToBottom) {
                        self.ajaxPaginationGet();
                    }
                });
            } else {
                var $productsWrap = $('body');
                
                /* Bind: "Load" button */
                $productsWrap.on('click', '#apus-shop-products-wrapper .apus-loadmore-btn', function(e) {
                    e.preventDefault();
                    self.ajaxPaginationGet();
                });
                
            }
            
            if (self.infloadScroll) {
                $(window).trigger('scroll'); // Trigger scroll in case the pagination element (+buffer) is above the window bottom
            }
        },
        /**
         *  Shop: AJAX load next page
         */
        ajaxPaginationGet: function() {
            var self = this;
            
            if (self.shopAjax) return false;
            
            // Remove any visible shop notices
            //self.shopRemoveNotices();
            
            // Get elements (these can be replaced with AJAX, don't pre-cache)
            var $nextPageLink = $('.apus-pagination-next-link').find('a'),
                $infloadControls = $('.ajax-pagination'),
                nextPageUrl = $nextPageLink.attr('href');
            
            if (nextPageUrl) {
                //nextPageUrl = self.updateUrlParameter(nextPageUrl, 'load_type', 'products');
                
                // Show 'loader'
                $infloadControls.addClass('apus-loader');
                
                self.shopAjax = $.ajax({
                    url: nextPageUrl,
                    data: {
                        load_type: 'products'
                    },
                    dataType: 'html',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    method: 'GET',
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('APUS: AJAX error - ajaxPaginationGet() - ' + errorThrown);
                    },
                    complete: function() {
                        // Hide 'loader'
                        $infloadControls.removeClass('apus-loader');
                    },
                    success: function(response) {
                        var $response = $('<div>' + response + '</div>'), $moreProducts = $response.children('.apus-products');
                        // add new products
                        var $layout_type =  $('.apus-shop-products-wrapper').data('layout_type');
                        if ( $layout_type == 'mansory-v1' || $layout_type == 'mansory-v2' ) {
                            var $new = $moreProducts.find('.isotope-item').appendTo($('.apus-shop-products-wrapper .products .isotope-items'));
                            
                            setTimeout(function(){
                                $('.apus-shop-products-wrapper').find('.isotope-items').isotope( 'insert', $new );    
                            }, 50);
                            
                        } else {
                            $('.apus-shop-products-wrapper .products .row-products-wrapper').append($moreProducts.html());
                        }
                        
                        // Load images (init Unveil)
                        self.layzyLoadImage();
                        
                        // Get the 'next page' URL
                        nextPageUrl = $response.find('.apus-pagination-next-link').children('a').attr('href');
                        
                        if (nextPageUrl) {
                            $nextPageLink.attr('href', nextPageUrl);
                        } else {
                            $('.apus-shop-products-wrapper').addClass('all-products-loaded');
                            
                            if (self.infloadScroll) {
                                self.infscrollLock = true; // "Lock" scroll (no more products/pages)
                            }
                            $infloadControls.find('.apus-loadmore-btn').addClass('hidden');
                            $nextPageLink.removeAttr('href');
                        }
                        
                        self.shopAjax = false;
                        
                        if (self.infloadScroll) {
                            $(window).trigger('scroll'); // Trigger 'scroll' in case the pagination element (+buffer) is still above the window bottom
                        }
                    }
                });
            } else {
                if (self.infloadScroll) {
                    self.infscrollLock = true; // "Lock" scroll (no more products/pages)
                }
            }
        }
    });

    $.apusThemeExtensions.shop = $.apusThemeCore.woo_init;


    // gallery

    var ApusProductGallery = function( $target, args ) {
        var self = this;
        this.$target = $target;
        this.$images = $( '.woocommerce-product-gallery__image', $target );

        // No images? Abort.
        if ( 0 === this.$images.length ) {
            this.$target.css( 'opacity', 1 );
            return;
        }

        // Make this object available.
        $target.data( 'product_gallery', this );

        // Pick functionality to initialize...
        this.zoom_enabled       = $.isFunction( $.fn.zoom ) && wc_single_product_params.zoom_enabled;
        this.photoswipe_enabled = typeof PhotoSwipe !== 'undefined' && wc_single_product_params.photoswipe_enabled;

        // ...also taking args into account.
        if ( args ) {
            this.zoom_enabled       = false === args.zoom_enabled ? false : this.zoom_enabled;
            this.photoswipe_enabled = false === args.photoswipe_enabled ? false : this.photoswipe_enabled;
        }

        

        // Bind functions to this.
        this.initZoom             = this.initZoom.bind( this );
        this.initZoomForTarget    = this.initZoomForTarget.bind( this );
        this.initPhotoswipe       = this.initPhotoswipe.bind( this );
        this.getGalleryItems      = this.getGalleryItems.bind( this );
        this.openPhotoswipe       = this.openPhotoswipe.bind( this );

            this.$target.css( 'opacity', 1 );

        if ( this.zoom_enabled ) {
            this.initZoom();
            $target.on( 'woocommerce_gallery_init_zoom', this.initZoom );
        }

        if ( this.photoswipe_enabled ) {
            this.initPhotoswipe();
        }

        $('.apus-woocommerce-product-gallery').on('beforeChange', function(event, slick, currentSlide, nextSlide){
            self.initZoomForTarget( self.$images.eq(nextSlide) );
        });
    };


    /**
     * Init zoom.
     */
    ApusProductGallery.prototype.initZoom = function() {
        if ( $('.details-product.layout-v4').length > 0 ) {
            this.initZoomForTarget(this.$images);
        } else {
            this.initZoomForTarget( this.$images.first() );
        }
    };

    /**
     * Init zoom.
     */
    ApusProductGallery.prototype.initZoomForTarget = function( zoomTarget ) {
        if ( ! this.zoom_enabled ) {
            return false;
        }

        var galleryWidth = this.$target.width(),
            zoomEnabled  = false;

        $( zoomTarget ).each( function( index, target ) {
            var image = $( target ).find( 'img' );

            if ( image.data( 'large_image_width' ) > galleryWidth ) {
                zoomEnabled = true;
                return false;
            }
        } );

        // But only zoom if the img is larger than its container.
        if ( zoomEnabled ) {
            var zoom_options = {
                touch: false
            };

            if ( 'ontouchstart' in window ) {
                zoom_options.on = 'click';
            }

            zoomTarget.trigger( 'zoom.destroy' );
            zoomTarget.zoom( zoom_options );
        }
    };

    /**
     * Init PhotoSwipe.
     */
    ApusProductGallery.prototype.initPhotoswipe = function() {
        if ( this.zoom_enabled && this.$images.length > 0 ) {
            this.$target.prepend( '<a href="#" class="woocommerce-product-gallery__trigger"><i class="fa fa-search-plus" aria-hidden="true"></i></a>' );
            this.$target.on( 'click', '.woocommerce-product-gallery__trigger', this.openPhotoswipe );
        }
        this.$target.on( 'click', '.woocommerce-product-gallery__image a', this.openPhotoswipe );
    };

    /**
     * Get product gallery image items.
     */
    ApusProductGallery.prototype.getGalleryItems = function() {
        var $slides = this.$images,
            items   = [];

        if ( $slides.length > 0 ) {
            $slides.each( function( i, el ) {
                var img = $( el ).find( 'img' ),
                    large_image_src = img.attr( 'data-large_image' ),
                    large_image_w   = img.attr( 'data-large_image_width' ),
                    large_image_h   = img.attr( 'data-large_image_height' ),
                    item            = {
                        src  : large_image_src,
                        w    : large_image_w,
                        h    : large_image_h,
                        title: img.attr( 'data-caption' ) ? img.attr( 'data-caption' ) : img.attr( 'title' )
                    };
                items.push( item );
            } );
        }

        return items;
    };

    /**
     * Open photoswipe modal.
     */
    ApusProductGallery.prototype.openPhotoswipe = function( e ) {
        e.preventDefault();

        var pswpElement = $( '.pswp' )[0],
            items       = this.getGalleryItems(),
            eventTarget = $( e.target ),
            clicked;

        if ( this.$target.find( '.woocommerce-product-gallery__image.slick-current' ).length > 0 ) {
            clicked = this.$target.find( '.woocommerce-product-gallery__image.slick-current' );
        } else {
            clicked = eventTarget.closest( '.woocommerce-product-gallery__image' );
        }
        var options = $.extend( {
            index: $( clicked ).index()
        }, wc_single_product_params.photoswipe_options );

        // Initializes and opens PhotoSwipe.
        var photoswipe = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options );
        photoswipe.init();
    };

    /**
     * Function to call wc_product_gallery on jquery selector.
     */
    $.fn.apus_wc_product_gallery = function( args ) {
        new ApusProductGallery( this, args );
        return this;
    };

    /*
     * Initialize all galleries on page.
     */
    $( '.apus-woocommerce-product-gallery-wrapper' ).each( function() {
        $( this ).apus_wc_product_gallery();
    } );

    
})(jQuery);
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires+";path=/";
}