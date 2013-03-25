;(function ($, window, undefined) {
  'use strict';

  var $doc = $(document),
      Modernizr = window.Modernizr;

  $(document).ready(function() {
    $.fn.foundationAlerts           ? $doc.foundationAlerts() : null;
    $.fn.foundationButtons          ? $doc.foundationButtons() : null;
    $.fn.foundationAccordion        ? $doc.foundationAccordion() : null;
    $.fn.foundationNavigation       ? $doc.foundationNavigation() : null;
    $.fn.foundationTopBar           ? $doc.foundationTopBar() : null;
    $.fn.foundationCustomForms      ? $doc.foundationCustomForms() : null;
    $.fn.foundationMediaQueryViewer ? $doc.foundationMediaQueryViewer() : null;
    $.fn.foundationTabs             ? $doc.foundationTabs({callback : $.foundation.customForms.appendCustomMarkup}) : null;
    $.fn.foundationTooltips         ? $doc.foundationTooltips() : null;
    $.fn.foundationMagellan         ? $doc.foundationMagellan() : null;
    $.fn.foundationClearing         ? $doc.foundationClearing() : null;

    $.fn.placeholder                ? $('input, textarea').placeholder() : null;
  });

  // UNCOMMENT THE LINE YOU WANT BELOW IF YOU WANT IE8 SUPPORT AND ARE USING .block-grids
  // $('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'both'});
  // $('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'both'});
  // $('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'both'});
  // $('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'both'});

  // Hide address bar on mobile devices (except if #hash present, so we don't mess up deep linking).
  if (Modernizr.touch && !window.location.hash) {
    $(window).load(function () {
      setTimeout(function () {
        // At load, if user hasn't scrolled more than 20px or so...
  			if( $(window).scrollTop() < 20 ) {
          window.scrollTo(0, 1);
        }
      }, 0);
    });
  }

})(jQuery, this);

function roleRights(sourceId, targetId, labelId) {
	role = $("#"+sourceId).val();
	$.get("/role/name", {"role": role}, function(msg) {
		$("#"+labelId).text(msg);
	});
	$.get("/role/rights", {"role": role}, function(html) {
		$("#"+targetId).html(html);
		$("#"+targetId).foundationCustomForms();
	});
}

function registerMember(target, caller) {
	$(caller).toggleClass('active');
	$(caller).toggleClass('disabled');
	if( !$('#'+target).is(':visible') ) {
		$.get('/member/register', {"ajax": "true"}, function(html) {
			$("#"+target).html(html);
			$("#"+target).foundationCustomForms();
			$(caller).toggleClass('disabled');
		});
	} else {
		$(caller).toggleClass('disabled');
	}
	$("#"+target).slideToggle(200);
}

function doRegisterMember(sourceForm, target) {
	$.post('/member/register', $("#"+sourceForm).serialize(), function(html) {
		$("#"+target).html(html);
		$("#"+target).foundationCustomForms();
	});
}

function doUpdateMember(sourceForm, target) {
	$.post('/member/update', $("#"+sourceForm).serialize(), function(html) {
		$("#"+target).html(html);
	});
}

function registerAnotherMember(target, caller) {
	$.get('/member/register', {"ajax": "true"}, function(html) {
		$("#"+target).html(html);
		$("#"+target).foundationCustomForms();
	});
}

function viewMember(caller) {
	$("#member-name").text("Medlemsdata");
	$("#member-type").text("");
	$("#member-view-ajax-receiver").html($("#template-loading").html());
	$("#member-modal").reveal();
	$.get("/member/name", {"id": $(caller).data("member")}, function(text) {
		$("#member-name").text(text);
	});
	$.get("/member/type", {"id": $(caller).data("member")}, function(text) {
		$("#member-type").text(" ("+text+")");
	});
	$.get("/member/view", {"id": $(caller).data("member")}, function(html) {
		$("#member-view-ajax-receiver").html(html);
		$("#member-view-ajax-receiver").foundationCustomForms();
	});
}

function removeMember(memberId) {
	$("#member-remove-modal").reveal();
	$("#member-remove-name").text("hämtar namn...");
	$("#member-remove-name").addClass("radius label");
	
	$.get("/member/remove", {"step": "buttons", "id": memberId}, function(html) {
		$("#member-remove-ajax-receiver").html(html);
	});
	
	$.get("/member/name", {"id": memberId}, function(text) {
		$("#member-remove-name").removeClass("radius label");
		$("#member-remove-name").text(text+".");
	});
}

function doRemove(sourceForm) {
	$.post("/member/remove", $("#"+sourceForm).serialize(), function(html) {
		$("#member-remove-ajax-receiver").html(html);
	});
}