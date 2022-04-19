function Epiqk() {

  this.consts = {
    namespace: 'epiqk',
    breakpoints: {
      no: 0, 
      xs: 480,
      sm: 600,
      md: 782,
      lg: 960,
      xl: 1080,
      xxl: 1280,
      xxxl: 1440
    },
    breakpoint: 'md',
    breakpointNav: 'xl',
    transition: {
      fast: 275,
      medium: 400,
      slow: 650
    }
  };
  
  this.viewPort = {
    width: document.documentElement.clientWidth,
    height: document.documentElement.clientHeight,
    scrollBarY: window.innerWidth - document.documentElement.clientWidth,
    scrollBarX: window.innerHeight - document.documentElement.clientHeight,
  };
  this.uniqueIdLast = 0;
  
  this.header = {
    obj: document.querySelector( 'header.page-header' ),
    height: {
      no: 100,
      md: 110
    }
  }
  
  this.windowPageYOffsetLast = 0;
  
  this.sections = document.querySelectorAll( '.page-section' );
  
  var st = this;
  this.isSmallScreen = function( breakpoint ) {
    breakpoint = breakpoint || st.consts.breakpoint;
    return ( st.consts.breakpoints[ breakpoint ] > st.viewPort.width );
  };
  this.isSmallScreenNav = function() {
    return ( st.consts.breakpoints[ st.consts.breakpointNav ] > st.viewPort.width );
  };
  
  this.resize = function() {
    
    st.viewPort.width = document.documentElement.clientWidth;
    st.viewPort.height = document.documentElement.clientHeight;
    
    document.documentElement.style.setProperty('--vh',st.viewPort.height*.01+'px');
    document.documentElement.style.setProperty('--vw',st.viewPort.width*.01+'px');
    
    for ( var i = 0; i < this.sections.length; i++ ) {
      this.sections[i].style.width = st.viewPort.width + 'px';
    }
    
  };

  this.uniqueId = function( prefix ) {
    
    var id = '' + ++st.uniqueIdLast;
    return prefix ? prefix + id : 'ep-' + id;
  };
    
  function init() {
    
    if ( window.st ) return false;
    
    document.documentElement.classList.add('ep-initialized');
    if ( 'ontouchstart' in document.documentElement ) document.documentElement.classList.add('ep-touch');
    if ( st.header.height.md <= window.pageYOffset ) document.documentElement.classList.add('ep-scrolling');
    
    st.resize();
    
    return true;
  }
  init();
  
  window.st = window.st || this;
  
}
new Epiqk();

( function( $ ) {

  $( document ).ready( function() {

    st.resize();
      
    st.windowPageYOffsetLast = window.pageYOffset;

    $('.wp-block-cover > span[class*="has-background"]').each( function() {
      this.parentNode.className += ' ' + this.className;
      this.style.display = 'none';
    } );
    
    $(window).on( 'load', function() {

    } ).on( 'resize orientationchange', function() {

      st.resize();
      // if ( document.documentElement.classList.contains( 'toggle-main-nav' ) && !st.isSmallScreenNav() ) document.documentElement.classList.remove( 'toggle-main-nav' );

      if ( !st.isSmallScreenNav() ) {
        document.documentElement.classList.remove( 'toggle-main-nav', 'animate' );
      }
      
    } ).on( 'scroll', function( e ) {

      if ( 0 === window.pageYOffset ) document.documentElement.classList.remove( 'is-scrolling' );
      else document.documentElement.classList.add( 'is-scrolling' );

      if ( 0 === window.pageYOffset || st.windowPageYOffsetLast < window.pageYOffset ) document.documentElement.classList.remove( 'is-scrolling-up' );
      else document.documentElement.classList.add( 'is-scrolling-up' );

      st.windowPageYOffsetLast = window.pageYOffset;

      if ( 150 < window.pageYOffset ) {
        document.documentElement.classList.add('scrolled');
      } else {
        document.documentElement.classList.remove('scrolled');
      }

    } ).on( 'hashchange', function( e ) {
      
      if ( window.location.hash.match( /^#?!\// ) ) {
        
        e.preventDefault();
        st.hashParts = window.location.hash.replace( /\/$/, '').split('/');
        
        if ( 'string' === typeof st.hashParts[1] ) {
          
          if ( 'top' === st.hashParts[1] ) {
            
            $( 'html, body' ).stop( true ).animate( { scrollTop: 0 }, st.consts.transition.slow );
            if ( 'replaceState' in history ) history.replaceState( undefined, document.title, window.location.pathname );
            
          } else if ( 'undefined' === typeof st.hashParts[2] && $( '#' + st.hashParts[1] ).length ) {
            
            var $target = $( '#' + st.hashParts[1] );
            $('html, body').stop( true ).animate( { scrollTop: $target.offset().top }, st.consts.transition.slow, function() {
              
            } );
          
          } else if ( st.hashParts[1].length && 'string' === typeof st.hashParts[2] ) {
            
            if ( 0 < st.hashParts[2].length ) {
              
              switch( st.hashParts[1] ) {
                case '':                
                  break;
              }

            }

          }

          if ( document.documentElement.classList.contains( 'toggle-main-nav' ) ) document.documentElement.classList.remove( 'toggle-main-nav' );
          
        }
        return false;
      }
      
    } ).trigger( 'scroll' );
    if ( window.location.hash.length ) $( window ).trigger( 'hashchange' );

    $( '#toggle-main-nav' ).on( 'click', function( e ) {
      
      e.preventDefault();
      
      if ( document.documentElement.classList.contains( this.id ) ) {
        document.documentElement.classList.remove( 'animate' );
        document.documentElement.classList.remove( this.id );
        document.getElementById( this.id ).setAttribute('aria-expanded', false);
      } else {
        document.documentElement.classList.add( this.id );
        document.getElementById( this.id ).setAttribute('aria-expanded', true);
        setTimeout(function() {
          document.documentElement.classList.add( 'animate' );
        }, 150);
      }
      
    } );

    var submenus = document.body.querySelectorAll('.menu-item-has-children');
    for (var i = 0; i < submenus.length; i++) {
      submenus[i].addEventListener('click', function(e){
        if ( $(this).hasClass('sub-menu-toggled') ) {
          $(this).removeClass('sub-menu-toggled');
        } else {
          $(this).addClass('sub-menu-toggled');
        }
      }); 
    }

    const $menuItemContainers = $('#menu-primary > li');
    let $prevDelay = 0.15;

    $menuItemContainers.each(function() {
      $(this).css('transition-delay', `${$prevDelay}s`);
      $prevDelay += 0.15;
    });

    const $heroItems = $('.wp-block-cover.is-style-hero > div.wp-block-cover__inner-container > *, .wp-block-cover.is-style-hero-inside > div > *');
    let $heroDelay = 0.25;
    $('.is-style-hero').addClass('animate');
    $('.is-style-hero-inside').addClass('animate');

    $heroItems.each(function() {
      $(this).css('transition-delay', `${$heroDelay}s`);
      $heroDelay += 0.25;
    });

    $('.is-style-woodgrain-bg').each(function() {
      if($(this).hasClass('bg-3')) {
        $(this).prepend('<img src="/wp-content/themes/epiqk/assets/images/grain-bg-3-min.png" class="bg-image">')
      } else if ($(this).hasClass('bg-alt')) {
        $(this).prepend('<img src="/wp-content/themes/epiqk/assets/images/grain-bg-2-min.png" class="bg-image">')
      } else {
        $(this).prepend('<img src="/wp-content/themes/epiqk/assets/images/grain-bg-min.png" class="bg-image">')
      }
    });

    $('.is-style-dotted-bg').each(function() {
      $(this).prepend('<img src="/wp-content/themes/epiqk/assets/images/dotted-bg-min.png" class="bg-image">')
    });

    $('.search-bar__subtract').each(function() {
      $(this).on('click', function(e) {
        e.preventDefault();
        const input = $(this).parent().children('input');
        const min = parseInt(input.attr('min'));
        let value = 1;

        if(input.val()) {
          value = parseInt(input.val());
        } else {
          input.val(1)
        }

        if(value - 1 >= min) {
          input.val(value - 1);
        }
      });
    });

    $('.search-bar__plus').each(function() {
      $(this).on('click', function(e) {
        e.preventDefault();
        const input = $(this).parent().children('input');
        // const max = parseInt(input.attr('max'));
        let value = 1;
        if(input.val()) {
          value = parseInt(input.val());
        } else {
          input.val(1)
        }
        // if(value + 1 <= max) {
          input.val(value + 1);
        // }
        
      });
    });

    $('#search-bar').find('input[type=submit').on('click', function(e) {
      e.preventDefault();
      const $this = $('#search-bar');
      let guests = encodeURIComponent($this.find('#beds').val());
      const arrival = encodeURIComponent($this.find('#arrival').val());
      const departure = encodeURIComponent($this.find('#departure').val());
      const city = encodeURIComponent($this.find('#city').val());
      const propid = encodeURIComponent($this.find('#propid').val());

      if(!parseInt(guests)) {
        guests = 1;
      }

      window.open(`https://booking.hscr.com/irmng/index.html?target=availability&locationcode=${city}&arrival=${arrival}&departure=${departure}&people1=${guests}&roomnum=${propid}`, '_blank');
      // $('#search-bar').submit();
    });

    $('.frm_form_field > select').each(function() {
      $(this).parent().addClass('select-container');
    });

    $('.frm_form_field > textarea').each(function() {
      $(this).parent().addClass('textarea-container');
    });

    //accordions
    const $accordions = $('.accordion__item');

    $accordions.each(function() {
      const $this = $(this);

      const $content = $this.find('.accordion__item__content');
      $content.slideUp();

      $this.find('button').on('click', function(e) {
        e.preventDefault();
        if(!$this.hasClass('toggled')) {
          setTimeout(function() {
            $this.addClass('toggled');
            $content.slideDown();
          }, 300);
        } 
        closeAccordions();
      });
    });

    const closeAccordions = () => {
      $accordions.each(function() {
        const $this = $(this);
        $this.removeClass('toggled');
        $this.find('.accordion__item__content').slideUp();
      });
    }

    //lity on video link//
    $('.wp-block-button__link').each( function() {
      var is_video = false;
      if ( 'string' === typeof this.href ) {
        if ( -1 !== this.href.indexOf( 'youtu.be' ) ) is_video = true;
        // if ( -1 !== this.href.indexOf( '.youtube.' ) ) is_video = true;
        if ( -1 !== this.href.indexOf( '.mp4' ) ) is_video = true;
        if ( -1 !== this.className.indexOf( 'button-video' ) ) is_video = true;
        if ( -1 !== this.parentNode.className.indexOf( 'button-video' ) ) is_video = true;
      }
      if ( true === is_video && 'function' === typeof lity ) {
        if ( -1 === this.className.indexOf( 'button-video' ) ) this.className += ' button-video';
        this.setAttribute( 'data-lity-extra' , 'true' );
      }
    } );
    $( document ).on( 'click', '[data-lity-extra]', lity);

    //parallax

    //   $(function() {
    //     var $el = $('.parallax-background');
    //     $(window).on('scroll', function () {
    //         var scroll = $(document).scrollTop();
    //         $el.css({
    //             'background-position':'50% '+(-.125*scroll)+'px'
    //         });
    //     });
    // });


    //form with google recaptcha v3

    // $( 'footer.page-footer form' ).on( 'submit', function( e ) {
    //   e.preventDefault();
  
    //   var $this = $(this);
        
    //   if ( !$this.children( 'input[type="email"]' ).val().length || -1 === $this.children( 'input[type="email"]' ).val().indexOf('@') ) return false;

    //   grecaptcha.ready(function() {
    //     grecaptcha.execute('_SITE KEY HERE_', {action: 'footer_signup'}).then(function(token) {
          
    //           $('#footer-form').prepend('<input type="hidden" name="token" value="' + token + '">');
    //           $('#footer-form').prepend('<input type="hidden" name="action" value="footer_signup">');
              
    //           var post = $.ajax({
    //             type: 'POST',
    //             url: '/wp-json/' + st.consts.namespace + '/v1/signup',
    //             data: { token: $this.find('input[name="token"]').val(), action: $this.find('input[name="action"]').val(),  email: $this.find( 'input[type="email"]' ).val() },
    //             dataType: 'json'
    //           });
              
    //           post.done( function() {
    //             var $response = $( '<form><p>Thanks for subscribing!</p></form>' );
    //             $this.replaceWith( $response );
    //             setTimeout( function() {
    //               $response.fadeOut( 625, function() {
    //                 $(this).remove();
    //               } );
    //             }, 10000 );
    //           })
    //           .fail( function() {
    //             $this.replaceWith( '<form><p>Error processing subscription! Please <a href="/connect/">contact us</a></p></form>' );
    //           })
    //       });
    //   });      
    //   return false;
    // } );

    //load more posts
    $( '.next-page-link-wrapper > a' ).on( 'click', function( event ) {
      event.preventDefault();

      var $this = $(this), _this = this, pageCurrent = 1;

      if ( _this.classList.contains( 'rest-initialized' ) ) return false;
      _this.classList.add( 'rest-initialized' );

      if ( this.parentElement.dataset.pageCurrent ) pageCurrent = parseInt( _this.parentElement.dataset.pageCurrent );

      var restUrl = '/wp-json/wp/v2/posts?';
      if ( _this.parentElement.dataset.perPage ) restUrl = restUrl + 'per_page=' + _this.parentElement.dataset.perPage + '&';
      if ( _this.dataset.exclude ) restUrl = restUrl + 'exclude=' + _this.dataset.exclude + '&';
      if ( _this.dataset.term ) restUrl = restUrl + 'categories=' + _this.dataset.term + '&';

      $.ajax({
        url: restUrl + 'page=' + ( pageCurrent + 1 ),
        method: 'GET',
        beforeSend: function(xhr){

          $this.addClass( 'rest-running' );
          //xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );

        }
      }).done( function( data, textStatus, jqXHR ) {

        pageCurrent++

        if ( data.length ) {

          for ( var i = 0; i < data.length; i++ ) {

            let template = document.createElement( 'template' );
            template.innerHTML = data[i].card;

            let card = template.content.firstChild;
            card.classList.add( 'observing' );

            _this.parentElement.parentElement.getElementsByTagName('ul')[0].appendChild(
              template.content.firstChild,

            );

            window.setTimeout( function() { card.classList.add( 'intersected' ); }, 75 + ( i * 125 ) );

          }

        }

        if ( parseInt( jqXHR.getResponseHeader( 'x-wp-totalpages' ) ) > pageCurrent ) {
          _this.parentElement.dataset.pageCurrent = pageCurrent;
        } else {
          _this.parentNode.removeChild( _this );
        }

        // _this.dataset.pageCurrent = pageCurrent + 1;
        
      }).fail( function( jqXHR, textStatus, errorThrown ) {

        _this.parentNode.removeChild( _this );

      } ).always( function( data_or_jqXHR, textStatus, jqXHR_or_errorThrown ) {

        _this.classList.remove( 'rest-initialized' );
        _this.classList.remove( 'rest-running' );

      } );

    } ).text( 'Load More' );



    if ( 'IntersectionObserver' in window ) {
  
      var observeSection = new IntersectionObserver( function( entries ) {
        
        entries.forEach( function( entry ) {
        
          var content = entry.target;
          if ( entry.isIntersecting ) {
            
            content.classList.add( 'intersected' );
            content.classList.add( 'intersecting' );
            
          } else {
            
            content.classList.remove( 'intersecting' );

            if ( content.classList.contains( 'intersected' ) ) observeSection.unobserve( content );
            
          }
          
        });
        
      }, {
        threshold: 0.01
      });
      
      var contentNodes = document.querySelectorAll( '.content, .wp-block-column > *:not(div), .wp-block-button, .wp-block-group__inner-container > *:not(div), .wp-block-image:not(.footer__branding) > figure, .wp-block-media-text__content > *:not(div), .wp-block-media-text__media > img, .location, .wp-block-cover:not(.is-style-hero):not(.is-style-hero-inside) > div > *:not(div)' );
      for( var i = 0; i < contentNodes.length; i++ ) {
        contentNodes[i].classList.add( 'observing' );
        observeSection.observe( contentNodes[i] );
      }
      
    }
      
  } );

} )( jQuery );
