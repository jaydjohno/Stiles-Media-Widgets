!(function (e) 
{
    var t = {};
    function a(n) {
        if (t[n]) return t[n].exports;
        var i = (t[n] = { i: n, l: !1, exports: {} });
        return e[n].call(i.exports, i, i.exports, a), (i.l = !0), i.exports;
    }
    (a.m = e),
        (a.c = t),
        (a.d = function (e, t, n) {
            a.o(e, t) || Object.defineProperty(e, t, { enumerable: !0, get: n });
        }),
        (a.r = function (e) {
            "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, { value: "Module" }), Object.defineProperty(e, "__esModule", { value: !0 });
        }),
        (a.t = function (e, t) {
            if ((1 & t && (e = a(e)), 8 & t)) return e;
            if (4 & t && "object" == typeof e && e && e.__esModule) return e;
            var n = Object.create(null);
            if ((a.r(n), Object.defineProperty(n, "default", { enumerable: !0, value: e }), 2 & t && "string" != typeof e))
                for (var i in e)
                    a.d(
                        n,
                        i,
                        function (t) {
                            return e[t];
                        }.bind(null, i)
                    );
            return n;
        }),
        (a.n = function (e) {
            var t =
                e && e.__esModule
                    ? function () {
                          return e.default;
                      }
                    : function () {
                          return e;
                      };
            return a.d(t, "a", t), t;
        }),
        (a.o = function (e, t) {
            return Object.prototype.hasOwnProperty.call(e, t);
        }),
        (a.p = ""),
        a((a.s = 2));
})({
    2: function (e, t) 
    {
        var a = function (e, t) {
            var a = "#" + e.find(".smw-advance-tabs").attr("id").toString();
            t(a + " .smw-tabs-nav ul li").each(function (e) {
                t(this).hasClass("active-default")
                    ? (t(a + " .smw-tabs-nav > ul li")
                          .removeClass("active")
                          .addClass("inactive"),
                      t(this).removeClass("inactive"))
                    : 0 == e && t(this).removeClass("inactive").addClass("active");
            }),
                t(a + " .smw-tabs-content div").each(function (e) {
                    t(this).hasClass("active-default") ? t(a + " .smw-tabs-content > div").removeClass("active") : 0 == e && t(this).removeClass("inactive").addClass("active");
                }),
                t(a + " .smw-tabs-nav ul li").click(function () 
                {
                    var e = t(this).index(),
                        a = t(this).closest(".smw-advance-tabs"),
                        n = t(a).children(".smw-tabs-nav").children("ul").children("li"),
                        i = t(a).children(".smw-tabs-content").children("div");
                    t(this).parent("li").addClass("active"),
                        t(n).removeClass("active active-default").addClass("inactive"),
                        t(this).addClass("active").removeClass("inactive"),
                        t(i).removeClass("active").addClass("inactive"),
                        t(i).eq(e).addClass("active").removeClass("inactive");
                    var l = i.eq(e).find(".smw-filter-gallery-container"),
                        o = i.eq(e).find(".smw-post-grid.smw-post-appender"),
                        r = i.eq(e).find(".smw-twitter-feed-masonry"),
                        s = i.eq(e).find(".smw-instafeed"),
                        c = i.eq(e).find(".premium-gallery-container");
                    o.length && o.isotope("layout"),
                        r.length && r.isotope("layout"),
                        l.length && l.isotope("layout"),
                        s.length && s.isotope("layout"),
                        c.length &&
                            c.each(function (e, a) 
                            {
                                t(a).isotope("layout");
                            }),
                        t(i).each(function (e) 
                        {
                            t(this).removeClass("active-default");
                        });
                });
        };
        jQuery(window).on("elementor/frontend/init", function () 
        {
            elementorFrontend.hooks.addAction("frontend/element_ready/stiles-advanced-tabs.default", a);
        });
    },
});