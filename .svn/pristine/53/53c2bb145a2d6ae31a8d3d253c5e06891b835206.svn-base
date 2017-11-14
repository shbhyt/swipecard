$(function(){
		//偵測瀏覽器版本 ，IE、EDGE、CHROME等瀏覽器
var BrowserDetect = {
    init: function () {
        this.userAgent = navigator.userAgent;
        this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
        this.version = this.searchVersion(navigator.userAgent)
            || this.searchVersion(navigator.appVersion)
            || "an unknown version";
        this.OS = this.searchString(this.dataOS) || "an unknown OS";
    },
    searchString: function (data) {
        for (var i=0;i<data.length;i++)    {
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
            subString: "Edge",
            identity: "Edge",
            icon: "_edge.png"
        },
        {
            string: navigator.userAgent,
            subString: "Chrome",
            identity: "Chrome",
            icon: "_chrome.png"
        },
        {     string: navigator.userAgent,
            subString: "OmniWeb",
            versionSearch: "OmniWeb/",
            identity: "OmniWeb",
            icon: "_omni.png"
        },
        {
            string: navigator.vendor,
            subString: "Apple",
            identity: "Safari",
            versionSearch: "Version",
            icon: "_safari.png"
            
        },
        {
            prop: window.opera,
            identity: "Opera",
            versionSearch: "Version",
            icon: "_opera.png"
        },
        {
            string: navigator.vendor,
            subString: "iCab",
            identity: "iCab",
            icon: "_icab.jpg"
        },
        {
            string: navigator.vendor,
            subString: "KDE",
            identity: "Konqueror",
            icon: "_unknown.png"
            
        },
        {
            string: navigator.userAgent,
            subString: "Firefox",
            identity: "Firefox",
            icon: "_firefox.png"
        },
        {
            string: navigator.vendor,
            subString: "Camino",
            identity: "Camino",
            icon: "_unknown.png"
        },
        {        
      // for newer Netscapes (6+)
            string: navigator.userAgent,
            subString: "Netscape",
            identity: "Netscape",
            icon: "_netscape.png"
        },
        {
            string: navigator.userAgent,
            subString: "MSIE",
            identity: "Explorer",
            versionSearch: "MSIE",
            icon: "_ie.png"
        },
        {
            string: navigator.userAgent,
            subString: "Gecko",
            identity: "Mozilla",
            versionSearch: "rv",
            icon: "_unknown.png"
        },
        { 
      // for older Netscapes (4-)
            string: navigator.userAgent,
            subString: "Mozilla",
            identity: "Netscape",
            versionSearch: "Mozilla",
            icon: "_mozilla.png"
        }
    ],
    dataOS : [
    ]

};


//使用方式
function getBrowserVer()
{
    BrowserDetect.init();
	if(BrowserDetect.browser=="Firefox" && BrowserDetect.version<40){
		alert("檢測到您使用的Firefox瀏覽器版本為:"+BrowserDetect.browser +' '+ BrowserDetect.version+"為避免加班單審核有誤，請更換為高版本Chrome瀏覽器");
	}
	
	if(BrowserDetect.browser=="IE"){
		alert("檢測到您使用的瀏覽器版本為:"+BrowserDetect.browser +' '+ BrowserDetect.version+"為避免加班單審核有誤，請更換為高版本Chrome瀏覽器");
	}
}
 getBrowserVer();
});


