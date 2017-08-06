
(function(){

		var getTriggerElement = function(el){
			var isCollapse = el.getAttribute('data-collapse');

			if(isCollapse!== null){
				return el;
			}else{
				var isParrentCollapse = el.parentNode.getAttribute('data-collapse');

				return(isParrentCollapse !== null) ? el.parentNode : undefined;
			}
		};
		var collapseClickHundler = function(event){

			var triggerEl = getTriggerElement(event.target);

			if(triggerEl === undefined){

				return false;

			}else{
				event.preventDefault();
			}


			var targetEl = document.querySelector(triggerEl.getAttribute('data-target'));
		if (targetEl) {

			triggerEl.classList.toggle('-active');
			targetEl.classList.toggle('-on');
		}
		};

			document.addEventListener('click',collapseClickHundler,false);
	})(document,window);


$(document).ready(function(){
    $(".button a").click(function(){
        $(".overlay").fadeToggle(200);
       $(this).toggleClass('btn-open').toggleClass('btn-close');
    });
});
$('.overlay').on('click', function(){
    $(".overlay").fadeToggle(200);   
    $(".button a").toggleClass('btn-open').toggleClass('btn-close');
    open = false;
});

var TxtRotate = function(el, toRotate, period) {
  this.toRotate = toRotate;
  this.el = el;
  this.loopNum = 0;
  this.period = parseInt(period, 10) || 2000;
  this.txt = '';
  this.tick();
  this.isDeleting = false;
};

TxtRotate.prototype.tick = function() {
  var i = this.loopNum % this.toRotate.length;
  var fullTxt = this.toRotate[i];

  if (this.isDeleting) {
    this.txt = fullTxt.substring(0, this.txt.length - 1);
  } else {
    this.txt = fullTxt.substring(0, this.txt.length + 1);
  }

  this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

  var that = this;
  var delta = 300 - Math.random() * 100;

  if (this.isDeleting) { delta /= 2; }

  if (!this.isDeleting && this.txt === fullTxt) {
    delta = this.period;
    this.isDeleting = true;
  } else if (this.isDeleting && this.txt === '') {
    this.isDeleting = false;
    this.loopNum++;
    delta = 500;
  }

  setTimeout(function() {
    that.tick();
  }, delta);
};

// Normal Clicks
$(function() {
  $('#responsrightTitle').click(function() {
    $('#asideRight').toggleClass('asideRight');
     return false;
  });
    $(".closeasideRight").click(function () {
        $('#asideRight').removeClass('asideRight');
        return false;
    })

});


// Toggle with hitting of ESC
$(document).keyup(function(e) {
  if (e.keyCode == 27) {
   $('body').removeClass('show-nav');
  }
});
$(function() {
  $('#responsleftTitle').click(function() {
    $('#asideLeft').toggleClass('asideLeft');
     return false;
  });
 $(".closeaside").click(function () {
     $('#asideLeft').removeClass('asideLeft');
     return false;
 })
  
});


// Toggle with hitting of ESC
$(document).keyup(function(e) {
  if (e.keyCode == 27) {
   $('body').removeClass('show_block');
  }
});


(function() {
        var isSafari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/);
        if(isSafari) {
          document.getElementById('support-note').style.display = 'block';
        }
      })();

$(function(){
  $('.sale').click(function(){
  $("#box").toggleClass('showBanner');
  return false;
});
})


$(document).ready(function()  {
    $(window).resize(function(){
        var windSize =  $(window).width();
        if (windSize<800) {
            $('#asideRight').removeClass('effect6');


        }if(windSize<800){
            $('#asideLeft').removeClass('effect6');


        }if(windSize>800){
            $('#asideRight').addClass('effect6');

        }if(windSize>800) {
            $('#asideLeft').addClass('effect6');

        }

        });
});




// add class bottom main

$(window).ready(function(){
    $('.mainBootoom').children('li').addClass('button button--antiman button--inverted button--border-thin button--text-thick button--size-m');
  });

$(window).ready(function(){
    $('a').addClass('effect-shine');
  });
$(document).ready(function () {
    $('.buttom_row').find('a').addClass('button button--nuka');
    return false;
});
(function() {
        var docElem = window.document.documentElement, didScroll, scrollPosition;

        // trick to prevent scrolling when opening/closing button
        function noScrollFn() {
          window.scrollTo( scrollPosition ? scrollPosition.x : 0, scrollPosition ? scrollPosition.y : 0 );
        }

        function noScroll() {
          window.removeEventListener( 'scroll', scrollHandler );
          window.addEventListener( 'scroll', noScrollFn );
        }

        function scrollFn() {
          window.addEventListener( 'scroll', scrollHandler );
        }

        function canScroll() {
          window.removeEventListener( 'scroll', noScrollFn );
          scrollFn();
        }

        function scrollHandler() {
          if( !didScroll ) {
            didScroll = true;
            setTimeout( function() { scrollPage(); }, 60 );
          }
        };

        function scrollPage() {
          scrollPosition = { x : window.pageXOffset || docElem.scrollLeft, y : window.pageYOffset || docElem.scrollTop };
          didScroll = false;
        };

        scrollFn();

        [].slice.call( document.querySelectorAll( '.morph-button' ) ).forEach( function( bttn ) {
          new UIMorphingButton( bttn, {
            closeEl : '.icon-close',
            onBeforeOpen : function() {
              // don't allow to scroll
              noScroll();
            },
            onAfterOpen : function() {
              // can scroll again
              canScroll();
            },
            onBeforeClose : function() {
              // don't allow to scroll
              noScroll();
            },
            onAfterClose : function() {
              // can scroll again
              canScroll();
            }
          } );
        } );

        // for demo purposes only
        [].slice.call( document.querySelectorAll( 'form button' ) ).forEach( function( bttn ) { 
          bttn.addEventListener( 'click', function( ev ) { ev.preventDefault(); } );
        } );
      })();
// gallery

    new CBPGridpageGallery( document.getElementById( 'grid-gallery' ) );





