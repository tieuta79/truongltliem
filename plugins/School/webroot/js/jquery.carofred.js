/*
 *	jQuery carouFredSel 6.0.6
 *	Demo's and documentation:
 *	caroufredsel.frebsite.nl
 *
 *	Copyright (c) 2012 Fred Heusschen
 *	www.frebsite.nl
 *
 *	Dual licensed under the MIT and GPL licenses.
 *	http://en.wikipedia.org/wiki/MIT_License
 *	http://en.wikipedia.org/wiki/GNU_General_Public_License
 */


(function(jQuery) {

	//	LOCAL

	if ( jQuery.fn.carouFredSel )
	{
		return;
	}

	jQuery.fn.caroufredsel = jQuery.fn.carouFredSel = function(options, configs)
	{

		//	no element
		if (this.length == 0)
		{
			debug( true, 'No element found for "' + this.selector + '".' );
			return this;
		}

		//	multiple elements
		if (this.length > 1)
		{
			return this.each(function() {
				jQuery(this).carouFredSel(options, configs);
			});
		}


		var jQuerycfs = this,
			jQuerytt0 = this[0],
			starting_position = false;

		if (jQuerycfs.data('_cfs_isCarousel'))
		{
			starting_position = jQuerycfs.triggerHandler('_cfs_triggerEvent', 'currentPosition');
			jQuerycfs.trigger('_cfs_triggerEvent', ['destroy', true]);
		}


		jQuerycfs._cfs_init = function(o, setOrig, start)
		{
			o = go_getObject(jQuerytt0, o);

			o.items = go_getItemsObject(jQuerytt0, o.items);
			o.scroll = go_getScrollObject(jQuerytt0, o.scroll);
			o.auto = go_getAutoObject(jQuerytt0, o.auto);
			o.prev = go_getPrevNextObject(jQuerytt0, o.prev);
			o.next = go_getPrevNextObject(jQuerytt0, o.next);
			o.pagination = go_getPaginationObject(jQuerytt0, o.pagination);
			o.swipe = go_getSwipeObject(jQuerytt0, o.swipe);
			o.mousewheel = go_getMousewheelObject(jQuerytt0, o.mousewheel);

			if (setOrig)
			{
				opts_orig = jQuery.extend(true, {}, jQuery.fn.carouFredSel.defaults, o);
			}

			opts = jQuery.extend(true, {}, jQuery.fn.carouFredSel.defaults, o);
			opts.d = cf_getDimensions(opts);

			crsl.direction = (opts.direction == 'up' || opts.direction == 'left') ? 'next' : 'prev';

			var	a_itm = jQuerycfs.children(),
				avail_primary = ms_getParentSize(jQuerywrp, opts, 'width');

			if (is_true(opts.cookie))
			{
				opts.cookie = 'caroufredsel_cookie_' + conf.serialNumber;
			}

			opts.maxDimension = ms_getMaxDimension(opts, avail_primary);

			//	complement items and sizes
			opts.items = in_complementItems(opts.items, opts, a_itm, start);
			opts[opts.d['width']] = in_complementPrimarySize(opts[opts.d['width']], opts, a_itm);
			opts[opts.d['height']] = in_complementSecondarySize(opts[opts.d['height']], opts, a_itm);

			//	primary size not set for a responsive carousel
			if (opts.responsive)
			{
				if (!is_percentage(opts[opts.d['width']]))
				{
					opts[opts.d['width']] = '100%';
				}
			}

			//	primary size is percentage
			if (is_percentage(opts[opts.d['width']]))
			{
				crsl.upDateOnWindowResize = true;
				crsl.primarySizePercentage = opts[opts.d['width']];
				opts[opts.d['width']] = ms_getPercentage(avail_primary, crsl.primarySizePercentage);
				if (!opts.items.visible)
				{
					opts.items.visibleConf.variable = true;
				}
			}

			if (opts.responsive)
			{
				opts.usePadding = false;
				opts.padding = [0, 0, 0, 0];
				opts.align = false;
				opts.items.visibleConf.variable = false;
			}
			else
			{
				//	visible-items not set
				if (!opts.items.visible)
				{
					opts = in_complementVisibleItems(opts, avail_primary);
				}

				//	primary size not set -> calculate it or set to "variable"
				if (!opts[opts.d['width']])
				{
					if (!opts.items.visibleConf.variable && is_number(opts.items[opts.d['width']]) && opts.items.filter == '*')
					{
						opts[opts.d['width']] = opts.items.visible * opts.items[opts.d['width']];
						opts.align = false;
					}
					else
					{
						opts[opts.d['width']] = 'variable';
					}
				}
				//	align not set -> set to center if primary size is number
				if (is_undefined(opts.align))
				{
					opts.align = (is_number(opts[opts.d['width']]))
						? 'center'
						: false;
				}
				//	set variabe visible-items
				if (opts.items.visibleConf.variable)
				{
					opts.items.visible = gn_getVisibleItemsNext(a_itm, opts, 0);
				}
			}

			//	set visible items by filter
			if (opts.items.filter != '*' && !opts.items.visibleConf.variable)
			{
				opts.items.visibleConf.org = opts.items.visible;
				opts.items.visible = gn_getVisibleItemsNextFilter(a_itm, opts, 0);
			}

			opts.items.visible = cf_getItemsAdjust(opts.items.visible, opts, opts.items.visibleConf.adjust, jQuerytt0);
			opts.items.visibleConf.old = opts.items.visible;

			if (opts.responsive)
			{
				if (!opts.items.visibleConf.min)
				{
					opts.items.visibleConf.min = opts.items.visible;
				}
				if (!opts.items.visibleConf.max)
				{
					opts.items.visibleConf.max = opts.items.visible;
				}
				opts = in_getResponsiveValues(opts, a_itm, avail_primary);
			}
			else
			{
				opts.padding = cf_getPadding(opts.padding);

				if (opts.align == 'top')
				{
					opts.align = 'left';
				}
				else if (opts.align == 'bottom')
				{
					opts.align = 'right';
				}

				switch (opts.align)
				{
					//	align: center, left or right
					case 'center':
					case 'left':
					case 'right':
						if (opts[opts.d['width']] != 'variable')
						{
							opts = in_getAlignPadding(opts, a_itm);
							opts.usePadding = true;
						}
						break;

					//	padding
					default:
						opts.align = false;
						opts.usePadding = (
							opts.padding[0] == 0 && 
							opts.padding[1] == 0 && 
							opts.padding[2] == 0 && 
							opts.padding[3] == 0
						) ? false : true;
						break;
				}
			}

			if (!is_number(opts.scroll.duration))
			{
				opts.scroll.duration = 500;
			}
			if (is_undefined(opts.scroll.items))
			{
				opts.scroll.items = (opts.responsive || opts.items.visibleConf.variable || opts.items.filter != '*') 
					? 'visible'
					: opts.items.visible;
			}

			opts.auto = jQuery.extend(true, {}, opts.scroll, opts.auto);
			opts.prev = jQuery.extend(true, {}, opts.scroll, opts.prev);
			opts.next = jQuery.extend(true, {}, opts.scroll, opts.next);
			opts.pagination = jQuery.extend(true, {}, opts.scroll, opts.pagination);
			//	swipe and mousewheel extend later on, per direction

			opts.auto = go_complementAutoObject(jQuerytt0, opts.auto);
			opts.prev = go_complementPrevNextObject(jQuerytt0, opts.prev);
			opts.next = go_complementPrevNextObject(jQuerytt0, opts.next);
			opts.pagination = go_complementPaginationObject(jQuerytt0, opts.pagination);
			opts.swipe = go_complementSwipeObject(jQuerytt0, opts.swipe);
			opts.mousewheel = go_complementMousewheelObject(jQuerytt0, opts.mousewheel);

			if (opts.synchronise)
			{
				opts.synchronise = cf_getSynchArr(opts.synchronise);
			}


			//	DEPRECATED
			if (opts.auto.onPauseStart)
			{
				opts.auto.onTimeoutStart = opts.auto.onPauseStart;
				deprecated('auto.onPauseStart', 'auto.onTimeoutStart');
			}
			if (opts.auto.onPausePause)
			{
				opts.auto.onTimeoutPause = opts.auto.onPausePause;
				deprecated('auto.onPausePause', 'auto.onTimeoutPause');
			}
			if (opts.auto.onPauseEnd)
			{
				opts.auto.onTimeoutEnd = opts.auto.onPauseEnd;
				deprecated('auto.onPauseEnd', 'auto.onTimeoutEnd');
			}
			if (opts.auto.pauseDuration)
			{
				opts.auto.timeoutDuration = opts.auto.pauseDuration;
				deprecated('auto.pauseDuration', 'auto.timeoutDuration');
			}
			//	/DEPRECATED


		};	//	/init


		jQuerycfs._cfs_build = function() {
			jQuerycfs.data('_cfs_isCarousel', true);

			var a_itm = jQuerycfs.children(),
				orgCSS = in_mapCss(jQuerycfs, ['textAlign', 'float', 'position', 'top', 'right', 'bottom', 'left', 'zIndex', 'width', 'height', 'marginTop', 'marginRight', 'marginBottom', 'marginLeft']),
				newPosition = 'relative';

			switch (orgCSS.position)
			{
				case 'absolute':
				case 'fixed':
					newPosition = orgCSS.position;
					break;
			}

			jQuerywrp.css(orgCSS).css({
				'overflow'		: 'hidden',
				'position'		: newPosition
			});

			jQuerycfs.data('_cfs_origCss', orgCSS).css({
				'textAlign'		: 'left',
				'float'			: 'none',
				'position'		: 'absolute',
				'top'			: 0,
				'right'			: 'auto',
				'bottom'		: 'auto',
				'left'			: 0,
				'marginTop'		: 0,
				'marginRight'	: 0,
				'marginBottom'	: 0,
				'marginLeft'	: 0
			});

			sz_storeMargin(a_itm, opts);
			sz_storeSizes(a_itm, opts);
			if (opts.responsive)
			{
				sz_setResponsiveSizes(opts, a_itm);
			}

		};	//	/build


		jQuerycfs._cfs_bind_events = function() {
			jQuerycfs._cfs_unbind_events();


			//	stop event
			jQuerycfs.bind(cf_e('stop', conf), function(e, imm) {
				e.stopPropagation();

				//	button
				if (!crsl.isStopped)
				{
					if (opts.auto.button)
					{
						opts.auto.button.addClass(cf_c('stopped', conf));
					}
				}

				//	set stopped
				crsl.isStopped = true;

				if (opts.auto.play)
				{
					opts.auto.play = false;
					jQuerycfs.trigger(cf_e('pause', conf), imm);
				}
				return true;
			});


			//	finish event
			jQuerycfs.bind(cf_e('finish', conf), function(e) {
				e.stopPropagation();
				if (crsl.isScrolling)
				{
					sc_stopScroll(scrl);
				}
				return true;
			});


			//	pause event
			jQuerycfs.bind(cf_e('pause', conf), function(e, imm, res) {
				e.stopPropagation();
				tmrs = sc_clearTimers(tmrs);

				//	immediately pause
				if (imm && crsl.isScrolling)
				{
					scrl.isStopped = true;
					var nst = getTime() - scrl.startTime;
					scrl.duration -= nst;
					if (scrl.pre)
					{
						scrl.pre.duration -= nst;
					}
					if (scrl.post)
					{
						scrl.post.duration -= nst;
					}
					sc_stopScroll(scrl, false);
				}

				//	update remaining pause-time
				if (!crsl.isPaused && !crsl.isScrolling)
				{
					if (res)
					{
						tmrs.timePassed += getTime() - tmrs.startTime;
					}
				}

				//	button
				if (!crsl.isPaused)
				{
					if (opts.auto.button)
					{
						opts.auto.button.addClass(cf_c('paused', conf));
					}
				}

				//	set paused
				crsl.isPaused = true;

				//	pause pause callback
				if (opts.auto.onTimeoutPause)
				{
					var dur1 = opts.auto.timeoutDuration - tmrs.timePassed,
						perc = 100 - Math.ceil( dur1 * 100 / opts.auto.timeoutDuration );

					opts.auto.onTimeoutPause.call(jQuerytt0, perc, dur1);
				}
				return true;
			});


			//	play event
			jQuerycfs.bind(cf_e('play', conf), function(e, dir, del, res) {
				e.stopPropagation();
				tmrs = sc_clearTimers(tmrs);

				//	sort params
				var v = [dir, del, res],
					t = ['string', 'number', 'boolean'],
					a = cf_sortParams(v, t);

				dir = a[0];
				del = a[1];
				res = a[2];

				if (dir != 'prev' && dir != 'next')
				{
					dir = crsl.direction;
				}
				if (!is_number(del))
				{
					del = 0;
				}
				if (!is_boolean(res))
				{
					res = false;
				}

				//	stopped?
				if (res)
				{
					crsl.isStopped = false;
					opts.auto.play = true;
				}
				if (!opts.auto.play)
				{
					e.stopImmediatePropagation();
					return debug(conf, 'Carousel stopped: Not scrolling.');
				}

				//	button
				if (crsl.isPaused)
				{
					if (opts.auto.button)
					{
						opts.auto.button.removeClass(cf_c('stopped', conf));
						opts.auto.button.removeClass(cf_c('paused', conf));
					}
				}

				//	set playing
				crsl.isPaused = false;
				tmrs.startTime = getTime();

				//	timeout the scrolling
				var dur1 = opts.auto.timeoutDuration + del;
					dur2 = dur1 - tmrs.timePassed;
					perc = 100 - Math.ceil(dur2 * 100 / dur1);

				if (opts.auto.progress)
				{
					tmrs.progress = setInterval(function() {
						var pasd = getTime() - tmrs.startTime + tmrs.timePassed,
							perc = Math.ceil(pasd * 100 / dur1);
						opts.auto.progress.updater.call(opts.auto.progress.bar[0], perc);
					}, opts.auto.progress.interval);
				}

				tmrs.auto = setTimeout(function() {
					if (opts.auto.progress)
					{
						opts.auto.progress.updater.call(opts.auto.progress.bar[0], 100);
					}
					if (opts.auto.onTimeoutEnd)
					{
						opts.auto.onTimeoutEnd.call(jQuerytt0, perc, dur2);
					}
					if (crsl.isScrolling)
					{
						jQuerycfs.trigger(cf_e('play', conf), dir);
					}
					else
					{
						jQuerycfs.trigger(cf_e(dir, conf), opts.auto);
					}
				}, dur2);

				//	pause start callback
				if (opts.auto.onTimeoutStart)
				{
					opts.auto.onTimeoutStart.call(jQuerytt0, perc, dur2);
				}

				return true;
			});


			//	resume event
			jQuerycfs.bind(cf_e('resume', conf), function(e) {
				e.stopPropagation();
				if (scrl.isStopped)
				{
					scrl.isStopped = false;
					crsl.isPaused = false;
					crsl.isScrolling = true;
					scrl.startTime = getTime();
					sc_startScroll(scrl);
				}
				else
				{
					jQuerycfs.trigger(cf_e('play', conf));
				}
				return true;
			});


			//	prev + next events
			jQuerycfs.bind(cf_e('prev', conf)+' '+cf_e('next', conf), function(e, obj, num, clb, que) {
				e.stopPropagation();

				//	stopped or hidden carousel, don't scroll, don't queue
				if (crsl.isStopped || jQuerycfs.is(':hidden'))
				{
					e.stopImmediatePropagation();
					return debug(conf, 'Carousel stopped or hidden: Not scrolling.');
				}

				//	not enough items
				var minimum = (is_number(opts.items.minimum)) ? opts.items.minimum : opts.items.visible + 1;
				if (minimum > itms.total)
				{
					e.stopImmediatePropagation();
					return debug(conf, 'Not enough items ('+itms.total+' total, '+minimum+' needed): Not scrolling.');
				}

				//	get config
				var v = [obj, num, clb, que],
					t = ['object', 'number/string', 'function', 'boolean'],
					a = cf_sortParams(v, t);

				obj = a[0];
				num = a[1];
				clb = a[2];
				que = a[3];

				var eType = e.type.slice(conf.events.prefix.length);

				if (!is_object(obj))
				{
					obj = {};
				}
				if (is_function(clb))
				{
					obj.onAfter = clb;
				}
				if (is_boolean(que))
				{
					obj.queue = que;
				}
				obj = jQuery.extend(true, {}, opts[eType], obj);

				//	test conditions callback
				if (obj.conditions && !obj.conditions.call(jQuerytt0, eType))
				{
					e.stopImmediatePropagation();
					return debug(conf, 'Callback "conditions" returned false.');
				}

				if (!is_number(num))
				{
					if (opts.items.filter != '*')
					{
						num = 'visible';
					}
					else
					{
						var arr = [num, obj.items, opts[eType].items];
						for (var a = 0, l = arr.length; a < l; a++)
						{
							if (is_number(arr[a]) || arr[a] == 'page' || arr[a] == 'visible') {
								num = arr[a];
								break;
							}
						}
					}
					switch(num) {
						case 'page':
							e.stopImmediatePropagation();
							return jQuerycfs.triggerHandler(cf_e(eType+'Page', conf), [obj, clb]);
							break;

						case 'visible':
							if (!opts.items.visibleConf.variable && opts.items.filter == '*')
							{
								num = opts.items.visible;
							}
							break;
					}
				}

				//	resume animation, add current to queue
				if (scrl.isStopped)
				{
					jQuerycfs.trigger(cf_e('resume', conf));
					jQuerycfs.trigger(cf_e('queue', conf), [eType, [obj, num, clb]]);
					e.stopImmediatePropagation();
					return debug(conf, 'Carousel resumed scrolling.');
				}

				//	queue if scrolling
				if (obj.duration > 0)
				{
					if (crsl.isScrolling)
					{
						if (obj.queue)
						{
							jQuerycfs.trigger(cf_e('queue', conf), [eType, [obj, num, clb]]);
						}
						e.stopImmediatePropagation();
						return debug(conf, 'Carousel currently scrolling.');
					}
				}

				tmrs.timePassed = 0;
				jQuerycfs.trigger(cf_e('slide_'+eType, conf), [obj, num]);

				//	synchronise
				if (opts.synchronise)
				{
					var s = opts.synchronise,
						c = [obj, num];

					for (var j = 0, l = s.length; j < l; j++) {
						var d = eType;
						if (!s[j][2])
						{
							d = (d == 'prev') ? 'next' : 'prev';
						}
						if (!s[j][1])
						{
							c[0] = s[j][0].triggerHandler('_cfs_triggerEvent', ['configuration', d]);
						}
						c[1] = num + s[j][3];
						s[j][0].trigger('_cfs_triggerEvent', ['slide_'+d, c]);
					}
				}
				return true;
			});


			//	prev event
			jQuerycfs.bind(cf_e('slide_prev', conf), function(e, sO, nI) {
				e.stopPropagation();
				var a_itm = jQuerycfs.children();

				//	non-circular at start, scroll to end
				if (!opts.circular)
				{
					if (itms.first == 0)
					{
						if (opts.infinite)
						{
							jQuerycfs.trigger(cf_e('next', conf), itms.total-1);
						}
						return e.stopImmediatePropagation();
					}
				}

				sz_resetMargin(a_itm, opts);

				//	find number of items to scroll
				if (!is_number(nI))
				{
					if (opts.items.visibleConf.variable)
					{
						nI = gn_getVisibleItemsPrev(a_itm, opts, itms.total-1);
					}
					else if (opts.items.filter != '*')
					{
						var xI = (is_number(sO.items)) ? sO.items : gn_getVisibleOrg(jQuerycfs, opts);
						nI = gn_getScrollItemsPrevFilter(a_itm, opts, itms.total-1, xI);
					}
					else
					{
						nI = opts.items.visible;
					}
					nI = cf_getAdjust(nI, opts, sO.items, jQuerytt0);
				}

				//	prevent non-circular from scrolling to far
				if (!opts.circular)
				{
					if (itms.total - nI < itms.first)
					{
						nI = itms.total - itms.first;
					}
				}

				//	set new number of visible items
				opts.items.visibleConf.old = opts.items.visible;
				if (opts.items.visibleConf.variable)
				{
					var vI = cf_getItemsAdjust(gn_getVisibleItemsNext(a_itm, opts, itms.total-nI), opts, opts.items.visibleConf.adjust, jQuerytt0);
					if (opts.items.visible+nI <= vI && nI < itms.total)
					{
						nI++;
						vI = cf_getItemsAdjust(gn_getVisibleItemsNext(a_itm, opts, itms.total-nI), opts, opts.items.visibleConf.adjust, jQuerytt0);
					}
					opts.items.visible = vI;
				}
				else if (opts.items.filter != '*')
				{
					var vI = gn_getVisibleItemsNextFilter(a_itm, opts, itms.total-nI);
					opts.items.visible = cf_getItemsAdjust(vI, opts, opts.items.visibleConf.adjust, jQuerytt0);
				}

				sz_resetMargin(a_itm, opts, true);

				//	scroll 0, don't scroll
				if (nI == 0)
				{
					e.stopImmediatePropagation();
					return debug(conf, '0 items to scroll: Not scrolling.');
				}
				debug(conf, 'Scrolling '+nI+' items backward.');


				//	save new config
				itms.first += nI;
				while (itms.first >= itms.total)
				{
					itms.first -= itms.total;
				}

				//	non-circular callback
				if (!opts.circular)
				{
					if (itms.first == 0 && sO.onEnd)
					{
						sO.onEnd.call(jQuerytt0, 'prev');
					}
					if (!opts.infinite)
					{
						nv_enableNavi(opts, itms.first, conf);
					}
				}

				//	rearrange items
				jQuerycfs.children().slice(itms.total-nI, itms.total).prependTo(jQuerycfs);
				if (itms.total < opts.items.visible + nI)
				{
					jQuerycfs.children().slice(0, (opts.items.visible+nI)-itms.total).clone(true).appendTo(jQuerycfs);
				}

				//	the needed items
				var a_itm = jQuerycfs.children(),
					i_old = gi_getOldItemsPrev(a_itm, opts, nI),
					i_new = gi_getNewItemsPrev(a_itm, opts),
					i_cur_l = a_itm.eq(nI-1),
					i_old_l = i_old.last(),
					i_new_l = i_new.last();

				sz_resetMargin(a_itm, opts);

				var pL = 0,
					pR = 0;

				if (opts.align)
				{
					var p = cf_getAlignPadding(i_new, opts);
					pL = p[0];
					pR = p[1];
				}
				var oL = (pL < 0) ? opts.padding[opts.d[3]] : 0;

				//	hide items for fx directscroll
				var hiddenitems = false,
					i_skp = jQuery();
				if (opts.items.visible < nI)
				{
					i_skp = a_itm.slice(opts.items.visibleConf.old, nI);
					if (sO.fx == 'directscroll')
					{
						var orgW = opts.items[opts.d['width']];
						hiddenitems = i_skp;
						i_cur_l = i_new_l;
						sc_hideHiddenItems(hiddenitems);
						opts.items[opts.d['width']] = 'variable';
					}
				}

				//	save new sizes
				var jQuerycf2 = false,
					i_siz = ms_getTotalSize(a_itm.slice(0, nI), opts, 'width'),
					w_siz = cf_mapWrapperSizes(ms_getSizes(i_new, opts, true), opts, !opts.usePadding),
					i_siz_vis = 0,
					a_cfs = {},
					a_wsz = {},
					a_cur = {},
					a_old = {},
					a_new = {},
					a_lef = {},
					a_lef_vis = {},
					a_dur = sc_getDuration(sO, opts, nI, i_siz);

				switch(sO.fx)
				{
					case 'cover':
					case 'cover-fade':
						i_siz_vis = ms_getTotalSize(a_itm.slice(0, opts.items.visible), opts, 'width');
						break;
				}

				if (hiddenitems)
				{
					opts.items[opts.d['width']] = orgW;
				}

				sz_resetMargin(a_itm, opts, true);
				if (pR >= 0)
				{
					sz_resetMargin(i_old_l, opts, opts.padding[opts.d[1]]);
				}
				if (pL >= 0)
				{
					sz_resetMargin(i_cur_l, opts, opts.padding[opts.d[3]]);
				}

				if (opts.align)
				{
					opts.padding[opts.d[1]] = pR;
					opts.padding[opts.d[3]] = pL;
				}

				a_lef[opts.d['left']] = -(i_siz - oL);
				a_lef_vis[opts.d['left']] = -(i_siz_vis - oL);
				a_wsz[opts.d['left']] = w_siz[opts.d['width']];

				//	scrolling functions
				var _s_wrapper = function() {},
					_a_wrapper = function() {},
					_s_paddingold = function() {},
					_a_paddingold = function() {},
					_s_paddingnew = function() {},
					_a_paddingnew = function() {},
					_s_paddingcur = function() {},
					_a_paddingcur = function() {},
					_onafter = function() {},
					_moveitems = function() {},
					_position = function() {};

				//	clone carousel
				switch(sO.fx)
				{
					case 'crossfade':
					case 'cover':
					case 'cover-fade':
					case 'uncover':
					case 'uncover-fade':
						jQuerycf2 = jQuerycfs.clone(true).appendTo(jQuerywrp);
						break;
				}
				switch(sO.fx)
				{
					case 'crossfade':
					case 'uncover':
					case 'uncover-fade':
						jQuerycf2.children().slice(0, nI).remove();
						jQuerycf2.children().slice(opts.items.visibleConf.old).remove();
						break;

					case 'cover':
					case 'cover-fade':
						jQuerycf2.children().slice(opts.items.visible).remove();
						jQuerycf2.css(a_lef_vis);
						break;
				}

				jQuerycfs.css(a_lef);

				//	reset all scrolls
				scrl = sc_setScroll(a_dur, sO.easing);

				//	animate / set carousel
				a_cfs[opts.d['left']] = (opts.usePadding) ? opts.padding[opts.d[3]] : 0;

				//	animate / set wrapper
				if (opts[opts.d['width']] == 'variable' || opts[opts.d['height']] == 'variable')
				{
					_s_wrapper = function() {
						jQuerywrp.css(w_siz);
					};
					_a_wrapper = function() {
						scrl.anims.push([jQuerywrp, w_siz]);
					};
				}

				//	animate / set items
				if (opts.usePadding)
				{
					if (i_new_l.not(i_cur_l).length)
					{
			 			a_cur[opts.d['marginRight']] = i_cur_l.data('_cfs_origCssMargin');

						if (pL < 0)
						{
							i_cur_l.css(a_cur);
						}
						else
						{
							_s_paddingcur = function() {
								i_cur_l.css(a_cur);
							};
							_a_paddingcur = function() {
								scrl.anims.push([i_cur_l, a_cur]);
							};
						}
					}
					switch(sO.fx)
					{
						case 'cover':
						case 'cover-fade':
							jQuerycf2.children().eq(nI-1).css(a_cur);
							break;
					}

					if (i_new_l.not(i_old_l).length)
					{
						a_old[opts.d['marginRight']] = i_old_l.data('_cfs_origCssMargin');
						_s_paddingold = function() {
							i_old_l.css(a_old);
						};
						_a_paddingold = function() {
							scrl.anims.push([i_old_l, a_old]);
						};
					}

					if (pR >= 0)
					{
						a_new[opts.d['marginRight']] = i_new_l.data('_cfs_origCssMargin') + opts.padding[opts.d[1]];
						_s_paddingnew = function() {
							i_new_l.css(a_new);
						};
						_a_paddingnew = function() {
							scrl.anims.push([i_new_l, a_new]);
						};
					}
				}

				//	set position
				_position = function() {
					jQuerycfs.css(a_cfs);
				};


				var overFill = opts.items.visible+nI-itms.total;

				//	rearrange items
				_moveitems = function() {
					if (overFill > 0)
					{
						jQuerycfs.children().slice(itms.total).remove();
						i_old = jQuery( jQuerycfs.children().slice(itms.total-(opts.items.visible-overFill)).get().concat( jQuerycfs.children().slice(0, overFill).get() ) );
					}
					sc_showHiddenItems(hiddenitems);

					if (opts.usePadding)
					{
						var l_itm = jQuerycfs.children().eq(opts.items.visible+nI-1);
						l_itm.css(opts.d['marginRight'], l_itm.data('_cfs_origCssMargin'));
					}
				};


				var cb_arguments = sc_mapCallbackArguments(i_old, i_skp, i_new, nI, 'prev', a_dur, w_siz);

				//	fire onAfter callbacks
				_onafter = function() {
					sc_afterScroll(jQuerycfs, jQuerycf2, sO);
					crsl.isScrolling = false;
					clbk.onAfter = sc_fireCallbacks(jQuerytt0, sO, 'onAfter', cb_arguments, clbk);
					queu = sc_fireQueue(jQuerycfs, queu, conf);

					if (!crsl.isPaused)
					{
						jQuerycfs.trigger(cf_e('play', conf));
					}
				};

				//	fire onBefore callback
				crsl.isScrolling = true;
				tmrs = sc_clearTimers(tmrs);
				clbk.onBefore = sc_fireCallbacks(jQuerytt0, sO, 'onBefore', cb_arguments, clbk);

				switch(sO.fx)
				{
					case 'none':
						jQuerycfs.css(a_cfs);
						_s_wrapper();
						_s_paddingold();
						_s_paddingnew();
						_s_paddingcur();
						_position();
						_moveitems();
						_onafter();
						break;

					case 'fade':
						scrl.anims.push([jQuerycfs, { 'opacity': 0 }, function() {
							_s_wrapper();
							_s_paddingold();
							_s_paddingnew();
							_s_paddingcur();
							_position();
							_moveitems();
							scrl = sc_setScroll(a_dur, sO.easing);
							scrl.anims.push([jQuerycfs, { 'opacity': 1 }, _onafter]);
							sc_startScroll(scrl);
						}]);
						break;

					case 'crossfade':
						jQuerycfs.css({ 'opacity': 0 });
						scrl.anims.push([jQuerycf2, { 'opacity': 0 }]);
						scrl.anims.push([jQuerycfs, { 'opacity': 1 }, _onafter]);
						_a_wrapper();
						_s_paddingold();
						_s_paddingnew();
						_s_paddingcur();
						_position();
						_moveitems();
						break;

					case 'cover':
						scrl.anims.push([jQuerycf2, a_cfs, function() {
							_s_paddingold();
							_s_paddingnew();
							_s_paddingcur();
							_position();
							_moveitems();
							_onafter();
						}]);
						_a_wrapper();
						break;

					case 'cover-fade':
						scrl.anims.push([jQuerycfs, { 'opacity': 0 }]);
						scrl.anims.push([jQuerycf2, a_cfs, function() {
							jQuerycfs.css({ 'opacity': 1 });
							_s_paddingold();
							_s_paddingnew();
							_s_paddingcur();
							_position();
							_moveitems();
							_onafter();
						}]);
						_a_wrapper();
						break;

					case 'uncover':
						scrl.anims.push([jQuerycf2, a_wsz, _onafter]);
						_a_wrapper();
						_s_paddingold();
						_s_paddingnew();
						_s_paddingcur();
						_position();
						_moveitems();
						break;

					case 'uncover-fade':
						jQuerycfs.css({ 'opacity': 0 });
						scrl.anims.push([jQuerycfs, { 'opacity': 1 }]);
						scrl.anims.push([jQuerycf2, a_wsz, _onafter]);
						_a_wrapper();
						_s_paddingold();
						_s_paddingnew();
						_s_paddingcur();
						_position();
						_moveitems();
						break;

					default:
						scrl.anims.push([jQuerycfs, a_cfs, function() {
							_moveitems();
							_onafter();
						}]);
						_a_wrapper();
						_a_paddingold();
						_a_paddingnew();
						_a_paddingcur();
						break;
				}

				sc_startScroll(scrl);
				cf_setCookie(opts.cookie, jQuerycfs, conf);

				jQuerycfs.trigger(cf_e('updatePageStatus', conf), [false, w_siz]);

				return true;
			});


			//	next event
			jQuerycfs.bind(cf_e('slide_next', conf), function(e, sO, nI) {
				e.stopPropagation();
				var a_itm = jQuerycfs.children();

				//	non-circular at end, scroll to start
				if (!opts.circular)
				{
					if (itms.first == opts.items.visible)
					{
						if (opts.infinite)
						{
							jQuerycfs.trigger(cf_e('prev', conf), itms.total-1);
						}
						return e.stopImmediatePropagation();
					}
				}

				sz_resetMargin(a_itm, opts);

				//	find number of items to scroll
				if (!is_number(nI))
				{
					if (opts.items.filter != '*')
					{
						var xI = (is_number(sO.items)) ? sO.items : gn_getVisibleOrg(jQuerycfs, opts);
						nI = gn_getScrollItemsNextFilter(a_itm, opts, 0, xI);
					}
					else
					{
						nI = opts.items.visible;
					}
					nI = cf_getAdjust(nI, opts, sO.items, jQuerytt0);
				}

				var lastItemNr = (itms.first == 0) ? itms.total : itms.first;

				//	prevent non-circular from scrolling to far
				if (!opts.circular)
				{
					if (opts.items.visibleConf.variable)
					{
						var vI = gn_getVisibleItemsNext(a_itm, opts, nI),
							xI = gn_getVisibleItemsPrev(a_itm, opts, lastItemNr-1);
					}
					else
					{
						var vI = opts.items.visible,
							xI = opts.items.visible;
					}

					if (nI + vI > lastItemNr)
					{
						nI = lastItemNr - xI;
					}
				}

				//	set new number of visible items
				opts.items.visibleConf.old = opts.items.visible;
				if (opts.items.visibleConf.variable)
				{
					var vI = cf_getItemsAdjust(gn_getVisibleItemsNextTestCircular(a_itm, opts, nI, lastItemNr), opts, opts.items.visibleConf.adjust, jQuerytt0);
					while (opts.items.visible-nI >= vI && nI < itms.total)
					{
						nI++;
						vI = cf_getItemsAdjust(gn_getVisibleItemsNextTestCircular(a_itm, opts, nI, lastItemNr), opts, opts.items.visibleConf.adjust, jQuerytt0);
					}
					opts.items.visible = vI;
				}
				else if (opts.items.filter != '*')
				{
					var vI = gn_getVisibleItemsNextFilter(a_itm, opts, nI);
					opts.items.visible = cf_getItemsAdjust(vI, opts, opts.items.visibleConf.adjust, jQuerytt0);
				}

				sz_resetMargin(a_itm, opts, true);

				//	scroll 0, don't scroll
				if (nI == 0)
				{
					e.stopImmediatePropagation();
					return debug(conf, '0 items to scroll: Not scrolling.');
				}
				debug(conf, 'Scrolling '+nI+' items forward.');


				//	save new config
				itms.first -= nI;
				while (itms.first < 0)
				{
					itms.first += itms.total;
				}

				//	non-circular callback
				if (!opts.circular)
				{
					if (itms.first == opts.items.visible && sO.onEnd)
					{
						sO.onEnd.call(jQuerytt0, 'next');
					}
					if (!opts.infinite)
					{
						nv_enableNavi(opts, itms.first, conf);
					}
				}

				//	rearrange items
				if (itms.total < opts.items.visible+nI)
				{
					jQuerycfs.children().slice(0, (opts.items.visible+nI)-itms.total).clone(true).appendTo(jQuerycfs);
				}

				//	the needed items
				var a_itm = jQuerycfs.children(),
					i_old = gi_getOldItemsNext(a_itm, opts),
					i_new = gi_getNewItemsNext(a_itm, opts, nI),
					i_cur_l = a_itm.eq(nI-1),
					i_old_l = i_old.last(),
					i_new_l = i_new.last();

				sz_resetMargin(a_itm, opts);

				var pL = 0,
					pR = 0;

				if (opts.align)
				{
					var p = cf_getAlignPadding(i_new, opts);
					pL = p[0];
					pR = p[1];
				}

				//	hide items for fx directscroll
				var hiddenitems = false,
					i_skp = jQuery();
				if (opts.items.visibleConf.old < nI)
				{
					i_skp = a_itm.slice(opts.items.visibleConf.old, nI);
					if (sO.fx == 'directscroll')
					{
						var orgW = opts.items[opts.d['width']];
						hiddenitems = i_skp;
						i_cur_l = i_old_l;
						sc_hideHiddenItems(hiddenitems);
						opts.items[opts.d['width']] = 'variable';
					}
				}

				//	save new sizes
				var jQuerycf2 = false,
					i_siz = ms_getTotalSize(a_itm.slice(0, nI), opts, 'width'),
					w_siz = cf_mapWrapperSizes(ms_getSizes(i_new, opts, true), opts, !opts.usePadding),
					i_siz_vis = 0,
					a_cfs = {},
					a_cfs_vis = {},
					a_cur = {},
					a_old = {},
					a_lef = {},
					a_dur = sc_getDuration(sO, opts, nI, i_siz);

				switch(sO.fx)
				{
					case 'uncover':
					case 'uncover-fade':
						i_siz_vis = ms_getTotalSize(a_itm.slice(0, opts.items.visibleConf.old), opts, 'width');
						break;
				}

				if (hiddenitems)
				{
					opts.items[opts.d['width']] = orgW;
				}

				if (opts.align)
				{
					if (opts.padding[opts.d[1]] < 0)
					{
						opts.padding[opts.d[1]] = 0;
					}
				}
				sz_resetMargin(a_itm, opts, true);
				sz_resetMargin(i_old_l, opts, opts.padding[opts.d[1]]);

				if (opts.align)
				{
					opts.padding[opts.d[1]] = pR;
					opts.padding[opts.d[3]] = pL;
				}

				a_lef[opts.d['left']] = (opts.usePadding) ? opts.padding[opts.d[3]] : 0;

				//	scrolling functions
				var _s_wrapper = function() {},
					_a_wrapper = function() {},
					_s_paddingold = function() {},
					_a_paddingold = function() {},
					_s_paddingcur = function() {},
					_a_paddingcur = function() {},
					_onafter = function() {},
					_moveitems = function() {},
					_position = function() {};

				//	clone carousel
				switch(sO.fx)
				{
					case 'crossfade':
					case 'cover':
					case 'cover-fade':
					case 'uncover':
					case 'uncover-fade':
						jQuerycf2 = jQuerycfs.clone(true).appendTo(jQuerywrp);
						jQuerycf2.children().slice(opts.items.visibleConf.old).remove();
						break;
				}
				switch(sO.fx)
				{
					case 'crossfade':
					case 'cover':
					case 'cover-fade':
						jQuerycfs.css('zIndex', 1);
						jQuerycf2.css('zIndex', 0);
						break;
				}

				//	reset all scrolls
				scrl = sc_setScroll(a_dur, sO.easing);

				//	animate / set carousel
				a_cfs[opts.d['left']] = -i_siz;
				a_cfs_vis[opts.d['left']] = -i_siz_vis;

				if (pL < 0)
				{
					a_cfs[opts.d['left']] += pL;
				}

				//	animate / set wrapper
				if (opts[opts.d['width']] == 'variable' || opts[opts.d['height']] == 'variable')
				{
					_s_wrapper = function() {
						jQuerywrp.css(w_siz);
					};
					_a_wrapper = function() {
						scrl.anims.push([jQuerywrp, w_siz]);
					};
				}

				//	animate / set items
				if (opts.usePadding)
				{
					var i_new_l_m = i_new_l.data('_cfs_origCssMargin');
					if (pR >= 0)
					{
						i_new_l_m += opts.padding[opts.d[1]];
					}
					i_new_l.css(opts.d['marginRight'], i_new_l_m);

					if (i_cur_l.not(i_old_l).length)
					{
						a_old[opts.d['marginRight']] = i_old_l.data('_cfs_origCssMargin');
					}
					_s_paddingold = function() {
						i_old_l.css(a_old);
					};
					_a_paddingold = function() {
						scrl.anims.push([i_old_l, a_old]);
					};

					var i_cur_l_m = i_cur_l.data('_cfs_origCssMargin');
					if (pL > 0)
					{
						i_cur_l_m += opts.padding[opts.d[3]];
					}
					a_cur[opts.d['marginRight']] = i_cur_l_m;
					_s_paddingcur = function() {
						i_cur_l.css(a_cur);
					};
					_a_paddingcur = function() {
						scrl.anims.push([i_cur_l, a_cur]);
					};
				}

				//	set position
				_position = function() {
					jQuerycfs.css(a_lef);
				};


				var overFill = opts.items.visible+nI-itms.total;

				//	rearrange items
				_moveitems = function() {
					if (overFill > 0)
					{
						jQuerycfs.children().slice(itms.total).remove();
					}
					var l_itm = jQuerycfs.children().slice(0, nI).appendTo(jQuerycfs).last();
					if (overFill > 0)
					{
						i_new = gi_getCurrentItems(a_itm, opts);
					}
					sc_showHiddenItems(hiddenitems);

					if (opts.usePadding)
					{
						if (itms.total < opts.items.visible+nI) {
							var i_cur_l = jQuerycfs.children().eq(opts.items.visible-1);
							i_cur_l.css(opts.d['marginRight'], i_cur_l.data('_cfs_origCssMargin') + opts.padding[opts.d[3]]);
						}
						l_itm.css(opts.d['marginRight'], l_itm.data('_cfs_origCssMargin'));
					}
				};


				var cb_arguments = sc_mapCallbackArguments(i_old, i_skp, i_new, nI, 'next', a_dur, w_siz);

				//	fire onAfter callbacks
				_onafter = function() {
					jQuerycfs.css('zIndex', jQuerycfs.data('_cfs_origCss').zIndex);
					sc_afterScroll(jQuerycfs, jQuerycf2, sO);
					crsl.isScrolling = false;
					clbk.onAfter = sc_fireCallbacks(jQuerytt0, sO, 'onAfter', cb_arguments, clbk);
					queu = sc_fireQueue(jQuerycfs, queu, conf);
					
					if (!crsl.isPaused)
					{
						jQuerycfs.trigger(cf_e('play', conf));
					}
				};

				//	fire onBefore callbacks
				crsl.isScrolling = true;
				tmrs = sc_clearTimers(tmrs);
				clbk.onBefore = sc_fireCallbacks(jQuerytt0, sO, 'onBefore', cb_arguments, clbk);

				switch(sO.fx)
				{
					case 'none':
						jQuerycfs.css(a_cfs);
						_s_wrapper();
						_s_paddingold();
						_s_paddingcur();
						_position();
						_moveitems();
						_onafter();
						break;

					case 'fade':
						scrl.anims.push([jQuerycfs, { 'opacity': 0 }, function() {
							_s_wrapper();
							_s_paddingold();
							_s_paddingcur();
							_position();
							_moveitems();
							scrl = sc_setScroll(a_dur, sO.easing);
							scrl.anims.push([jQuerycfs, { 'opacity': 1 }, _onafter]);
							sc_startScroll(scrl);
						}]);
						break;

					case 'crossfade':
						jQuerycfs.css({ 'opacity': 0 });
						scrl.anims.push([jQuerycf2, { 'opacity': 0 }]);
						scrl.anims.push([jQuerycfs, { 'opacity': 1 }, _onafter]);
						_a_wrapper();
						_s_paddingold();
						_s_paddingcur();
						_position();
						_moveitems();
						break;

					case 'cover':
						jQuerycfs.css(opts.d['left'], jQuerywrp[opts.d['width']]());
						scrl.anims.push([jQuerycfs, a_lef, _onafter]);
						_a_wrapper();
						_s_paddingold();
						_s_paddingcur();
						_moveitems();
						break;

					case 'cover-fade':
						jQuerycfs.css(opts.d['left'], jQuerywrp[opts.d['width']]());
						scrl.anims.push([jQuerycf2, { 'opacity': 0 }]);
						scrl.anims.push([jQuerycfs, a_lef, _onafter]);
						_a_wrapper();
						_s_paddingold();
						_s_paddingcur();
						_moveitems();
						break;

					case 'uncover':
						scrl.anims.push([jQuerycf2, a_cfs_vis, _onafter]);
						_a_wrapper();
						_s_paddingold();
						_s_paddingcur();
						_position();
						_moveitems();
						break;

					case 'uncover-fade':
						jQuerycfs.css({ 'opacity': 0 });
						scrl.anims.push([jQuerycfs, { 'opacity': 1 }]);
						scrl.anims.push([jQuerycf2, a_cfs_vis, _onafter]);
						_a_wrapper();
						_s_paddingold();
						_s_paddingcur();
						_position();
						_moveitems();
						break;

					default:
						scrl.anims.push([jQuerycfs, a_cfs, function() {
							_position();
							_moveitems();
							_onafter();
						}]);
						_a_wrapper();
						_a_paddingold();
						_a_paddingcur();
						break;
				}

				sc_startScroll(scrl);
				cf_setCookie(opts.cookie, jQuerycfs, conf);

				jQuerycfs.trigger(cf_e('updatePageStatus', conf), [false, w_siz]);

				return true;
			});


			//	slideTo event
			jQuerycfs.bind(cf_e('slideTo', conf), function(e, num, dev, org, obj, dir, clb) {
				e.stopPropagation();

				var v = [num, dev, org, obj, dir, clb],
					t = ['string/number/object', 'number', 'boolean', 'object', 'string', 'function'],
					a = cf_sortParams(v, t);

				obj = a[3];
				dir = a[4];
				clb = a[5];

				num = gn_getItemIndex(a[0], a[1], a[2], itms, jQuerycfs);

				if (num == 0)
				{
					return false;
				}
				if (!is_object(obj))
				{
					obj = false;
				}

				if (crsl.isScrolling)
				{
					if (!is_object(obj) || obj.duration > 0)
					{
						return false;
					}
				}

				if (dir != 'prev' && dir != 'next')
				{
					if (opts.circular)
					{
						dir = (num <= itms.total / 2) ? 'next' : 'prev';
					}
					else
					{
						dir = (itms.first == 0 || itms.first > num) ? 'next' : 'prev';
					}
				}

				if (dir == 'prev')
				{
					num = itms.total-num;
				}
				jQuerycfs.trigger(cf_e(dir, conf), [obj, num, clb]);

				return true;
			});


			//	prevPage event
			jQuerycfs.bind(cf_e('prevPage', conf), function(e, obj, clb) {
				e.stopPropagation();
				var cur = jQuerycfs.triggerHandler(cf_e('currentPage', conf));
				return jQuerycfs.triggerHandler(cf_e('slideToPage', conf), [cur-1, obj, 'prev', clb]);
			});


			//	nextPage event
			jQuerycfs.bind(cf_e('nextPage', conf), function(e, obj, clb) {
				e.stopPropagation();
				var cur = jQuerycfs.triggerHandler(cf_e('currentPage', conf));
				return jQuerycfs.triggerHandler(cf_e('slideToPage', conf), [cur+1, obj, 'next', clb]);
			});


			//	slideToPage event
			jQuerycfs.bind(cf_e('slideToPage', conf), function(e, pag, obj, dir, clb) {
				e.stopPropagation();
				if (!is_number(pag))
				{
					pag = jQuerycfs.triggerHandler(cf_e('currentPage', conf));
				}
				var ipp = opts.pagination.items || opts.items.visible,
					max = Math.ceil(itms.total / ipp)-1;

				if (pag < 0)
				{
					pag = max;
				}
				if (pag > max)
				{
					pag = 0;
				}
				return jQuerycfs.triggerHandler(cf_e('slideTo', conf), [pag*ipp, 0, true, obj, dir, clb]);
			});

			//	jumpToStart event
			jQuerycfs.bind(cf_e('jumpToStart', conf), function(e, s) {
				e.stopPropagation();
				if (s)
				{
					s = gn_getItemIndex(s, 0, true, itms, jQuerycfs);
				}
				else
				{
					s = 0;
				}

				s += itms.first;
				if (s != 0)
				{
					if (itms.total > 0)
					{
						while (s > itms.total)
						{
							s -= itms.total;
						}
					}
					jQuerycfs.prepend(jQuerycfs.children().slice(s, itms.total));
				}
				return true;
			});


			//	synchronise event
			jQuerycfs.bind(cf_e('synchronise', conf), function(e, s) {
				e.stopPropagation();
				if (s)
				{
					s = cf_getSynchArr(s);
				}
				else if (opts.synchronise)
				{
					s = opts.synchronise;
				}
				else
				{
					return debug(conf, 'No carousel to synchronise.');
				}

				var n = jQuerycfs.triggerHandler(cf_e('currentPosition', conf)),
					x = true;

				for (var j = 0, l = s.length; j < l; j++)
				{
					if (!s[j][0].triggerHandler(cf_e('slideTo', conf), [n, s[j][3], true]))
					{
						x = false;
					}
				}
				return x;
			});


			//	queue event
			jQuerycfs.bind(cf_e('queue', conf), function(e, dir, opt) {
				e.stopPropagation();
				if (is_function(dir))
				{
					dir.call(jQuerytt0, queu);
				}
				else if (is_array(dir))
				{
					queu = dir;
				}
				else if (!is_undefined(dir))
				{
					queu.push([dir, opt]);
				}
				return queu;
			});


			//	insertItem event
			jQuerycfs.bind(cf_e('insertItem', conf), function(e, itm, num, org, dev) {
				e.stopPropagation();

				var v = [itm, num, org, dev],
					t = ['string/object', 'string/number/object', 'boolean', 'number'],
					a = cf_sortParams(v, t);

				itm = a[0];
				num = a[1];
				org = a[2];
				dev = a[3];

				if (is_object(itm) && !is_jquery(itm))
				{ 
					itm = jQuery(itm);
				}
				else if (is_string(itm))
				{
					itm = jQuery(itm);
				}
				if (!is_jquery(itm) || itm.length == 0)
				{
					return debug(conf, 'Not a valid object.');
				}

				if (is_undefined(num))
				{
					num = 'end';
				}

				sz_storeMargin(itm, opts);
				sz_storeSizes(itm, opts);

				var orgNum = num,
					before = 'before';

				if (num == 'end')
				{
					if (org)
					{
						if (itms.first == 0)
						{
							num = itms.total-1;
							before = 'after';
						}
						else
						{
							num = itms.first;
							itms.first += itm.length;
						}
						if (num < 0)
						{
							num = 0;
						}
					}
					else
					{
						num = itms.total-1;
						before = 'after';
					}
				}
				else
				{
					num = gn_getItemIndex(num, dev, org, itms, jQuerycfs);
				}

				var jQuerycit = jQuerycfs.children().eq(num);
				if (jQuerycit.length)
				{
					jQuerycit[before](itm);
				}
				else
				{
					debug(conf, 'Correct insert-position not found! Appending item to the end.');
					jQuerycfs.append(itm);
				}

				if (orgNum != 'end' && !org)
				{
					if (num < itms.first)
					{
						itms.first += itm.length;
					}
				}
				itms.total = jQuerycfs.children().length;
				if (itms.first >= itms.total)
				{
					itms.first -= itms.total;
				}

				jQuerycfs.trigger(cf_e('updateSizes', conf));
				jQuerycfs.trigger(cf_e('linkAnchors', conf));

				return true;
			});


			//	removeItem event
			jQuerycfs.bind(cf_e('removeItem', conf), function(e, num, org, dev) {
				e.stopPropagation();

				var v = [num, org, dev],
					t = ['string/number/object', 'boolean', 'number'],
					a = cf_sortParams(v, t);

				num = a[0];
				org = a[1];
				dev = a[2];

				var removed = false;
				if (num instanceof jQuery && num.length > 1)
				{
					jQueryremoved = jQuery();
					num.each(function(i, el) {
						var jQueryrem = jQuerycfs.trigger(cf_e('removeItem', conf), [jQuery(this), org, dev]);
						if (jQueryrem) jQueryremoved = jQueryremoved.add(jQueryrem);
					});
					return jQueryremoved;
				}

				if (is_undefined(num) || num == 'end')
				{
					jQueryremoved = jQuerycfs.children().last();
				}
				else
				{
					num = gn_getItemIndex(num, dev, org, itms, jQuerycfs);
					var jQueryremoved = jQuerycfs.children().eq(num);
					if (jQueryremoved.length){
						if (num < itms.first) itms.first -= jQueryremoved.length;
					}
				}
				if (jQueryremoved && jQueryremoved.length)
				{
					jQueryremoved.detach();
					itms.total = jQuerycfs.children().length;
					jQuerycfs.trigger(cf_e('updateSizes', conf));
				}

				return jQueryremoved;
			});


			//	onBefore and onAfter event
			jQuerycfs.bind(cf_e('onBefore', conf)+' '+cf_e('onAfter', conf), function(e, fn) {
				e.stopPropagation();
				var eType = e.type.slice(conf.events.prefix.length);
				if (is_array(fn))
				{
					clbk[eType] = fn;
				}
				if (is_function(fn))
				{
					clbk[eType].push(fn);
				}
				return clbk[eType];
			});


			//	currentPosition event
			jQuerycfs.bind(cf_e('currentPosition', conf), function(e, fn) {
				e.stopPropagation();
				if (itms.first == 0)
				{
					var val = 0;
				}
				else
				{
					var val = itms.total - itms.first;
				}
				if (is_function(fn))
				{
					fn.call(jQuerytt0, val);
				}
				return val;
			});


			//	currentPage event
			jQuerycfs.bind(cf_e('currentPage', conf), function(e, fn) {
				e.stopPropagation();
				var ipp = opts.pagination.items || opts.items.visible,
					max = Math.ceil(itms.total/ipp-1),
					nr;
				if (itms.first == 0)
				{
					nr = 0;
				}
				else if (itms.first < itms.total % ipp)
				{
					nr = 0;
				}
				else if (itms.first == ipp && !opts.circular)
				{
					nr = max;
				}
				else 
				{
					 nr = Math.round((itms.total-itms.first)/ipp);
				}
				if (nr < 0)
				{
					nr = 0;
				}
				if (nr > max)
				{
					nr = max;
				}
				if (is_function(fn))
				{
					fn.call(jQuerytt0, nr);
				}
				return nr;
			});


			//	currentVisible event
			jQuerycfs.bind(cf_e('currentVisible', conf), function(e, fn) {
				e.stopPropagation();
				var jQueryi = gi_getCurrentItems(jQuerycfs.children(), opts);
				if (is_function(fn))
				{
					fn.call(jQuerytt0, jQueryi);
				}
				return jQueryi;
			});


			//	slice event
			jQuerycfs.bind(cf_e('slice', conf), function(e, f, l, fn) {
				e.stopPropagation();

				if (itms.total == 0)
				{
					return false;
				}

				var v = [f, l, fn],
					t = ['number', 'number', 'function'],
					a = cf_sortParams(v, t);

				f = (is_number(a[0])) ? a[0] : 0;
				l = (is_number(a[1])) ? a[1] : itms.total;
				fn = a[2];

				f += itms.first;
				l += itms.first;

				if (items.total > 0)
				{
					while (f > itms.total)
					{
						f -= itms.total;
					}
					while (l > itms.total)
					{
						l -= itms.total;
					}
					while (f < 0)
					{
						f += itms.total;
					}
					while (l < 0)
					{
						l += itms.total;
					}
				}
				var jQueryiA = jQuerycfs.children(),
					jQueryi;

				if (l > f)
				{
					jQueryi = jQueryiA.slice(f, l);
				}
				else
				{
					jQueryi = jQuery( jQueryiA.slice(f, itms.total).get().concat( jQueryiA.slice(0, l).get() ) );
				}

				if (is_function(fn))
				{
					fn.call(jQuerytt0, jQueryi);
				}
				return jQueryi;
			});


			//	isPaused, isStopped and isScrolling events
			jQuerycfs.bind(cf_e('isPaused', conf)+' '+cf_e('isStopped', conf)+' '+cf_e('isScrolling', conf), function(e, fn) {
				e.stopPropagation();
				var eType = e.type.slice(conf.events.prefix.length),
					value = crsl[eType];
				if (is_function(fn))
				{
					fn.call(jQuerytt0, value);
				}
				return value;
			});


			//	configuration event
			jQuerycfs.bind(cf_e('configuration', conf), function(e, a, b, c) {
				e.stopPropagation();
				var reInit = false;

				//	return entire configuration-object
				if (is_function(a))
				{
					a.call(jQuerytt0, opts);
				}
				//	set multiple options via object
				else if (is_object(a))
				{
					opts_orig = jQuery.extend(true, {}, opts_orig, a);
					if (b !== false) reInit = true;
					else opts = jQuery.extend(true, {}, opts, a);

				}
				else if (!is_undefined(a))
				{

					//	callback function for specific option
					if (is_function(b))
					{
						var val = eval('opts.'+a);
						if (is_undefined(val))
						{
							val = '';
						}
						b.call(jQuerytt0, val);
					}
					//	set individual option
					else if (!is_undefined(b))
					{
						if (typeof c !== 'boolean') c = true;
						eval('opts_orig.'+a+' = b');
						if (c !== false) reInit = true;
						else eval('opts.'+a+' = b');
					}
					//	return value for specific option
					else
					{
						return eval('opts.'+a);
					}
				}
				if (reInit)
				{
					sz_resetMargin(jQuerycfs.children(), opts);
					jQuerycfs._cfs_init(opts_orig);
					jQuerycfs._cfs_bind_buttons();
					var sz = sz_setSizes(jQuerycfs, opts);
					jQuerycfs.trigger(cf_e('updatePageStatus', conf), [true, sz]);
				}
				return opts;
			});


			//	linkAnchors event
			jQuerycfs.bind(cf_e('linkAnchors', conf), function(e, jQuerycon, sel) {
				e.stopPropagation();

				if (is_undefined(jQuerycon))
				{
					jQuerycon = jQuery('body');
				}
				else if (is_string(jQuerycon))
				{
					jQuerycon = jQuery(jQuerycon);
				}
				if (!is_jquery(jQuerycon) || jQuerycon.length == 0)
				{
					return debug(conf, 'Not a valid object.');
				}
				if (!is_string(sel))
				{
					sel = 'a.caroufredsel';
				}

				jQuerycon.find(sel).each(function() {
					var h = this.hash || '';
					if (h.length > 0 && jQuerycfs.children().index(jQuery(h)) != -1)
					{
						jQuery(this).unbind('click').click(function(e) {
							e.preventDefault();
							jQuerycfs.trigger(cf_e('slideTo', conf), h);
						});
					}
				});
				return true;
			});


			//	updatePageStatus event
			jQuerycfs.bind(cf_e('updatePageStatus', conf), function(e, build, sizes) {
				e.stopPropagation();
				if (!opts.pagination.container)
				{
					return;
				}

				var ipp = opts.pagination.items || opts.items.visible,
					pgs = Math.ceil(itms.total/ipp);

				if (build)
				{
					if (opts.pagination.anchorBuilder)
					{
						opts.pagination.container.children().remove();
						opts.pagination.container.each(function() {
							for (var a = 0; a < pgs; a++)
							{
								var i = jQuerycfs.children().eq( gn_getItemIndex(a*ipp, 0, true, itms, jQuerycfs) );
								jQuery(this).append(opts.pagination.anchorBuilder.call(i[0], a+1));
							}
						});
					}
					opts.pagination.container.each(function() {
						jQuery(this).children().unbind(opts.pagination.event).each(function(a) {
							jQuery(this).bind(opts.pagination.event, function(e) {
								e.preventDefault();
								jQuerycfs.trigger(cf_e('slideTo', conf), [a*ipp, -opts.pagination.deviation, true, opts.pagination]);
							});
						});
					});
				}

				var selected = jQuerycfs.triggerHandler(cf_e('currentPage', conf)) + opts.pagination.deviation;
				if (selected >= pgs)
				{
					selected = 0;
				}
				if (selected < 0)
				{
					selected = pgs-1;
				}
				opts.pagination.container.each(function() {
					jQuery(this).children().removeClass(cf_c('selected', conf)).eq(selected).addClass(cf_c('selected', conf));
				});
				return true;
			});


			//	updateSizes event
			jQuerycfs.bind(cf_e('updateSizes', conf), function(e) {
				var vI = opts.items.visible,
					a_itm = jQuerycfs.children(),
					avail_primary = ms_getParentSize(jQuerywrp, opts, 'width');

				itms.total = a_itm.length;
				opts.maxDimension = ms_getMaxDimension(opts, avail_primary);

				if (crsl.primarySizePercentage)
				{
					opts[opts.d['width']] = ms_getPercentage(avail_primary, crsl.primarySizePercentage);
				}
				if (opts.responsive)
				{
					opts.items.width = opts.items.sizesConf.width;
					opts.items.height = opts.items.sizesConf.height;
					opts = in_getResponsiveValues(opts, a_itm, avail_primary);
					vI = opts.items.visible;
					sz_setResponsiveSizes(opts, a_itm);
				}
				else if (opts.items.visibleConf.variable)
				{
					vI = gn_getVisibleItemsNext(a_itm, opts, 0);
				}
				else if (opts.items.filter != '*')
				{
					vI = gn_getVisibleItemsNextFilter(a_itm, opts, 0);
				}

				if (!opts.circular && itms.first != 0 && vI > itms.first) {
					if (opts.items.visibleConf.variable)
					{
						var nI = gn_getVisibleItemsPrev(a_itm, opts, itms.first) - itms.first;
					}
					else if (opts.items.filter != '*')
					{
						var nI = gn_getVisibleItemsPrevFilter(a_itm, opts, itms.first) - itms.first;
					}
					else
					{
						var nI = opts.items.visible - itms.first;
					}
					debug(conf, 'Preventing non-circular: sliding '+nI+' items backward.');
					jQuerycfs.trigger(cf_e('prev', conf), nI);
				}

				opts.items.visible = cf_getItemsAdjust(vI, opts, opts.items.visibleConf.adjust, jQuerytt0);
				opts.items.visibleConf.old = opts.items.visible;
				opts = in_getAlignPadding(opts, a_itm);

				var sz = sz_setSizes(jQuerycfs, opts);
				jQuerycfs.trigger(cf_e('updatePageStatus', conf), [true, sz]);
				nv_showNavi(opts, itms.total, conf);
				nv_enableNavi(opts, itms.first, conf);

				return sz;
			});


			//	destroy event
			jQuerycfs.bind(cf_e('destroy', conf), function(e, orgOrder) {
				e.stopPropagation();
				tmrs = sc_clearTimers(tmrs);

				jQuerycfs.data('_cfs_isCarousel', false);
				jQuerycfs.trigger(cf_e('finish', conf));
				if (orgOrder)
				{
					jQuerycfs.trigger(cf_e('jumpToStart', conf));
				}
				sz_resetMargin(jQuerycfs.children(), opts);
				if (opts.responsive)
				{
					jQuerycfs.children().each(function() {
						jQuery(this).css(jQuery(this).data('_cfs_origCssSizes'));
					});
				}

				jQuerycfs.css(jQuerycfs.data('_cfs_origCss'));
				jQuerycfs._cfs_unbind_events();
				jQuerycfs._cfs_unbind_buttons();
				jQuerywrp.replaceWith(jQuerycfs);

				return true;
			});


			//	debug event
			jQuerycfs.bind(cf_e('debug', conf), function(e) {
				debug(conf, 'Carousel width: '+opts.width);
				debug(conf, 'Carousel height: '+opts.height);
				debug(conf, 'Item widths: '+opts.items.width);
				debug(conf, 'Item heights: '+opts.items.height);
				debug(conf, 'Number of items visible: '+opts.items.visible);
				if (opts.auto.play)
				{
					debug(conf, 'Number of items scrolled automatically: '+opts.auto.items);
				}
				if (opts.prev.button)
				{
					debug(conf, 'Number of items scrolled backward: '+opts.prev.items);
				}
				if (opts.next.button)
				{
					debug(conf, 'Number of items scrolled forward: '+opts.next.items);
				}
				return conf.debug;
			});


			//	triggerEvent, making prefixed and namespaced events accessible from outside
			jQuerycfs.bind('_cfs_triggerEvent', function(e, n, o) {
				e.stopPropagation();
				return jQuerycfs.triggerHandler(cf_e(n, conf), o);
			});
		};	//	/bind_events


		jQuerycfs._cfs_unbind_events = function() {
			jQuerycfs.unbind(cf_e('', conf));
			jQuerycfs.unbind(cf_e('', conf, false));
			jQuerycfs.unbind('_cfs_triggerEvent');
		};	//	/unbind_events


		jQuerycfs._cfs_bind_buttons = function() {
			jQuerycfs._cfs_unbind_buttons();
			nv_showNavi(opts, itms.total, conf);
			nv_enableNavi(opts, itms.first, conf);

			if (opts.auto.pauseOnHover)
			{
				var pC = bt_pauseOnHoverConfig(opts.auto.pauseOnHover);
				jQuerywrp.bind(cf_e('mouseenter', conf, false), function() { jQuerycfs.trigger(cf_e('pause', conf), pC);	})
					.bind(cf_e('mouseleave', conf, false), function() { jQuerycfs.trigger(cf_e('resume', conf));		});
			}

			//	play button
			if (opts.auto.button)
			{
				opts.auto.button.bind(cf_e(opts.auto.event, conf, false), function(e) {
					e.preventDefault();
					var ev = false,
						pC = null;

					if (crsl.isPaused)
					{
						ev = 'play';
					}
					else if (opts.auto.pauseOnEvent)
					{
						ev = 'pause';
						pC = bt_pauseOnHoverConfig(opts.auto.pauseOnEvent);
					}
					if (ev)
					{
						jQuerycfs.trigger(cf_e(ev, conf), pC);
					}
				});
			}

			//	prev button
			if (opts.prev.button)
			{
				opts.prev.button.bind(cf_e(opts.prev.event, conf, false), function(e) {
					e.preventDefault();
					jQuerycfs.trigger(cf_e('prev', conf));
				});
				if (opts.prev.pauseOnHover)
				{
					var pC = bt_pauseOnHoverConfig(opts.prev.pauseOnHover);
					opts.prev.button.bind(cf_e('mouseenter', conf, false), function() { jQuerycfs.trigger(cf_e('pause', conf), pC);	})
									.bind(cf_e('mouseleave', conf, false), function() { jQuerycfs.trigger(cf_e('resume', conf));		});
				}
			}

			//	next butotn
			if (opts.next.button)
			{
				opts.next.button.bind(cf_e(opts.next.event, conf, false), function(e) {
					e.preventDefault();
					jQuerycfs.trigger(cf_e('next', conf));
				});
				if (opts.next.pauseOnHover)
				{
					var pC = bt_pauseOnHoverConfig(opts.next.pauseOnHover);
					opts.next.button.bind(cf_e('mouseenter', conf, false), function() { jQuerycfs.trigger(cf_e('pause', conf), pC); 	})
									.bind(cf_e('mouseleave', conf, false), function() { jQuerycfs.trigger(cf_e('resume', conf));		});
				}
			}

			//	pagination
			if (opts.pagination.container)
			{
				if (opts.pagination.pauseOnHover)
				{
					var pC = bt_pauseOnHoverConfig(opts.pagination.pauseOnHover);
					opts.pagination.container.bind(cf_e('mouseenter', conf, false), function() { jQuerycfs.trigger(cf_e('pause', conf), pC);	})
											 .bind(cf_e('mouseleave', conf, false), function() { jQuerycfs.trigger(cf_e('resume', conf));	});
				}
			}

			//	prev/next keys
			if (opts.prev.key || opts.next.key)
			{
				jQuery(document).bind(cf_e('keyup', conf, false, true, true), function(e) {
					var k = e.keyCode;
					if (k == opts.next.key)
					{
						e.preventDefault();
						jQuerycfs.trigger(cf_e('next', conf));
					}
					if (k == opts.prev.key)
					{
						e.preventDefault();
						jQuerycfs.trigger(cf_e('prev', conf));
					}
				});
			}

			//	pagination keys
			if (opts.pagination.keys)
			{
				jQuery(document).bind(cf_e('keyup', conf, false, true, true), function(e) {
					var k = e.keyCode;
					if (k >= 49 && k < 58)
					{
						k = (k-49) * opts.items.visible;
						if (k <= itms.total)
						{
							e.preventDefault();
							jQuerycfs.trigger(cf_e('slideTo', conf), [k, 0, true, opts.pagination]);
						}
					}
				});
			}


			//	DEPRECATED
			if (opts.prev.wipe || opts.next.wipe)
			{
				deprecated( 'the touchwipe-plugin', 'the touchSwipe-plugin' );
				if (jQuery.fn.touchwipe)
				{
					var wP = (opts.prev.wipe) ? function() { jQuerycfs.trigger(cf_e('prev', conf)) } : null,
						wN = (opts.next.wipe) ? function() { jQuerycfs.trigger(cf_e('next', conf)) } : null;

					if (wN || wN)
					{
						if (!crsl.touchwipe)
						{
							crsl.touchwipe = true;
							var twOps = {
								'min_move_x': 30,
								'min_move_y': 30,
								'preventDefaultEvents': true
							};
							switch (opts.direction)
							{
								case 'up':
								case 'down':
									twOps.wipeUp = wP;
									twOps.wipeDown = wN;
									break;
								default:
									twOps.wipeLeft = wN;
									twOps.wipeRight = wP;
							}
							jQuerywrp.touchwipe(twOps);
						}
					}
				}
			}
			//	/DEPRECATED


			//	swipe
			if (jQuery.fn.swipe)
			{
				var isTouch = 'ontouchstart' in window;
				if ((isTouch && opts.swipe.onTouch) || (!isTouch && opts.swipe.onMouse))
				{
					var scP = jQuery.extend(true, {}, opts.prev, opts.swipe),
						scN = jQuery.extend(true, {}, opts.next, opts.swipe),
						swP = function() { jQuerycfs.trigger(cf_e('prev', conf), [scP]) },
						swN = function() { jQuerycfs.trigger(cf_e('next', conf), [scN]) };

					switch (opts.direction)
					{
						case 'up':
						case 'down':
							opts.swipe.options.swipeUp = swN;
							opts.swipe.options.swipeDown = swP;
							break;
						default:
							opts.swipe.options.swipeLeft = swN;
							opts.swipe.options.swipeRight = swP;
					}
					if (crsl.swipe)
					{
						jQuerycfs.swipe('destroy');
					}
					jQuerywrp.swipe(opts.swipe.options);
					jQuerywrp.css('cursor', 'move');
					crsl.swipe = true;
				}
			}

			//	mousewheel
			if (jQuery.fn.mousewheel)
			{


				//	DEPRECATED
				if (opts.prev.mousewheel)
				{
					deprecated('The prev.mousewheel option', 'the mousewheel configuration object');
					opts.prev.mousewheel = null;
					opts.mousewheel = {
						items: bt_mousesheelNumber(opts.prev.mousewheel)
					};
				}
				if (opts.next.mousewheel)
				{
					deprecated('The next.mousewheel option', 'the mousewheel configuration object');
					opts.next.mousewheel = null;
					opts.mousewheel = {
						items: bt_mousesheelNumber(opts.next.mousewheel)
					};
				}
				//	/DEPRECATED


				if (opts.mousewheel)
				{
					var mcP = jQuery.extend(true, {}, opts.prev, opts.mousewheel),
						mcN = jQuery.extend(true, {}, opts.next, opts.mousewheel);

					if (crsl.mousewheel)
					{
						jQuerywrp.unbind(cf_e('mousewheel', conf, false));
					}
					jQuerywrp.bind(cf_e('mousewheel', conf, false), function(e, delta) { 
						e.preventDefault();
						if (delta > 0)
						{
							jQuerycfs.trigger(cf_e('prev', conf), [mcP]);
						}
						else
						{
							jQuerycfs.trigger(cf_e('next', conf), [mcN]);
						}
					});
					crsl.mousewheel = true;
				}
			}

			if (opts.auto.play)
			{
				jQuerycfs.trigger(cf_e('play', conf), opts.auto.delay);
			}

			if (crsl.upDateOnWindowResize)
			{
				var jQueryw = jQuery(window),
					_windowWidth = 0,
					_windowHeight = 0;

				jQueryw.bind(cf_e('resize', conf, false, true, true), function(e) {
					var nw = jQueryw.width(),
						nh = jQueryw.height();

					if (nw != _windowWidth || nh != _windowHeight)
					{

						jQuerycfs.trigger(cf_e('finish', conf));
						if (opts.auto.pauseOnResize && !crsl.isPaused)
						{
							jQuerycfs.trigger(cf_e('play', conf));
						}

						sz_resetMargin(jQuerycfs.children(), opts);

						jQuerycfs.trigger(cf_e('updateSizes', conf));

						_windowWidth = nw;
						_windowHeight = nh;
					}
				});
			}
		};	//	/bind_buttons


		jQuerycfs._cfs_unbind_buttons = function() {
			var ns1 = cf_e('', conf),
				ns2 = cf_e('', conf, false);
				ns3 = cf_e('', conf, false, true, true);

			jQuery(document).unbind(ns3);
			jQuery(window).unbind(ns3);
			jQuerywrp.unbind(ns2);

			if (opts.auto.button)
			{
				opts.auto.button.unbind(ns2);
			}
			if (opts.prev.button)
			{
				opts.prev.button.unbind(ns2);
			}
			if (opts.next.button)
			{
				opts.next.button.unbind(ns2);
			}
			if (opts.pagination.container)
			{
				opts.pagination.container.unbind(ns2);
				if (opts.pagination.anchorBuilder)
				{
					opts.pagination.container.children().remove();
				}
			}
			if (crsl.swipe)
			{
				jQuerycfs.swipe('destroy');
				jQuerywrp.css('cursor', 'default');
				crsl.swipe = false;
			}
			if (crsl.mousewheel)
			{
				crsl.mousewheel = false;
			}

			nv_showNavi(opts, 'hide', conf);
			nv_enableNavi(opts, 'removeClass', conf);

		};	//	/unbind_buttons



		//	START

		if (is_boolean(configs))
		{
			configs = {
				'debug': configs
			};
		}

		//	set vars
		var crsl = {
				'direction'		: 'next',
				'isPaused'		: true,
				'isScrolling'	: false,
				'isStopped'		: false,
				'mousewheel'	: false,
				'swipe'			: false
			},
			itms = {
				'total'			: jQuerycfs.children().length,
				'first'			: 0
			},
			tmrs = {
				'auto'			: null,
				'progress'		: null,
				'startTime'		: getTime(),
				'timePassed'	: 0
			},
			scrl = {
				'isStopped'		: false,
				'duration'		: 0,
				'startTime'		: 0,
				'easing'		: '',
				'anims'			: []
			},
			clbk = {
				'onBefore'		: [],
				'onAfter'		: []
			},
			queu = [],
			conf = jQuery.extend(true, {}, jQuery.fn.carouFredSel.configs, configs),
			opts = {},
			opts_orig = jQuery.extend(true, {}, options), 
			jQuerywrp = jQuerycfs.wrap('<'+conf.wrapper.element+' class="'+conf.wrapper.classname+'" />').parent();


		conf.selector		= jQuerycfs.selector;
		conf.serialNumber	= jQuery.fn.carouFredSel.serialNumber++;


		//	create carousel
		jQuerycfs._cfs_init(opts_orig, true, starting_position);
		jQuerycfs._cfs_build();
		jQuerycfs._cfs_bind_events();
		jQuerycfs._cfs_bind_buttons();

		//	find item to start
		if (is_array(opts.items.start))
		{
			var start_arr = opts.items.start;
		}
		else
		{
			var start_arr = [];
			if (opts.items.start != 0)
			{
				start_arr.push(opts.items.start);
			}
		}
		if (opts.cookie)
		{
			start_arr.unshift(parseInt(cf_getCookie(opts.cookie), 10));
		}

		if (start_arr.length > 0)
		{
			for (var a = 0, l = start_arr.length; a < l; a++)
			{
				var s = start_arr[a];
				if (s == 0)
				{
					continue;
				}
				if (s === true)
				{
					s = window.location.hash;
					if (s.length < 1)
					{
						continue;
					}
				}
				else if (s === 'random')
				{
					s = Math.floor(Math.random()*itms.total);
				}
				if (jQuerycfs.triggerHandler(cf_e('slideTo', conf), [s, 0, true, { fx: 'none' }]))
				{
					break;
				}
			}
		}
		var siz = sz_setSizes(jQuerycfs, opts),
			itm = gi_getCurrentItems(jQuerycfs.children(), opts);

		if (opts.onCreate)
		{
			opts.onCreate.call(jQuerytt0, {
				'width': siz.width,
				'height': siz.height,
				'items': itm
			});
		}

		jQuerycfs.trigger(cf_e('updatePageStatus', conf), [true, siz]);
		jQuerycfs.trigger(cf_e('linkAnchors', conf));

		if (conf.debug)
		{
			jQuerycfs.trigger(cf_e('debug', conf));
		}

		return jQuerycfs;
	};



	//	GLOBAL PUBLIC

	jQuery.fn.carouFredSel.serialNumber = 1;
	jQuery.fn.carouFredSel.defaults = {
		'synchronise'	: false,
		'infinite'		: true,
		'circular'		: true,
		'responsive'	: false,
		'direction'		: 'left',
		'items'			: {
			'start'			: 0
		},
		'scroll'		: {
			'easing'		: 'swing',
			'duration'		: 500,
			'pauseOnHover'	: false,
			'event'			: 'click',
			'queue'			: false
		}
	};
	jQuery.fn.carouFredSel.configs = {
		'debug'			: false,
		'events'		: {
			'prefix'		: '',
			'namespace'		: 'cfs'
		},
		'wrapper'		: {
			'element'		: 'div',
			'classname'		: 'caroufredsel_wrapper'
		},
		'classnames'	: {}
	};
	jQuery.fn.carouFredSel.pageAnchorBuilder = function(nr) {
		return '<a href="#"><span>'+nr+'</span></a>';
	};
	jQuery.fn.carouFredSel.progressbarUpdater = function(perc) {
		jQuery(this).css('width', perc+'%');
	};

	jQuery.fn.carouFredSel.cookie = {
		get: function(n) {
			n += '=';
			var ca = document.cookie.split(';');
			for (var a = 0, l = ca.length; a < l; a++)
			{
				var c = ca[a];
				while (c.charAt(0) == ' ')
				{
					c = c.slice(1);
				}
				if (c.indexOf(n) == 0)
				{
					return c.slice(n.length);
				}
			}
			return 0;
		},
		set: function(n, v, d) {
			var e = "";
			if (d)
			{
				var date = new Date();
				date.setTime(date.getTime() + (d * 24 * 60 * 60 * 1000));
				e = "; expires=" + date.toGMTString();
			}
			document.cookie = n + '=' + v + e + '; path=/';
		},
		remove: function(n) {
			jQuery.fn.carouFredSel.cookie.set(n, "", -1);
		}
	};


	//	GLOBAL PRIVATE

	//	scrolling functions
	function sc_setScroll(d, e) {
		return {
			anims: [],
			duration: d,
			orgDuration: d,
			easing: e,
			startTime: getTime()
		};
	}
	function sc_startScroll(s) {

		if (is_object(s.pre))
		{
			sc_startScroll(s.pre);
		}
		for (var a = 0, l = s.anims.length; a < l; a++)
		{
			var b = s.anims[a];
			if (!b)
			{
				continue;
			}
			if (b[3])
			{
				b[0].stop();
			}
			b[0].animate(b[1], {
				complete: b[2],
				duration: s.duration,
				easing: s.easing
			});
		}
		if (is_object(s.post))
		{
			sc_startScroll(s.post);
		}
	}
	function sc_stopScroll(s, finish) {
		if (!is_boolean(finish))
		{
			finish = true;
		}
		if (is_object(s.pre))
		{
			sc_stopScroll(s.pre, finish);
		}
		for (var a = 0, l = s.anims.length; a < l; a++)
		{
			var b = s.anims[a];
			b[0].stop(true);
			if (finish)
			{
				b[0].css(b[1]);
				if (is_function(b[2]))
				{
					b[2]();
				}
			}
		}
		if (is_object(s.post))
		{
			sc_stopScroll(s.post, finish);
		}
	}
	function sc_afterScroll( jQueryc, jQueryc2, o ) {
		if (jQueryc2)
		{
			jQueryc2.remove();
		}

		switch(o.fx) {
			case 'fade':
			case 'crossfade':
			case 'cover-fade':
			case 'uncover-fade':
				jQueryc.css('filter', '');
				break;
		}
	}
	function sc_fireCallbacks(jQueryt, o, b, a, c) {
		if (o[b])
		{
			o[b].call(jQueryt, a);
		}
		if (c[b].length)
		{
			for (var i = 0, l = c[b].length; i < l; i++)
			{
				c[b][i].call(jQueryt, a);
			}
		}
		return [];
	}
	function sc_fireQueue(jQueryc, q, c) {

		if (q.length)
		{
			jQueryc.trigger(cf_e(q[0][0], c), q[0][1]);
			q.shift();
		}
		return q;
	}
	function sc_hideHiddenItems(hiddenitems) {
		hiddenitems.each(function() {
			var hi = jQuery(this);
			hi.data('_cfs_isHidden', hi.is(':hidden')).hide();
		});
	}
	function sc_showHiddenItems(hiddenitems) {
		if (hiddenitems)
		{
			hiddenitems.each(function() {
				var hi = jQuery(this);
				if (!hi.data('_cfs_isHidden'))
				{
					hi.show();
				}
			});
		}
	}
	function sc_clearTimers(t) {
		if (t.auto)
		{
			clearTimeout(t.auto);
		}
		if (t.progress)
		{
			clearInterval(t.progress);
		}
		return t;
	}
	function sc_mapCallbackArguments(i_old, i_skp, i_new, s_itm, s_dir, s_dur, w_siz) {
		return {
			'width': w_siz.width,
			'height': w_siz.height,
			'items': {
				'old': i_old,
				'skipped': i_skp,
				'visible': i_new,

				//	DEPRECATED
				'new': i_new
				//	/DEPRECATED
			},
			'scroll': {
				'items': s_itm,
				'direction': s_dir,
				'duration': s_dur
			}
		};
	}
	function sc_getDuration( sO, o, nI, siz ) {
		var dur = sO.duration;
		if (sO.fx == 'none')
		{
			return 0;
		}
		if (dur == 'auto')
		{
			dur = o.scroll.duration / o.scroll.items * nI;
		}
		else if (dur < 10)
		{
			dur = siz / dur;
		}
		if (dur < 1)
		{
			return 0;
		}
		if (sO.fx == 'fade')
		{
			dur = dur / 2;
		}
		return Math.round(dur);
	}

	//	navigation functions
	function nv_showNavi(o, t, c) {
		var minimum = (is_number(o.items.minimum)) ? o.items.minimum : o.items.visible + 1;
		if (t == 'show' || t == 'hide')
		{
			var f = t;
		}
		else if (minimum > t)
		{
			debug(c, 'Not enough items ('+t+' total, '+minimum+' needed): Hiding navigation.');
			var f = 'hide';
		}
		else
		{
			var f = 'show';
		}
		var s = (f == 'show') ? 'removeClass' : 'addClass',
			h = cf_c('hidden', c);

		if (o.auto.button)
		{
			o.auto.button[f]()[s](h);
		}
		if (o.prev.button)
		{
			o.prev.button[f]()[s](h);
		}
		if (o.next.button)
		{
			o.next.button[f]()[s](h);
		}
		if (o.pagination.container)
		{
			o.pagination.container[f]()[s](h);
		}
	}
	function nv_enableNavi(o, f, c) {
		if (o.circular || o.infinite) return;
		var fx = (f == 'removeClass' || f == 'addClass') ? f : false,
			di = cf_c('disabled', c);

		if (o.auto.button && fx)
		{
			o.auto.button[fx](di);
		}
		if (o.prev.button)
		{
			var fn = fx || (f == 0) ? 'addClass' : 'removeClass';
			o.prev.button[fn](di);
		}
		if (o.next.button)
		{
			var fn = fx || (f == o.items.visible) ? 'addClass' : 'removeClass';
			o.next.button[fn](di);
		}
	}

	//	get object functions
	function go_getObject(jQuerytt, obj) {
		if (is_function(obj))
		{
			obj = obj.call(jQuerytt);
		}
		else if (is_undefined(obj))
		{
			obj = {};
		}
		return obj;
	}
	function go_getItemsObject(jQuerytt, obj) {
		obj = go_getObject(jQuerytt, obj);
		if (is_number(obj))
		{
			obj	= {
				'visible': obj
			};
		}
		else if (obj == 'variable')
		{
			obj = {
				'visible': obj,
				'width': obj, 
				'height': obj
			};
		}
		else if (!is_object(obj))
		{
			obj = {};
		}
		return obj;
	}
	function go_getScrollObject(jQuerytt, obj) {
		obj = go_getObject(jQuerytt, obj);
		if (is_number(obj))
		{
			if (obj <= 50)
			{
				obj = {
					'items': obj
				};
			}
			else
			{
				obj = {
					'duration': obj
				};
			}
		}
		else if (is_string(obj))
		{
			obj = {
				'easing': obj
			};
		}
		else if (!is_object(obj))
		{
			obj = {};
		}
		return obj;
	}
	function go_getNaviObject(jQuerytt, obj) {
		obj = go_getObject(jQuerytt, obj);
		if (is_string(obj))
		{
			var temp = cf_getKeyCode(obj);
			if (temp == -1)
			{
				obj = jQuery(obj);
			}
			else
			{
				obj = temp;
			}
		}
		return obj;
	}

	function go_getAutoObject(jQuerytt, obj) {
		obj = go_getNaviObject(jQuerytt, obj);
		if (is_jquery(obj))
		{
			obj = {
				'button': obj
			};
		}
		else if (is_boolean(obj))
		{
			obj = {
				'play': obj
			};
		}
		else if (is_number(obj))
		{
			obj = {
				'timeoutDuration': obj
			};
		}
		if (obj.progress)
		{
			if (is_string(obj.progress) || is_jquery(obj.progress))
			{
				obj.progress = {
					'bar': obj.progress
				};
			}
		}
		return obj;
	}
	function go_complementAutoObject(jQuerytt, obj) {
		if (is_function(obj.button))
		{
			obj.button = obj.button.call(jQuerytt);
		}
		if (is_string(obj.button))
		{
			obj.button = jQuery(obj.button);
		}
		if (!is_boolean(obj.play))
		{
			obj.play = true;
		}
		if (!is_number(obj.delay))
		{
			obj.delay = 0;
		}
		if (is_undefined(obj.pauseOnEvent))
		{
			obj.pauseOnEvent = true;
		}
		if (!is_boolean(obj.pauseOnResize))
		{
			obj.pauseOnResize = true;
		}
		if (!is_number(obj.timeoutDuration))
		{
			obj.timeoutDuration = (obj.duration < 10)
				? 2500
				: obj.duration * 5;
		}
		if (obj.progress)
		{
			if (is_function(obj.progress.bar))
			{
				obj.progress.bar = obj.progress.bar.call(jQuerytt);
			}
			if (is_string(obj.progress.bar))
			{
				obj.progress.bar = jQuery(obj.progress.bar);
			}
			if (obj.progress.bar)
			{
				if (!is_function(obj.progress.updater))
				{
					obj.progress.updater = jQuery.fn.carouFredSel.progressbarUpdater;
				}
				if (!is_number(obj.progress.interval))
				{
					obj.progress.interval = 50;
				}
			}
			else
			{
				obj.progress = false;
			}
		}
		return obj;
	}

	function go_getPrevNextObject(jQuerytt, obj) {
		obj = go_getNaviObject(jQuerytt, obj);
		if (is_jquery(obj))
		{
			obj = {
				'button': obj
			};
		}
		else if (is_number(obj))
		{
			obj = {
				'key': obj
			};
		}
		return obj;
	}
	function go_complementPrevNextObject(jQuerytt, obj) {
		if (is_function(obj.button))
		{
			obj.button = obj.button.call(jQuerytt);
		}
		if (is_string(obj.button))
		{
			obj.button = jQuery(obj.button);
		}
		if (is_string(obj.key))
		{
			obj.key = cf_getKeyCode(obj.key);
		}
		return obj;
	}

	function go_getPaginationObject(jQuerytt, obj) {
		obj = go_getNaviObject(jQuerytt, obj);
		if (is_jquery(obj))
		{
			obj = {
				'container': obj
			};
		}
		else if (is_boolean(obj))
		{
			obj = {
				'keys': obj
			};
		}
		return obj;
	}
	function go_complementPaginationObject(jQuerytt, obj) {
		if (is_function(obj.container))
		{
			obj.container = obj.container.call(jQuerytt);
		}
		if (is_string(obj.container))
		{
			obj.container = jQuery(obj.container);
		}
		if (!is_number(obj.items))
		{
			obj.items = false;
		}
		if (!is_boolean(obj.keys))
		{
			obj.keys = false;
		}
		if (!is_function(obj.anchorBuilder) && !is_false(obj.anchorBuilder))
		{
			obj.anchorBuilder = jQuery.fn.carouFredSel.pageAnchorBuilder;
		}
		if (!is_number(obj.deviation))
		{
			obj.deviation = 0;
		}
		return obj;
	}

	function go_getSwipeObject(jQuerytt, obj) {
		if (is_function(obj))
		{
			obj = obj.call(jQuerytt);
		}
		if (is_undefined(obj))
		{
			obj = {
				'onTouch': false
			};
		}
		if (is_true(obj))
		{
			obj = {
				'onTouch': obj
			};
		}
		else if (is_number(obj))
		{
			obj = {
				'items': obj
			};
		}
		return obj;
	}
	function go_complementSwipeObject(jQuerytt, obj) {
		if (!is_boolean(obj.onTouch))
		{
			obj.onTouch = true;
		}
		if (!is_boolean(obj.onMouse))
		{
			obj.onMouse = false;
		}
		if (!is_object(obj.options))
		{
			obj.options = {};
		}
		if (!is_boolean(obj.options.triggerOnTouchEnd))
		{
			obj.options.triggerOnTouchEnd = false;
		}
		return obj;
	}
	function go_getMousewheelObject(jQuerytt, obj) {
		if (is_function(obj))
		{
			obj = obj.call(jQuerytt);
		}
		if (is_true(obj))
		{
			obj = {};
		}
		else if (is_number(obj))
		{
			obj = {
				'items': obj
			};
		}
		else if (is_undefined(obj))
		{
			obj = false;
		}
		return obj;
	}
	function go_complementMousewheelObject(jQuerytt, obj) {
		return obj;
	}

	//	get number functions
	function gn_getItemIndex(num, dev, org, items, jQuerycfs) {
		if (is_string(num))
		{
			num = jQuery(num, jQuerycfs);
		}

		if (is_object(num))
		{
			num = jQuery(num, jQuerycfs);
		}
		if (is_jquery(num))
		{
			num = jQuerycfs.children().index(num);
			if (!is_boolean(org))
			{
				org = false;
			}
		}
		else
		{
			if (!is_boolean(org))
			{
				org = true;
			}
		}
		if (!is_number(num))
		{
			num = 0;
		}
		if (!is_number(dev))
		{
			dev = 0;
		}

		if (org)
		{
			num += items.first;
		}
		num += dev;
		if (items.total > 0)
		{
			while (num >= items.total)
			{
				num -= items.total;
			}
			while (num < 0)
			{
				num += items.total;
			}
		}
		return num;
	}

	//	items prev
	function gn_getVisibleItemsPrev(i, o, s) {
		var t = 0,
			x = 0;

		for (var a = s; a >= 0; a--)
		{
			var j = i.eq(a);
			t += (j.is(':visible')) ? j[o.d['outerWidth']](true) : 0;
			if (t > o.maxDimension)
			{
				return x;
			}
			if (a == 0)
			{
				a = i.length;
			}
			x++;
		}
	}
	function gn_getVisibleItemsPrevFilter(i, o, s) {
		return gn_getItemsPrevFilter(i, o.items.filter, o.items.visibleConf.org, s);
	}
	function gn_getScrollItemsPrevFilter(i, o, s, m) {
		return gn_getItemsPrevFilter(i, o.items.filter, m, s);
	}
	function gn_getItemsPrevFilter(i, f, m, s) {
		var t = 0,
			x = 0;

		for (var a = s, l = i.length; a >= 0; a--)
		{
			x++;
			if (x == l)
			{
				return x;
			}

			var j = i.eq(a);
			if (j.is(f))
			{
				t++;
				if (t == m)
				{
					return x;
				}
			}
			if (a == 0)
			{
				a = l;
			}
		}
	}

	function gn_getVisibleOrg(jQueryc, o) {
		return o.items.visibleConf.org || jQueryc.children().slice(0, o.items.visible).filter(o.items.filter).length;
	}

	//	items next
	function gn_getVisibleItemsNext(i, o, s) {
		var t = 0,
			x = 0;

		for (var a = s, l = i.length-1; a <= l; a++)
		{
			var j = i.eq(a);

			t += (j.is(':visible')) ? j[o.d['outerWidth']](true) : 0;
			if (t > o.maxDimension)
			{
				return x;
			}

			x++;
			if (x == l+1)
			{
				return x;
			}
			if (a == l)
			{
				a = -1;
			}
		}
	}
	function gn_getVisibleItemsNextTestCircular(i, o, s, l) {
		var v = gn_getVisibleItemsNext(i, o, s);
		if (!o.circular)
		{
			if (s + v > l)
			{
				v = l - s;
			}
		}
		return v;
	}
	function gn_getVisibleItemsNextFilter(i, o, s) {
		return gn_getItemsNextFilter(i, o.items.filter, o.items.visibleConf.org, s, o.circular);
	}
	function gn_getScrollItemsNextFilter(i, o, s, m) {
		return gn_getItemsNextFilter(i, o.items.filter, m+1, s, o.circular) - 1;
	}
	function gn_getItemsNextFilter(i, f, m, s, c) {
		var t = 0,
			x = 0;

		for (var a = s, l = i.length-1; a <= l; a++)
		{
			x++;
			if (x >= l)
			{
				return x;
			}

			var j = i.eq(a);
			if (j.is(f))
			{
				t++;
				if (t == m)
				{
					return x;
				}
			}
			if (a == l)
			{
				a = -1;
			}
		}
	}

	//	get items functions
	function gi_getCurrentItems(i, o) {
		return i.slice(0, o.items.visible);
	}
	function gi_getOldItemsPrev(i, o, n) {
		return i.slice(n, o.items.visibleConf.old+n);
	}
	function gi_getNewItemsPrev(i, o) {
		return i.slice(0, o.items.visible);
	}
	function gi_getOldItemsNext(i, o) {
		return i.slice(0, o.items.visibleConf.old);
	}
	function gi_getNewItemsNext(i, o, n) {
		return i.slice(n, o.items.visible+n);
	}

	//	sizes functions
	function sz_storeMargin(i, o, d) {
		if (o.usePadding)
		{
			if (!is_string(d))
			{
				d = '_cfs_origCssMargin';
			}
			i.each(function() {
				var j = jQuery(this),
					m = parseInt(j.css(o.d['marginRight']), 10);
				if (!is_number(m)) 
				{
					m = 0;
				}
				j.data(d, m);
			});
		}
	}
	function sz_resetMargin(i, o, m) {
		if (o.usePadding)
		{
			var x = (is_boolean(m)) ? m : false;
			if (!is_number(m))
			{
				m = 0;
			}
			sz_storeMargin(i, o, '_cfs_tempCssMargin');
			i.each(function() {
				var j = jQuery(this);
				j.css(o.d['marginRight'], ((x) ? j.data('_cfs_tempCssMargin') : m + j.data('_cfs_origCssMargin')));
			});
		}
	}
	function sz_storeSizes(i, o) {
		if (o.responsive)
		{
			i.each(function() {
				var j = jQuery(this),
					s = in_mapCss(j, ['width', 'height']);
				j.data('_cfs_origCssSizes', s);
			});
		}
	}
	function sz_setResponsiveSizes(o, all) {
		var visb = o.items.visible,
			newS = o.items[o.d['width']],
			seco = o[o.d['height']],
			secp = is_percentage(seco);

		all.each(function() {
			var jQueryt = jQuery(this),
				nw = newS - ms_getPaddingBorderMargin(jQueryt, o, 'Width');

			jQueryt[o.d['width']](nw);
			if (secp)
			{
				jQueryt[o.d['height']](ms_getPercentage(nw, seco));
			}
		});
	}
	function sz_setSizes(jQueryc, o) {
		var jQueryw = jQueryc.parent(),
			jQueryi = jQueryc.children(),
			jQueryv = gi_getCurrentItems(jQueryi, o),
			sz = cf_mapWrapperSizes(ms_getSizes(jQueryv, o, true), o, false);

		jQueryw.css(sz);

		if (o.usePadding)
		{
			var p = o.padding,
				r = p[o.d[1]];

			if (o.align && r < 0)
			{
				r = 0;
			}
			var jQueryl = jQueryv.last();
			jQueryl.css(o.d['marginRight'], jQueryl.data('_cfs_origCssMargin') + r);
			jQueryc.css(o.d['top'], p[o.d[0]]);
			jQueryc.css(o.d['left'], p[o.d[3]]);
		}

		jQueryc.css(o.d['width'], sz[o.d['width']]+(ms_getTotalSize(jQueryi, o, 'width')*2));
		jQueryc.css(o.d['height'], ms_getLargestSize(jQueryi, o, 'height'));
		return sz;
	}

	//	measuring functions
	function ms_getSizes(i, o, wrapper) {
		return [ms_getTotalSize(i, o, 'width', wrapper), ms_getLargestSize(i, o, 'height', wrapper)];
	}
	function ms_getLargestSize(i, o, dim, wrapper) {
		if (!is_boolean(wrapper))
		{
			wrapper = false;
		}
		if (is_number(o[o.d[dim]]) && wrapper)
		{
			return o[o.d[dim]];
		}
		if (is_number(o.items[o.d[dim]]))
		{
			return o.items[o.d[dim]];
		}
		dim = (dim.toLowerCase().indexOf('width') > -1) ? 'outerWidth' : 'outerHeight';
		return ms_getTrueLargestSize(i, o, dim);
	}
	function ms_getTrueLargestSize(i, o, dim) {
		var s = 0;

		for (var a = 0, l = i.length; a < l; a++)
		{
			var j = i.eq(a);

			var m = (j.is(':visible')) ? j[o.d[dim]](true) : 0;
			if (s < m)
			{
				s = m;
			}
		}
		return s;
	}

	function ms_getTotalSize(i, o, dim, wrapper) {
		if (!is_boolean(wrapper))
		{
			wrapper = false;
		}
		if (is_number(o[o.d[dim]]) && wrapper)
		{
			return o[o.d[dim]];
		}
		if (is_number(o.items[o.d[dim]]))
		{
			return o.items[o.d[dim]] * i.length;
		}

		var d = (dim.toLowerCase().indexOf('width') > -1) ? 'outerWidth' : 'outerHeight',
			s = 0;

		for (var a = 0, l = i.length; a < l; a++)
		{
			var j = i.eq(a);
			s += (j.is(':visible')) ? j[o.d[d]](true) : 0;
		}
		return s;
	}
	function ms_getParentSize(jQueryw, o, d) {
		var isVisible = jQueryw.is(':visible');
		if (isVisible)
		{
			jQueryw.hide();
		}
		var s = jQueryw.parent()[o.d[d]]();
		if (isVisible)
		{
			jQueryw.show();
		}
		return s;
	}
	function ms_getMaxDimension(o, a) {
		return (is_number(o[o.d['width']])) ? o[o.d['width']] : a;
	}
	function ms_hasVariableSizes(i, o, dim) {
		var s = false,
			v = false;

		for (var a = 0, l = i.length; a < l; a++)
		{
			var j = i.eq(a);

			var c = (j.is(':visible')) ? j[o.d[dim]](true) : 0;
			if (s === false)
			{
				s = c;
			}
			else if (s != c)
			{
				v = true;
			}
			if (s == 0)
			{
				v = true;
			}
		}
		return v;
	}
	function ms_getPaddingBorderMargin(i, o, d) {
		return i[o.d['outer'+d]](true) - i[o.d[d.toLowerCase()]]();
	}
	function ms_getPercentage(s, o) {
		if (is_percentage(o))
		{
			o = parseInt( o.slice(0, -1), 10 );
			if (!is_number(o))
			{
				return s;
			}
			s *= o/100;
		}
		return s;
	}

	//	config functions
	function cf_e(n, c, pf, ns, rd) {
		if (!is_boolean(pf))
		{
			pf = true;
		}
		if (!is_boolean(ns))
		{
			ns = true;
		}
		if (!is_boolean(rd))
		{
			rd = false;
		}

		if (pf)
		{
			n = c.events.prefix + n;
		}
		if (ns)
		{
			n = n +'.'+ c.events.namespace;
		}
		if (ns && rd)
		{
			n += c.serialNumber;
		}

		return n;
	}
	function cf_c(n, c) {
		return (is_string(c.classnames[n])) ? c.classnames[n] : n;
	}
	function cf_mapWrapperSizes(ws, o, p) {
		if (!is_boolean(p))
		{
			p = true;
		}
		var pad = (o.usePadding && p) ? o.padding : [0, 0, 0, 0];
		var wra = {};

		wra[o.d['width']] = ws[0] + pad[1] + pad[3];
		wra[o.d['height']] = ws[1] + pad[0] + pad[2];

		return wra;
	}
	function cf_sortParams(vals, typs) {
		var arr = [];
		for (var a = 0, l1 = vals.length; a < l1; a++)
		{
			for (var b = 0, l2 = typs.length; b < l2; b++)
			{
				if (typs[b].indexOf(typeof vals[a]) > -1 && is_undefined(arr[b]))
				{
					arr[b] = vals[a];
					break;
				}
			}
		}
		return arr;
	}
	function cf_getPadding(p) {
		if (is_undefined(p))
		{
			return [0, 0, 0, 0];
		}
		if (is_number(p))
		{
			return [p, p, p, p];
		}
		if (is_string(p))
		{
			p = p.split('px').join('').split('em').join('').split(' ');
		}

		if (!is_array(p))
		{
			return [0, 0, 0, 0];
		}
		for (var i = 0; i < 4; i++)
		{
			p[i] = parseInt(p[i], 10);
		}
		switch (p.length)
		{
			case 0:
				return [0, 0, 0, 0];
			case 1:
				return [p[0], p[0], p[0], p[0]];
			case 2:
				return [p[0], p[1], p[0], p[1]];
			case 3:
				return [p[0], p[1], p[2], p[1]];
			default:
				return [p[0], p[1], p[2], p[3]];
		}
	}
	function cf_getAlignPadding(itm, o) {
		var x = (is_number(o[o.d['width']])) ? Math.ceil(o[o.d['width']] - ms_getTotalSize(itm, o, 'width')) : 0;
		switch (o.align)
		{
			case 'left': 
				return [0, x];
			case 'right':
				return [x, 0];
			case 'center':
			default:
				return [Math.ceil(x/2), Math.floor(x/2)];
		}
	}
	function cf_getDimensions(o) {
		var dm = [
				['width'	, 'innerWidth'	, 'outerWidth'	, 'height'	, 'innerHeight'	, 'outerHeight'	, 'left', 'top'	, 'marginRight'	, 0, 1, 2, 3],
				['height'	, 'innerHeight'	, 'outerHeight'	, 'width'	, 'innerWidth'	, 'outerWidth'	, 'top'	, 'left', 'marginBottom', 3, 2, 1, 0]
			];

		var dl = dm[0].length,
			dx = (o.direction == 'right' || o.direction == 'left') ? 0 : 1;

		var dimensions = {};
		for (var d = 0; d < dl; d++)
		{
			dimensions[dm[0][d]] = dm[dx][d];
		}
		return dimensions;
	}
	function cf_getAdjust(x, o, a, jQueryt) {
		var v = x;
		if (is_function(a))
		{
			v = a.call(jQueryt, v);

		}
		else if (is_string(a))
		{
			var p = a.split('+'),
				m = a.split('-');

			if (m.length > p.length)
			{
				var neg = true,
					sta = m[0],
					adj = m[1];
			}
			else
			{
				var neg = false,
					sta = p[0],
					adj = p[1];
			}

			switch(sta)
			{
				case 'even':
					v = (x % 2 == 1) ? x-1 : x;
					break;
				case 'odd':
					v = (x % 2 == 0) ? x-1 : x;
					break;
				default:
					v = x;
					break;
			}
			adj = parseInt(adj, 10);
			if (is_number(adj))
			{
				if (neg)
				{
					adj = -adj;
				}
				v += adj;
			}
		}
		if (!is_number(v) || v < 1)
		{
			v = 1;
		}
		return v;
	}
	function cf_getItemsAdjust(x, o, a, jQueryt) {
		return cf_getItemAdjustMinMax(cf_getAdjust(x, o, a, jQueryt), o.items.visibleConf);
	}
	function cf_getItemAdjustMinMax(v, i) {
		if (is_number(i.min) && v < i.min)
		{
			v = i.min;
		}
		if (is_number(i.max) && v > i.max)
		{
			v = i.max;
		}
		if (v < 1)
		{
			v = 1;
		}
		return v;
	}
	function cf_getSynchArr(s) {
		if (!is_array(s))
		{
			s = [[s]];
		}
		if (!is_array(s[0]))
		{
			s = [s];
		}
		for (var j = 0, l = s.length; j < l; j++)
		{
			if (is_string(s[j][0]))
			{
				s[j][0] = jQuery(s[j][0]);
			}
			if (!is_boolean(s[j][1]))
			{
				s[j][1] = true;
			}
			if (!is_boolean(s[j][2]))
			{
				s[j][2] = true;
			}
			if (!is_number(s[j][3]))
			{
				s[j][3] = 0;
			}
		}
		return s;
	}
	function cf_getKeyCode(k) {
		if (k == 'right')
		{
			return 39;
		}
		if (k == 'left')
		{
			return 37;
		}
		if (k == 'up')
		{
			return 38;
		}
		if (k == 'down')
		{
			return 40;
		}
		return -1;
	}
	function cf_setCookie(n, jQueryc, c) {
		if (n)
		{
			var v = jQueryc.triggerHandler(cf_e('currentPosition', c));
			jQuery.fn.carouFredSel.cookie.set(n, v);
		}
	}
	function cf_getCookie(n) {
		var c = jQuery.fn.carouFredSel.cookie.get(n);
		return (c == '') ? 0 : c;
	}

	//	init function
	function in_mapCss(jQueryelem, props) {
		var css = {}, prop;
		for (var p = 0, l = props.length; p < l; p++)
		{
			prop = props[p];
			css[prop] = jQueryelem.css(prop);
		}
		return css;
	}
	function in_complementItems(obj, opt, itm, sta) {
		if (!is_object(obj.visibleConf))
		{
			obj.visibleConf = {};
		}
		if (!is_object(obj.sizesConf))
		{
			obj.sizesConf = {};
		}

		if (obj.start == 0 && is_number(sta))
		{
			obj.start = sta;
		}

		//	visible items
		if (is_object(obj.visible))
		{
			obj.visibleConf.min = obj.visible.min;
			obj.visibleConf.max = obj.visible.max;
			obj.visible = false;
		}
		else if (is_string(obj.visible))
		{
			//	variable visible items
			if (obj.visible == 'variable')
			{
				obj.visibleConf.variable = true;
			}
			//	adjust string visible items
			else
			{
				obj.visibleConf.adjust = obj.visible;
			}
			obj.visible = false;
		}
		else if (is_function(obj.visible))
		{
			obj.visibleConf.adjust = obj.visible;
			obj.visible = false;
		}

		//	set items filter
		if (!is_string(obj.filter))
		{
			obj.filter = (itm.filter(':hidden').length > 0) ? ':visible' : '*';
		}

		//	primary item-size not set
		if (!obj[opt.d['width']])
		{
			//	responsive carousel -> set to largest
			if (opt.responsive)
			{
				debug(true, 'Set a '+opt.d['width']+' for the items!');
				obj[opt.d['width']] = ms_getTrueLargestSize(itm, opt, 'outerWidth');
			}
			//	 non-responsive -> measure it or set to "variable"
			else
			{
				obj[opt.d['width']] = (ms_hasVariableSizes(itm, opt, 'outerWidth')) 
					? 'variable' 
					: itm[opt.d['outerWidth']](true);
			}
		}

		//	secondary item-size not set -> measure it or set to "variable"
		if (!obj[opt.d['height']])
		{
			obj[opt.d['height']] = (ms_hasVariableSizes(itm, opt, 'outerHeight')) 
				? 'variable' 
				: itm[opt.d['outerHeight']](true);
		}

		obj.sizesConf.width = obj.width;
		obj.sizesConf.height = obj.height;
		return obj;
	}
	function in_complementVisibleItems(opt, avl) {
		//	primary item-size variable -> set visible items variable
		if (opt.items[opt.d['width']] == 'variable')
		{
			opt.items.visibleConf.variable = true;
		}
		if (!opt.items.visibleConf.variable) {
			//	primary size is number -> calculate visible-items
			if (is_number(opt[opt.d['width']]))
			{
				opt.items.visible = Math.floor(opt[opt.d['width']] / opt.items[opt.d['width']]);
			}
			//	measure and calculate primary size and visible-items
			else
			{
				opt.items.visible = Math.floor(avl / opt.items[opt.d['width']]);
				opt[opt.d['width']] = opt.items.visible * opt.items[opt.d['width']];
				if (!opt.items.visibleConf.adjust)
				{
					opt.align = false;
				}
			}
			if (opt.items.visible == 'Infinity' || opt.items.visible < 1)
			{
				debug(true, 'Not a valid number of visible items: Set to "variable".');
				opt.items.visibleConf.variable = true;
			}
		}
		return opt;
	}
	function in_complementPrimarySize(obj, opt, all) {
		//	primary size set to auto -> measure largest item-size and set it
		if (obj == 'auto')
		{
			obj = ms_getTrueLargestSize(all, opt, 'outerWidth');
		}
		return obj;
	}
	function in_complementSecondarySize(obj, opt, all) {
		//	secondary size set to auto -> measure largest item-size and set it
		if (obj == 'auto')
		{
			obj = ms_getTrueLargestSize(all, opt, 'outerHeight');
		}
		//	secondary size not set -> set to secondary item-size
		if (!obj)
		{
			obj = opt.items[opt.d['height']];
		}
		return obj;
	}
	function in_getAlignPadding(o, all) {
		var p = cf_getAlignPadding(gi_getCurrentItems(all, o), o);
		o.padding[o.d[1]] = p[1];
		o.padding[o.d[3]] = p[0];
		return o;
	}
	function in_getResponsiveValues(o, all, avl) {

		var visb = cf_getItemAdjustMinMax(Math.ceil(o[o.d['width']] / o.items[o.d['width']]), o.items.visibleConf);
		if (visb > all.length)
		{
			visb = all.length;
		}

		var newS = Math.floor(o[o.d['width']]/visb);

		o.items.visible = visb;
		o.items[o.d['width']] = newS;
		o[o.d['width']] = visb * newS;
		return o;
	}


	//	buttons functions
	function bt_pauseOnHoverConfig(p) {
		if (is_string(p))
		{
			var i = (p.indexOf('immediate') > -1) ? true : false,
				r = (p.indexOf('resume') 	> -1) ? true : false;
		}
		else
		{
			var i = r = false;
		}
		return [i, r];
	}
	function bt_mousesheelNumber(mw) {
		return (is_number(mw)) ? mw : null
	}

	//	helper functions
	function is_null(a) {
		return (a === null);
	}
	function is_undefined(a) {
		return (is_null(a) || typeof a == 'undefined' || a === '' || a === 'undefined');
	}
	function is_array(a) {
		return (a instanceof Array);
	}
	function is_jquery(a) {
		return (a instanceof jQuery);
	}
	function is_object(a) {
		return ((a instanceof Object || typeof a == 'object') && !is_null(a) && !is_jquery(a) && !is_array(a));
	}
	function is_number(a) {
		return ((a instanceof Number || typeof a == 'number') && !isNaN(a));
	}
	function is_string(a) {
		return ((a instanceof String || typeof a == 'string') && !is_undefined(a) && !is_true(a) && !is_false(a));
	}
	function is_function(a) {
		return (a instanceof Function || typeof a == 'function');
	}
	function is_boolean(a) {
		return (a instanceof Boolean || typeof a == 'boolean' || is_true(a) || is_false(a));
	}
	function is_true(a) {
		return (a === true || a === 'true');
	}
	function is_false(a) {
		return (a === false || a === 'false');
	}
	function is_percentage(x) {
		return (is_string(x) && x.slice(-1) == '%');
	}


	function getTime() {
		return new Date().getTime();
	}

	function deprecated( o, n ) {
		debug(true, o+' is DEPRECATED, support for it will be removed. Use '+n+' instead.');
	}
	function debug(d, m) {
		if (is_object(d))
		{
			var s = ' ('+d.selector+')';
			d = d.debug;
		}
		else
		{
			var s = '';
		}
		if (!d)
		{
			return false;
		}

		if (is_string(m))
		{
			m = 'carouFredSel'+s+': ' + m;
		}
		else
		{
			m = ['carouFredSel'+s+':', m];
		}

		if (window.console && window.console.log)
		{
			window.console.log(m);
		}
		return false;
	}



	//	EASING FUNCTIONS

	jQuery.extend(jQuery.easing, {
		'quadratic': function(t) {
			var t2 = t * t;
			return t * (-t2 * t + 4 * t2 - 6 * t + 4);
		},
		'cubic': function(t) {
			return t * (4 * t * t - 9 * t + 6);
		},
		'elastic': function(t) {
			var t2 = t * t;
			return t * (33 * t2 * t2 - 106 * t2 * t + 126 * t2 - 67 * t + 15);
		}
	});


})(jQuery);