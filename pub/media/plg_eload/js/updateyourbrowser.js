
var BrowserDetect = {
    init: function () {
	this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
	this.version = this.searchVersion(navigator.userAgent)
	|| this.searchVersion(navigator.appVersion)
	|| "an unknown version";
	this.OS = this.searchString(this.dataOS) || "an unknown OS";
    },
    searchString: function (data) {
	for (var i=0;i<data.length;i++)	{
	    var dataString = data[i].string;
	    var dataProp = data[i].prop;
	    this.versionSearchString = data[i].versionSearch || data[i].identity;
	    if (dataString) {
		if (dataString.indexOf(data[i].subString) != -1)
		    return data[i].identity;
	    }
	    else if (dataProp)
		return data[i].identity;
	}
    },
    searchVersion: function (dataString) {
	var index = dataString.indexOf(this.versionSearchString);
	if (index == -1) return;
	return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
    },
    dataBrowser: [
    {
	string: navigator.userAgent,
	subString: "Chrome",
	identity: "Chrome"
    },
    {
	string: navigator.userAgent,
	subString: "OmniWeb",
	versionSearch: "OmniWeb/",
	identity: "OmniWeb"
    },
    {
	string: navigator.vendor,
	subString: "Apple",
	identity: "Safari"
    },
    {
	prop: window.opera,
	identity: "Opera"
    },
    {
	string: navigator.vendor,
	subString: "iCab",
	identity: "iCab"
    },
    {
	string: navigator.vendor,
	subString: "KDE",
	identity: "Konqueror"
    },
    {
	string: navigator.userAgent,
	subString: "Firefox",
	identity: "Firefox"
    },
    {
	string: navigator.vendor,
	subString: "Camino",
	identity: "Camino"
    },
    {		// for newer Netscapes (6+)
	string: navigator.userAgent,
	subString: "Netscape",
	identity: "Netscape"
    },
    {
	string: navigator.userAgent,
	subString: "MSIE",
	identity: "Internet Explorer",
	versionSearch: "MSIE"
    },
    {
	string: navigator.userAgent,
	subString: "Gecko",
	identity: "Mozilla",
	versionSearch: "rv"
    },
    { 		// for older Netscapes (4-)
	string: navigator.userAgent,
	subString: "Mozilla",
	identity: "Netscape",
	versionSearch: "Mozilla"
    }
    ],
    dataOS : [
    {
	string: navigator.platform,
	subString: "Win",
	identity: "Windows"
    },
    {
	string: navigator.platform,
	subString: "Mac",
	identity: "Mac"
    },
    {
	string: navigator.platform,
	subString: "Linux",
	identity: "Linux"
    }
    ]

};
BrowserDetect.init();

$(document).ready(function(){
   if ((BrowserDetect.browser == "Internet Explorer") && (BrowserDetect.version == "6" || BrowserDetect.version == "7")){
	$('body').prepend("<div id=\"asn-warning\" style=\"border-bottom: solid 1px #DFDDCB; top:0px; margin: 10px 0px; padding: 5px 0px; width: 100%; color: #4F4D3B; background: #FFFCDF; font: normal 8pt/14px 'Trebuchet MS', Arial, Helvetica; text-align: center;\">A versão do seu navegador não é compatível com alguns recursos deste site<br />Voc&ecirc; est&aacute; usando <strong>"+BrowserDetect.browser+" "+BrowserDetect.version+"</strong>, um navegador antigo e com falhas de seguran&ccedil;a. Por favor <a href=\"http://www.updateyourbrowser.net/\" style=\"color: #4F4D3B; text-decoration: underline; font: normal 8pt/14px 'Trebuchet MS', Arial, Helvetica;\" target=\"_blank\">atualize seu navegador</a>. <a href=\"javascript://\" id=\"asn-close\" style=\"color: #4F4D3B; text-decoration: underline; font: normal 8pt/14px 'Trebuchet MS', Arial, Helvetica;\">[x]</a></div>");
	$('#asn-warning').fadeIn(1000);
	$('#asn-close').click(function(){
	    $('#asn-warning').fadeOut(400, function(){
		$(this).remove();
	    });
	});
    }
});
