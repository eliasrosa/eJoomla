/**
 * Plugin para mostrar o loader
 * 
 * @author Frederico Machado <fredi at caiac dot com dot br>
 * @copyright 2009 (c) Caiac Soluções Para Internet Ltda.
 * @link http://www.caiac.com.br
 * 
 * @version 1.0.3
 * @date 05/02/2009
 */
(function($) {	
	$.fn.ajaxLoader = function(o, css, css2) {
		var op = {
			overlay: "ajaxOverlay",
			loader:  "ajaxLoader",
			texto:   "Processando..."
		};
		var cssp = { top: 0 };
		var csso = { left: 0, zIndex: 9998, backgroundColor: '#FFF', height: $(document).height()+'px', width: '100%', opacity: 0, position: 'absolute' };
		var cssl = { backgroundColor: '#F1D254', left: '50%', zIndex: 9999, textAlign: 'center', width: '90px', marginLeft: '-45px', padding: '5px', color: '#222', fontWeight: 'bold', position: 'fixed' };

		$.extend(op, o);
		$.extend(csso, cssp, css);
		$.extend(cssl, cssp, css2);

		if ($("#"+op.overlay).length > 0)
			return;

		$(this).ajaxStop(function() {
			setTimeout(function() {
				$("#"+op.loader).remove();
				$("#"+op.overlay).remove();
			}, 200);
		});

		$(this).prepend($('<div id="'+op.overlay+'"></div>').css(csso)).append($('<div id="'+op.loader+'"></div>').css(cssl).html(op.texto));

		if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
			var ver = RegExp.$1;
			if (ver == "6.0") {
	            var expression = "(ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + 'px'";
				$("#"+op.loader).css({ position: 'absolute' }).get(0).style.setExpression("top", expression);
			}
		}
	}
})(jQuery);
