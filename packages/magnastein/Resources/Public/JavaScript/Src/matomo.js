// Matomo Tracking
var _paq = (window._paq = window._paq || []);
_paq.push(["disableCookies"]); // Ab sofort verteilt Matomo keine Kekse (Cookies) mehr
_paq.push(["enableHeartBeatTimer", 5]); // Matomo bekommt Herzrasen: Der "Herzschlag" von Matomo wird auf alle 5 Sekunden erhöht
_paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
_paq.push(["trackPageView"]);
_paq.push(["enableLinkTracking"]);

(function () {
    var u = "https://stats.simplesigns.de/";
    _paq.push(["setTrackerUrl", u + "matomo.php"]);
    _paq.push(["setSiteId", "1"]);
    var d = document,
        g = d.createElement("script"),
        s = d.getElementsByTagName("script")[0];
    g.async = true;
    g.defer = true;
    g.src = u + "matomo.js";
    s.parentNode.insertBefore(g, s);
})();
// End Matomo Tracking

// Matomo Tag Manager
  var _mtm = window._mtm = window._mtm || [];
  _mtm.push({'mtm.startTime': (new Date().getTime()), 'event': 'mtm.Start'});
  (function() {
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src='https://stats.simplesigns.de/js/container_brGKKpmz.js'; s.parentNode.insertBefore(g,s);
  })();
// End Matomo Tag Manager