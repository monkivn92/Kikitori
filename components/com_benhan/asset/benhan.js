jQuery(document).ready(function($){
	var s_head = $('#sbox-window #sbox-content iframe').contents().find('head');
	s_head.append($("<link/>", { rel: "stylesheet", href: "/components/com_benhan/asset/benhan.css", type: "text/css" }));

});