// Enable logging without breaking dumb browsers. Use log('whatever'), not console.log('whatever').
window.log=function(){log.history=log.history||[];log.history.push(arguments);if(this.console){arguments.callee=arguments.callee.caller;var a=[].slice.call(arguments);(typeof console.log==="object"?log.apply.call(console.log,console,a):console.log.apply(console,a))}};
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,timeStamp,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();){b[a]=b[a]||c}})((function(){try
	{console.log();return window.console;}catch(err){return window.console={};}})());

/**
*   Basic JavaScript Part 8: Namespaces - by. Jan Van Ryswyck
*   http://elegantcode.com/2011/01/26/basic-javascript-part-8-namespaces/   
*/
function namespace(namespaceString) {
	var parts = namespaceString.split('.'),
	parent = window,
	currentPart = '';

	for (var i = 0, length = parts.length; i < length; i++) {
		currentPart = parts[i];
		parent[currentPart] = parent[currentPart] || {};
		parent = parent[currentPart];
	}

	return parent;
}

/**
 * TEMPLATE CONTROLLER
 * Eases the use of templates by storing the cached jQuery templates on a single object.
 */
 var TemplateController = function() {
	this.templates = {};

	this.addTemplate = function(id) {
		this.templates[id] = $('#template-' + id).html();
	};

	this.getTemplate = function(id) {
		return this.templates[id];
	};
 };

// $('#my-container').imagesLoaded(myFunction)
// or
// $('img').imagesLoaded(myFunction)

// execute a callback when all images have loaded.
// needed because .load() doesn't work on cached images

// callback function gets image collection as argument
//  `this` is the container
$.fn.imagesLoaded = function( callback ) {
	var $this = this,
	$images = $this.find('img').add( $this.filter('img') ),
	len = $images.length,
	blank = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==',
	loaded = [];

	function triggerCallback() {
		callback.call( $this, $images );
	}

	function imgLoaded( event ) {
		var img = event.target;
		if ( img.src !== blank && $.inArray( img, loaded ) === -1 ){
			loaded.push( img );
			if ( --len <= 0 ){
				setTimeout( triggerCallback );
				$images.unbind( '.imagesLoaded', imgLoaded );
			}
		}
	}

	// if no images, trigger immediately
	if ( !len ) {
		triggerCallback();
	}

	$images.bind( 'load.imagesLoaded error.imagesLoaded',  imgLoaded ).each( function() {
		// cached images don't fire load sometimes, so we reset src.
		var src = this.src;
		// webkit hack from http://groups.google.com/group/jquery-dev/browse_thread/thread/eee6ab7b2da50e1f
		// data uri bypasses webkit log warning (thx doug jones)
		this.src = blank;
		this.src = src;
	});

	return $this;
};

/*
   * smartresize: debounced resize event for jQuery
   *
   * latest version and complete README available on Github:
   * https://github.com/louisremi/jquery.smartresize.js
   *
   * Copyright 2011 @louis_remi
   * Licensed under the MIT license.
*/

(function() {
	var $event = $.event,
		resizeTimeout;

	$event.special.smartresize = {
		setup: function() {
			$(this).bind( "resize", $event.special.smartresize.handler );
		},
		teardown: function() {
			$(this).unbind( "resize", $event.special.smartresize.handler );
		},
		handler: function( event, execAsap ) {
			// Save the context
			var context = this,
			args = arguments;

			// set correct event type
			event.type = "smartresize";

			if ( resizeTimeout ) { clearTimeout( resizeTimeout ); }
			
			resizeTimeout = setTimeout(function() {
				$.event.handle.apply( context, args );
			}, execAsap === "execAsap"? 0 : 100 );
		}
	};

	$.fn.smartresize = function( fn ) {
		return fn ? this.bind( "smartresize", fn ) : this.trigger( "smartresize", ["execAsap"] );
	};
})();