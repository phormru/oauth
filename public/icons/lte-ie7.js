/* Use this script if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'Socicon\'">' + entity + '</span>' + html;
	}
	var icons = {
			'.socicon.mailru .icon' : '&#xe000;',
			'.socicon.github .icon' : '&#xe001;',
			'.socicon.slideshare .icon' : '&#xe002;',
			'.socicon.moikrug .icon' : '&#xe003;',
			'.socicon.dropbox .icon' : '&#xe004;',
			'.socicon.odnoklassniki .icon' : '&#xe005;',
			'.socicon.linkedin .icon' : '&#xe006;',
			'.socicon.myspace .icon' : '&#xe007;',
			'.socicon.livejournal .icon' : '&#xe008;',
			'.socicon.yandex .icon' : '&#xe009;',
			'.socicon.google .icon' : '&#xe00a;',
			'.socicon.vk .icon' : '&#xe00b;',
			'.socicon.twitter .icon' : '&#xe00c;',
			'.socicon.facebook .icon' : '&#xe00d;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; i < els.length; i += 1) {
		el = els[i];
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c) {
			addIcon(el, icons[c[0]]);
		}
	}
};