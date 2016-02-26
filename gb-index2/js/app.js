// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();

function tamingselect() {
  if (!document.getElementById && !document.createTextNode) {
    return;
  }
  // Classes for the link and the visible dropdown
  var ts_selectclass = 'turnintodropdown_demo2'; // class to identify selects
  var ts_listclass = 'turnintoselect_demo2'; // class to identify ULs
  var ts_boxclass = 'dropcontainer_demo2'; // parent element
  var ts_triggeron = 'activetrigger_demo2'; // class for the active trigger link
  var ts_triggeroff = 'trigger_demo2'; // class for the inactive trigger link
  var ts_dropdownclosed = 'dropdownhidden_demo2'; // closed dropdown
  var ts_dropdownopen = 'dropdownvisible_demo2'; // open dropdown
  /*

	Turn all selects into DOM dropdowns

*/
  var count = 0;
  var toreplace = new Array();
  var sels = document.getElementsByTagName('select');
  for (var i = 0; i < sels.length; i++) {
    if (ts_check(sels[i], ts_selectclass)) {
      var hiddenfield = document.createElement('input');
      hiddenfield.name = sels[i].name;
      hiddenfield.type = 'hidden';
      hiddenfield.id = sels[i].id;
      hiddenfield.value = sels[i].options[0].value;
      sels[i].parentNode.insertBefore(hiddenfield, sels[i])
      var trigger = document.createElement('a');
      ts_addclass(trigger, ts_triggeroff);
      trigger.href = '#';
      trigger.onclick = function() {
        ts_swapclass(this, ts_triggeroff, ts_triggeron)
        ts_swapclass(this.parentNode.getElementsByTagName('ul')[0],
          ts_dropdownclosed, ts_dropdownopen);
        return false;
      }
      trigger.appendChild(document.createTextNode(sels[i].options[0].text));
      sels[i].parentNode.insertBefore(trigger, sels[i]);
      var replaceUL = document.createElement('ul');
      for (var j = 0; j < sels[i].getElementsByTagName('option').length; j++) {
        var newli = document.createElement('li');
        var newa = document.createElement('a');
        newli.v = sels[i].getElementsByTagName('option')[j].value;
        newli.elm = hiddenfield;
        newli.istrigger = trigger;
        newa.href = '#';
        newa.appendChild(document.createTextNode(sels[i].getElementsByTagName(
          'option')[j].text));
        newli.onclick = function() {
          this.elm.value = this.v;
          ts_swapclass(this.istrigger, ts_triggeron, ts_triggeroff);
          ts_swapclass(this.parentNode, ts_dropdownopen, ts_dropdownclosed)
          this.istrigger.firstChild.nodeValue = this.firstChild.firstChild.nodeValue;
          return false;
        }
        newli.appendChild(newa);
        replaceUL.appendChild(newli);
      }
      ts_addclass(replaceUL, ts_dropdownclosed);
      var div = document.createElement('div');
      div.appendChild(replaceUL);
      ts_addclass(div, ts_boxclass);
      sels[i].parentNode.insertBefore(div, sels[i])
      toreplace[count] = sels[i];
      count++;
    }
  }
  /*

	Turn all ULs with the class defined above into dropdown navigations

*/
  var uls = document.getElementsByTagName('ul');
  for (var i = 0; i < uls.length; i++) {
    if (ts_check(uls[i], ts_listclass)) {
      var newform = document.createElement('form');
      var newselect = document.createElement('select');
      for (j = 0; j < uls[i].getElementsByTagName('a').length; j++) {
        var newopt = document.createElement('option');
        newopt.value = uls[i].getElementsByTagName('a')[j].href;
        newopt.appendChild(document.createTextNode(uls[i].getElementsByTagName(
          'a')[j].innerHTML));
        newselect.appendChild(newopt);
      }
      newselect.onchange = function() {
        window.location = this.options[this.selectedIndex].value;
      }
      newform.appendChild(newselect);
      uls[i].parentNode.insertBefore(newform, uls[i]);
      toreplace[count] = uls[i];
      count++;
    }
  }
  for (i = 0; i < count; i++) {
    toreplace[i].parentNode.removeChild(toreplace[i]);
  }

  function ts_check(o, c) {
    return new RegExp('\\b' + c + '\\b').test(o.className);
  }

  function ts_swapclass(o, c1, c2) {
    var cn = o.className
    o.className = !ts_check(o, c1) ? cn.replace(c2, c1) : cn.replace(c1, c2);
  }

  function ts_addclass(o, c) {
    if (!ts_check(o, c)) {
      o.className += o.className == '' ? c : ' ' + c;
    }
  }
}
window.onload = function() {
  tamingselect();
  // add more functions if necessary
}
$(document).ready(function() {
  $('.slider1').bxSlider({
    slideWidth: 100,
    minSlides: 1,
    maxSlides: 5,
    slideMargin: 40,
    pager: false,
    moveSlides: 1
  });
});
$(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(
      /^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +
        ']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
$(function() {
  var $searchlink = $('#searchtoggl i');
  var $searchbar = $('#searchbar');
  $('.top-bar ul li a').on('click', function(e) {
    e.preventDefault();
    if ($(this).attr('id') == 'searchtoggl') {
      if (!$searchbar.is(":visible")) {
        // if invisible we switch the icon to appear collapsable
        $searchlink.removeClass('fa-search').addClass('fa-search-minus');
      } else {
        // if visible we switch the icon to appear as a toggle
        $searchlink.removeClass('fa-search-minus').addClass('fa-search');
      }
      $searchbar.slideToggle(300, function() {
        // callback after search bar animation
      });
    }
  });
  $('#searchform').submit(function(e) {
    e.preventDefault(); // stop form submission
  });
});
$(function() {
  $(window).bind('exitBreakpoint320', function() {
    $('#log').append('<p>Exiting 320 breakpoint</p>');
  });
  $(window).bind('enterBreakpoint320', function() {
    $('#log').append('<p>Entering 320 breakpoint</p>');
  });
  $(window).bind('exitBreakpoint480', function() {
    $('#log').append('<p>Exiting 480 breakpoint</p>');
  });
  $(window).bind('enterBreakpoint480', function() {
    $('#log').append('<p>Entering 480 breakpoint</p>');
  });
  $(window).bind('exitBreakpoint768', function() {
    $('#log').append('<p>Exiting 768 breakpoint</p>');
  });
  $(window).bind('enterBreakpoint768', function() {
    $('#log').append('<p>Entering 768 breakpoint</p>');
  });
  $(window).bind('exitBreakpoint1024', function() {
    $('#log').append('<p>Exiting 1024 breakpoint</p>');
  });
  $(window).bind('enterBreakpoint1024', function() {
    $('#searchbar').css({
      "display": "none"
    });
  });
  $(window).setBreakpoints();
  $('#distinct').bind('click', function() {
    $(window).resetBreakpoints();
    $(window).setBreakpoints({
      distinct: $('#distinct').is(":checked")
    });
    $(window).resize();
  });
});
$(document).ready(function() {
  $('#horizontalTab').responsiveTabs({
    rotate: false,
    startCollapsed: 'accordion',
    collapsible: 'accordion',
    setHash: true,
    disabled: [3, 4],
    activate: function(e, tab) {
      $('.info').html('Tab <strong>' + tab.id +
        '</strong> activated!');
    },
    activateState: function(e, state) {
      //console.log(state);
      $('.info').html('Switched from <strong>' + state.oldState +
        '</strong> state to <strong>' + state.newState +
        '</strong> state!');
    }
  });
});

/*! viewportSize | Author: Tyson Matanich, 2013 | License: MIT */
(function(n){n.viewportSize={},n.viewportSize.getHeight=function(){return t("Height")},n.viewportSize.getWidth=function(){return t("Width")};var t=function(t){var f,o=t.toLowerCase(),e=n.document,i=e.documentElement,r,u;return n["inner"+t]===undefined?f=i["client"+t]:n["inner"+t]!=i["client"+t]?(r=e.createElement("body"),r.id="vpw-test-b",r.style.cssText="overflow:scroll",u=e.createElement("div"),u.id="vpw-test-d",u.style.cssText="position:absolute;top:-1000px",u.innerHTML="<style>@media("+o+":"+i["client"+t]+"px){body#vpw-test-b div#vpw-test-d{"+o+":7px!important}}<\/style>",r.appendChild(u),i.insertBefore(r,e.head),f=u["offset"+t]==7?i["client"+t]:n["inner"+t],i.removeChild(r)):f=n["inner"+t],f}})(this);

 /**
 * This demo was prepared for you by Petr Tichy - Ihatetomatoes.net
 * Want to see more similar demos and tutorials?
 * Help by spreading the word about Ihatetomatoes blog.
 * Facebook - https://www.facebook.com/ihatetomatoesblog
 * Twitter - https://twitter.com/ihatetomatoes
 * Google+ - https://plus.google.com/u/0/109859280204979591787/about
 * Article URL: http://ihatetomatoes.net/how-to-create-a-parallax-scrolling-website/
 */

( function( $ ) {
  
  // Setup variables
  $window = $(window);
  $slide = $('.homeSlide');
  $slideTall = $('.homeSlideTall');
  $slideTall2 = $('.homeSlideTall2');
  $body = $('body');
  
    //FadeIn all sections   
  $body.imagesLoaded( function() {
    setTimeout(function() {
          
          // Resize sections
          adjustWindow();
          
          // Fade in sections
        $body.removeClass('loading').addClass('loaded');
        
    }, 800);
  });
  
  function adjustWindow(){
    
    // Init Skrollr
    var s = skrollr.init({
      forceHeight: false,
        render: function(data) {
        
            //Debugging - Log the current scroll position.
            //console.log(data.curTop);
        }
    });
    
    // Get window size
      winH = $window.height();
      
      // Keep minimum height 550
      if(winH <= 550) {
      winH = 550;
    } 
      
      // Resize our slides
      $slide.height(winH);
      $slideTall.height(winH*2);
      $slideTall2.height(winH*3);
      
      // Refresh Skrollr after resizing our sections
      s.refresh($('.homeSlide'));
      
  }
    
} )( jQuery );