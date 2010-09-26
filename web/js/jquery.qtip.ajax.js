/*!
* qTip - The jQuery tooltip plugin
* http://craigsworks.com/projects/qtip/
*
* AJAX plugin - Allows you to use remote content for your tooltips via AJAX functionality
* Version: UNSTABLE REVISION CODE!
* Requires: qTip library
*
* Copyright 2009 Craig Thompson - http://craigsworks.com
*
* Dual licensed under MIT or GPL Version 2 licenses
*   http://en.wikipedia.org/wiki/MIT_License
*   http://en.wikipedia.org/wiki/GNU_General_Public_License
*/

"use strict"; // Enable ECMAScript "strict" operation for this function. See more: http://ejohn.org/blog/ecmascript-5-strict-mode-json-and-more/
/*jslint onevar: true, browser: true, forin: true, undef: true, nomen: true, bitwise: true, regexp: true, newcap: true, maxerr: 300 */
/*global window: false, jQuery: false */

(function($)
{
	// Munge the primitives - Paul Irish
	var TRUE = true,
		FALSE = false,
		PRELOAD = $();

	// Check qTip library is present
	if(!$.fn.qtip) {
		if(window.console){ window.console.error('This plugin requires the qTip library.',''); }
		return FALSE;
	}

	function Ajax(qTip)
	{
		var self = this;

		self.checks = {
			'^content.ajax': function() { this.plugins.ajax.load(this.options.content.ajax); }
		};
		
		$.extend(self, {

			init: function()
			{
				// Grab ajax options
				var ajax = qTip.options.content.ajax;

				// Load the remote content
				self.load(ajax);

				// Bind show event
				qTip.elements.tooltip.bind('tooltipshow.ajax', function() {
						// Update content if content.ajax.once is FALSE and the tooltip is rendered
						if(ajax.once === FALSE && qTip.rendered === TRUE) { self.load(ajax); }
					});
			},

			load: function(ajax)
			{
				// Define success and error handlers
				function successHandler(content, status)
				{
					// Call user-defined success handler if present
					if($.isFunction(ajax.success)) {
						result = ajax.success.call(qTip.hash(), content, status);
						if(result === FALSE){ return; }
					}

					// Update content and remove preloaded iamges if present
					qTip.set('content.text', content);
					PRELOAD.remove();
					
				}
				function errorHandler(xhr, status, error)
				{
					var content = status || error;

					// Call user-defined success handler if present
					if($.isFunction(ajax.error)) {
						result = ajax.error.call(qTip.hash(), xhr, status, error);
						if(result === FALSE){ return; }
					}

					// Update tooltip content to indicate error
					qTip.set('content.text', content);
				}

				// Setup $.ajax option object and process the request
				$.ajax( $.extend(TRUE, {}, ajax, { success: successHandler, error: errorHandler }) );

				return self;
			},

			destroy: function()
			{
				// Remove bound events
				qTip.elements.tooltip.unbind('tooltipshow.ajax');
			}
		});

		self.init();
	}

	function preloadImages(url) {
		var id = 'qtip-preload';

		if(!$('#'+id).length) {
			$('<div id="'+id+'" class="ui-tooltip-accessible" />').appendTo(document.body);
		}

		if(!PRELOAD.length) {
			PRELOAD = $('<div />').appendTo('#'+id).load(url + ' img');
		}
	}

	$.fn.qtip.plugins.ajax = function(qTip)
	{
		var api = qTip.plugins.ajax,
			opts = qTip.options.content;

		// Make sure the qTip uses the $.ajax functionality
		if(opts.ajax && opts.ajax.url) {
			// An API is already present, return it
			if(api) {
				return api;
			}
			// No API was found, create new instance
			else {
				qTip.plugins.ajax = new Ajax(qTip);
				return qTip.plugins.ajax;
			}
		}
	};

	$.fn.qtip.plugins.ajax.initialize = 'render';

	// Setup plugin sanitization
	$.fn.qtip.plugins.ajax.sanitize = function(opts)
	{
		// Parse options into correct syntax
		if(opts.content !== undefined) {
			if(opts.content.ajax !== undefined) {
				if(typeof opts.content.ajax !== 'object') { opts.content.ajax = { url: opts.content.ajax }; }
				if(opts.content.text === FALSE) { opts.content.text = 'Loading...'; }
				opts.content.ajax.once = Boolean(opts.content.ajax.once);
				opts.content.ajax.preload = Boolean(opts.content.ajax.preload);
				
				// Preload images if enabled 
				if(opts.content.ajax.preload) { preloadImages(opts.content.ajax.url); } 
			}
		}
	};
}(jQuery));