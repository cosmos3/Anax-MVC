
addEvent(window, 'scroll', menuTop);
addEvent(window, 'resize', menuTop);
addEvent(window, 'beforeunload', commonRemove);


function menuTop() {
	var jnc = jQuery.noConflict();
	jnc("document").ready(function() {
		if (jnc(this).scrollTop() > 110) {
			jnc("#navbar").addClass("navbar-fixed");
			jnc("#top-head-fixed").css("display", "block");
			jnc("#main").css("margin-top", "94px");
		} else {
			jnc("#navbar").removeClass("navbar-fixed");
			jnc("#top-head-fixed").css("display", "none");
			jnc("#main").css("margin-top", "50px");
		}
		var width = jnc("#wrapper").width();
		jnc(".navbar").width(width);
	});
}


function commonRemove() {
	removeEvent(window, 'scroll', menuTop);
	removeEvent(window, 'resize', menuTop);
	removeEvent(window, 'beforeunload', commonRemove);
}

function addEvent(e, type, func) {
	if (navigator.appName != "Microsoft Internet Explorer") {
		e.addEventListener(type, func, false);
		return true;
	} else {
		var r = e.attachEvent("on" + type, func);
		return r;
	}
}

function removeEvent(e, type, func) {
	if (navigator.appName != "Microsoft Internet Explorer") {
		e.removeEventListener(type, func, false);
		return true;
	} else {
		var r = e.detachEvent("on" + type, func);
		return r;
	}
}

