!(function (e) 
{
    var a = {};
    function t(n) {
        if (a[n]) return a[n].exports;
        var o = (a[n] = { i: n, l: !1, exports: {} });
        return e[n].call(o.exports, o, o.exports, t), (o.l = !0), o.exports;
    }
    (t.m = e),
        (t.c = a),
        (t.d = function (e, a, n) {
            t.o(e, a) || Object.defineProperty(e, a, { enumerable: !0, get: n });
        }),
        (t.r = function (e) {
            "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, { value: "Module" }), Object.defineProperty(e, "__esModule", { value: !0 });
        }),
        (t.t = function (e, a) {
            if ((1 & a && (e = t(e)), 8 & a)) return e;
            if (4 & a && "object" == typeof e && e && e.__esModule) return e;
            var n = Object.create(null);
            if ((t.r(n), Object.defineProperty(n, "default", { enumerable: !0, value: e }), 2 & a && "string" != typeof e))
                for (var o in e)
                    t.d(
                        n,
                        o,
                        function (a) {
                            return e[a];
                        }.bind(null, o)
                    );
            return n;
        }),
        (t.n = function (e) {
            var a =
                e && e.__esModule
                    ? function () {
                          return e.default;
                      }
                    : function () {
                          return e;
                      };
            return t.d(a, "a", a), a;
        }),
        (t.o = function (e, a) {
            return Object.prototype.hasOwnProperty.call(e, a);
        }),
        (t.p = ""),
        t((t.s = 25));
})({
    25: function (e, a) {
        var t = function (e, a) {
            var t = e.find(".smw-tm-carousel").eq(0),
                n = void 0 !== t.data("pagination") ? t.data("pagination") : ".swiper-pagination",
                o = void 0 !== t.data("arrow-next") ? t.data("arrow-next") : ".swiper-button-next",
                r = void 0 !== t.data("arrow-prev") ? t.data("arrow-prev") : ".swiper-button-prev",
                i = void 0 !== t.data("items") ? t.data("items") : 3,
                d = void 0 !== t.data("items-tablet") ? t.data("items-tablet") : 3,
                l = void 0 !== t.data("items-mobile") ? t.data("items-mobile") : 3,
                u = void 0 !== t.data("margin") ? t.data("margin") : 10,
                p = void 0 !== t.data("margin-tablet") ? t.data("margin-tablet") : 10,
                s = void 0 !== t.data("margin-mobile") ? t.data("margin-mobile") : 10,
                c = void 0 !== t.data("speed") ? t.data("speed") : 400,
                f = void 0 !== t.data("autoplay") ? t.data("autoplay") : 999999,
                v = void 0 !== t.data("loop") ? t.data("loop") : 0,
                m = void 0 !== t.data("grab-cursor") ? t.data("grab-cursor") : 0,
                b = (void 0 !== t.data("id") && t.data("id"), void 0 !== t.data("pause-on-hover") ? t.data("pause-on-hover") : ""),
                w = {
                    direction: "horizontal",
                    speed: c,
                    grabCursor: m,
                    loop: v,
                    autoplay: { delay: f },
                    pagination: { el: n, clickable: !0 },
                    navigation: { nextEl: o, prevEl: r },
                    breakpoints: { 1024: { slidesPerView: i, spaceBetween: u }, 768: { slidesPerView: d, spaceBetween: p }, 320: { slidesPerView: l, spaceBetween: s } },
                },
                g = new Swiper(t, w);
            0 == f && g.autoplay.stop(),
                b &&
                    0 !== f &&
                    (t.on("mouseenter", function () {
                        g.autoplay.stop();
                    }),
                    t.on("mouseleave", function () {
                        g.autoplay.start();
                    }));
            var y = a(".smw-advance-tabs"),
                x = y.find(".smw-tabs-nav li"),
                j = y.find(".smw-tabs-content > div");
            x.on("click", function () {
                var e = j.eq(a(this).index());
                a(e).find(".swiper-container-wrap.smw-team-member-carousel-wrap").length && new Swiper(t, w);
            }),
                g.update();
        };
        
        jQuery(window).on("elementor/frontend/init", function () 
        {
            elementorFrontend.hooks.addAction("frontend/element_ready/stiles-team-member-carousel.default", t);
        });
    },
});