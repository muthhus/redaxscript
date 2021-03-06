/**
 * @tableofcontents
 *
 * 1. redaxscript object
 *    1.1 lightbox
 *    1.2 plugins
 *    1.3 modules
 *    1.4 support
 *    1.5 base url
 *    1.6 startup
 *
 * @since 2.0
 *
 * @package Redaxscript
 * @author Henry Ruhs
 */

'use strict';

/* @section 1. redaxscript object */

var r = r || {};

/* @section 1.1 lightbox */

r.lightbox =
{
	overlay:
	{
		opacity: 0.25,
		duration: 'slow'
	},
	loading:
	{
		opacity: 1,
		duration: 'slow'
	},
	body:
	{
		opacity: 1,
		duration: 'fast'
	}
};

/* @section 1.2 plugins */

r.plugins =
{
	accordion:
	{
		startup: true,
		selector: 'div.js_accordion h3.js_title_accordion, form.js_accordion legend.js_title_accordion',
		options:
		{
			element:
			{
				accordion: 'div.js_accordion, form.js_accordion',
				accordionSet: 'div.js_set_accordion, fieldset.js_set_accordion',
				accordionTitle: 'h3.js_title_accordion, legend.js_title_accordion',
				accordionBox: 'div.js_box_accordion, ul.js_box_accordion'
			},
			duration: 'normal'
		}
	},
	autoResize:
	{
		startup: true,
		selector: 'form textarea.js_auto_resize',
		options:
		{
			overflow: 'hidden',
			summand: 10,
			limit: 1000
		}
	},
	dialog:
	{
		options:
		{
			element:
			{
				dialog: 'div.js_dialog',
				dialogOverlay: 'div.js_dialog_overlay',
				buttonOk: 'a.js_ok',
				buttonCancel: 'a.js_cancel',
				fieldPrompt: 'input.js_prompt'
			},
			classString:
			{
				dialog: 'js_dialog dialog dialog',
				dialogTitle: 'js_title_dialog title_dialog title_dialog',
				dialogBox: 'js_box_dialog box_dialog box_dialog',
				dialogOverlay: 'js_dialog_overlay dialog_overlay dialog_overlay',
				buttonOk: 'js_ok button',
				buttonCancel: 'js_cancel button',
				fieldPrompt: 'js_prompt field_text'
			},
			suffix:
			{
				backend: '_admin',
				frontend: '_default'
			},
			type: 'alert',
			message: '',
			callback: ''
		}
	},
	dropdown:
	{
		startup: true,
		selector: 'ul.js_dropdown',
		options:
		{
			related: 'li',
			duration: 2000
		}
	},
	checkRequired:
	{
		startup: true,
		selector: 'form.js_check_required',
		options:
		{
			elements:
			{
				buttonSubmit: 'button.js_submit',
				fieldRequired: 'div.js_required, input.js_required, select.js_required, textarea.js_required'
			},
			autoFocus: true,
			vibrate: 300
		}
	},
	checkSearch:
	{
		startup: true,
		selector: 'form.js_check_search',
		options:
		{
			required: 'input.js_required',
			duration: 1000
		}
	},
	confirmLink:
	{
		startup: true,
		selector: 'a.js_confirm'
	},
	enableTab:
	{
		startup: true,
		selector: 'form textarea.js_editor, form textarea.js_enable_tab',
		options:
		{
			insertion: '\t'
		}
	},
	forwardNotification:
	{
		startup: true,
		selector: 'a.js_forward_notification',
		options:
		{
			duration: 1000
		}
	},
	generateAlias:
	{
		startup: true,
		selector: 'form input.js_generate_alias_input, form input.js_generate_alias_output',
		options:
		{
			related: 'input.js_generate_alias_output'
		}
	},
	keyShortcut:
	{
		startup: true,
		selector: window,
		options:
		{
			element:
			{
				adminDock: 'div.js_dock_admin',
				adminPanel: 'nav.js_panel_admin',
				buttonSubmit: 'form button.js_submit',
				buttonOk: 'div a.js_ok span span, form button.js_ok',
				buttonCancel: 'div a.js_cancel span span, form button.js_cancel'
			}
		}
	},
	noteRequired:
	{
		startup: true,
		selector: 'form.js_note_required',
		options:
		{
			classString: 'js_note_required note_required box_note',
			related: 'a.js_cancel, a.js_delete, button.js_submit',
			timeout: 1000,
			duration: 300
		}
	},
	preventUnload:
	{
		startup: true,
		selector: 'ul.js_box_accordion, div.js_box_tab',
		options:
		{
			excluded: 'ul.js_list_tab a'
		}
	},
	tab:
	{
		startup: true,
		selector: 'ul.js_list_tab li',
		options:
		{
			element:
			{
				tabBox: 'div.js_box_tab',
				tabList: 'ul.js_list_tab',
				tabSet: 'div.js_set_tab, fieldset.js_set_tab'
			}
		}
	},
	unmaskPassword:
	{
		startup: true,
		selector: 'form input.js_unmask_password'
	}
};

/* @section 1.3 modules */

r.modules = {};

/* @section 1.4 support */

r.support =
{
	battery: function (nav)
	{
		if ('battery' in nav)
		{
			return true;
		}
		else
		{
			return false;
		}
	}(window.navigator),
	canvas: function (doc)
	{
		if (typeof doc.createElement('canvas').getContext === 'function')
		{
			return true;
		}
		else
		{
			return false;
		}
	}(document),
	cookies: function (nav)
	{
		if (nav.cookieEnabled)
		{
			return true;
		}
		else
		{
			return false;
		}
	}(window.navigator),
	geolocation: function (nav)
	{
		if (typeof nav.geolocation === 'object')
		{
			return true;
		}
		else
		{
			return false;
		}
	}(window.navigator),
	input: function (doc)
	{
		var types =
			[
				'color',
				'date',
				'datetime',
				'datetime-local',
				'email',
				'month',
				'number',
				'range',
				'search',
				'tel',
				'time',
				'url',
				'week'
			],
			attributes =
			[
				'autocomplete',
				'autofocus',
				'pattern',
				'placeholder',
				'required'
			],
			input = doc.createElement('input'),
			i = '', j = '', output = {};

		/* check types */

		for (i in types)
		{
			var type = types[i];

			input.setAttribute('type', type);
			if (input.type === type)
			{
				output[type] = true;
			}
			else
			{
				output[type] = false;
			}
		}

		/* check attributes */
	
		for (j in attributes)
		{
			var attribute = attributes[j];
	
			if (attribute in input)
			{
				output[attribute] = true;
			}
			else
			{
				output[attribute] = false;
			}
		}
		return output;
	}(document),
	nativeJSON: function (json)
	{
		if (typeof json === 'object' && typeof json.parse === 'function' && typeof json.stringify === 'function')
		{
			return true;
		}
		else
		{
			return false;
		}
	}(window.JSON),
	svg: function (doc)
	{
		if (typeof doc.createElementNS === 'function' && typeof doc.createElementNS('http://www.w3.org/2000/svg', 'svg').createSVGRect === 'function')
		{
			return true;
		}
		else
		{
			return false;
		}
	}(document),
	touch: function (doc)
	{
		if ('ontouchstart' in doc.documentElement)
		{
			return true;
		}
		else
		{
			return false;
		}
	}(document),
	vibrate: function (nav)
	{
		if ('vibrate' in nav)
		{
			return true;
		}
		else
		{
			return false;
		}
	}(window.navigator),
	webGL: function (win)
	{
		if (typeof win.WebGLRenderingContext === 'function')
		{
			return true;
		}
		else
		{
			return false;
		}
	}(window),
	webStorage: function (win, nav)
	{
		if (nav.cookieEnabled && typeof win.localStorage === 'object' && typeof win.sessionStorage === 'object')
		{
			return true;
		}
		else
		{
			return false;
		}
	}(window, window.navigator)
};

/* @section 1.5 base url */

r.baseURL = function (doc)
{
	var base = doc.getElementsByTagName('base'),
		checkBase = base.length,
		output = '';

	if (checkBase)
	{
		output = base[0].href;
	}
	return output;
}(document);

/* @section 1.6 startup */

r.startup = function (doc, html)
{
	var i = '',
		tags =
		[
			'article',
			'aside',
			'footer',
			'header',
			'nav',
			'section'
		];

	if (html.className)
	{
		html.className += ' ';
	}
	html.className += 'js';

	/* support classes */

	if (r.support.canvas)
	{
		html.className += ' canvas';
	}
	else
	{
		html.className += ' no_canvas';
	}
	if (r.support.svg)
	{
		html.className += ' svg';
	}
	else
	{
		html.className += ' no_svg';
	}

	/* create elements */

	for (i in tags)
	{
		doc.createElement(tags[i]);
	}
	return true;
}(document, document.documentElement);
