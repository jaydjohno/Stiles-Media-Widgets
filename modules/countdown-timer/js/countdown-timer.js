!(function () 
{
    var t = !1;
    (window.JQClass = function () {}),
        (JQClass.classes = {}),
        (JQClass.extend = function e(i) {
            var n = this.prototype;
            t = !0;
            var s = new this();
            for (var o in ((t = !1), i))
                s[o] =
                    "function" == typeof i[o] && "function" == typeof n[o]
                        ? (function (t, e) {
                              return function () {
                                  var i = this._super;
                                  this._super = function (e) {
                                      return n[t].apply(this, e);
                                  };
                                  var s = e.apply(this, arguments);
                                  return (this._super = i), s;
                              };
                          })(o, i[o])
                        : i[o];
            function a() {
                !t && this._init && this._init.apply(this, arguments);
            }
            return (((a.prototype = s).constructor = a).extend = e), a;
        });
})(),
    (function ($) {
        function camelCase(t) {
            return t.replace(/-([a-z])/g, function (t, e) {
                return e.toUpperCase();
            });
        }
        (JQClass.classes.JQPlugin = JQClass.extend({
            name: "plugin",
            defaultOptions: {},
            regionalOptions: {},
            _getters: [],
            _getMarker: function () {
                return "is-" + this.name;
            },
            _init: function () {
                $.extend(this.defaultOptions, (this.regionalOptions && this.regionalOptions[""]) || {});
                var t = camelCase(this.name);
                ($[t] = this),
                    ($.fn[t] = function (e) {
                        var i = Array.prototype.slice.call(arguments, 1);
                        return $[t]._isNotChained(e, i)
                            ? $[t][e].apply($[t], [this[0]].concat(i))
                            : this.each(function () {
                                  if ("string" == typeof e) {
                                      if ("_" === e[0] || !$[t][e]) throw "Unknown method: " + e;
                                      $[t][e].apply($[t], [this].concat(i));
                                  } else $[t]._attach(this, e);
                              });
                    });
            },
            setDefaults: function (t) {
                $.extend(this.defaultOptions, t || {});
            },
            _isNotChained: function (t, e) {
                return ("option" === t && (0 === e.length || (1 === e.length && "string" == typeof e[0]))) || -1 < $.inArray(t, this._getters);
            },
            _attach: function (t, e) {
                if (!(t = $(t)).hasClass(this._getMarker())) {
                    t.addClass(this._getMarker()), (e = $.extend({}, this.defaultOptions, this._getMetadata(t), e || {}));
                    var i = $.extend({ name: this.name, elem: t, options: e }, this._instSettings(t, e));
                    t.data(this.name, i), this._postAttach(t, i), this.option(t, e);
                }
            },
            _instSettings: function (t, e) {
                return {};
            },
            _postAttach: function (t, e) {},
            _getMetadata: function (d) {
                try {
                    var f = d.data(this.name.toLowerCase()) || "";
                    for (var g in ((f = f.replace(/'/g, '"')),
                    (f = f.replace(/([a-zA-Z0-9]+):/g, function (t, e, i) {
                        var n = f.substring(0, i).match(/"/g);
                        return n && n.length % 2 != 0 ? e + ":" : '"' + e + '":';
                    })),
                    (f = $.parseJSON("{" + f + "}")),
                    f)) {
                        var h = f[g];
                        "string" == typeof h && h.match(/^new Date\((.*)\)$/) && (f[g] = eval(h));
                    }
                    return f;
                } catch (t) {
                    return {};
                }
            },
            _getInst: function (t) {
                return $(t).data(this.name) || {};
            },
            option: function (t, e, i) {
                var n = (t = $(t)).data(this.name);
                if (!e || ("string" == typeof e && null == i)) return (s = (n || {}).options) && e ? s[e] : s;
                if (t.hasClass(this._getMarker())) {
                    var s = e || {};
                    "string" == typeof e && ((s = {})[e] = i), this._optionsChanged(t, n, s), $.extend(n.options, s);
                }
            },
            _optionsChanged: function (t, e, i) {},
            destroy: function (t) {
                (t = $(t)).hasClass(this._getMarker()) && (this._preDestroy(t, this._getInst(t)), t.removeData(this.name).removeClass(this._getMarker()));
            },
            _preDestroy: function (t, e) {},
        })),
            ($.JQPlugin = {
                createPlugin: function (t, e) {
                    "object" == typeof t && ((e = t), (t = "JQPlugin")), (t = camelCase(t));
                    var i = camelCase(e.name);
                    (JQClass.classes[i] = JQClass.classes[t].extend(e)), new JQClass.classes[i]();
                },
            });
    })(jQuery),
    (function (t) {
        var e = "pre_countdown";
        t.JQPlugin.createPlugin({
            name: e,
            defaultOptions: {
                until: null,
                since: null,
                timezone: null,
                serverSync: null,
                format: "dHMS",
                layout: "",
                compact: !1,
                padZeroes: !1,
                significant: 0,
                description: "",
                expiryUrl: "",
                expiryText: "",
                alwaysExpire: !1,
                onExpiry: null,
                onTick: null,
                tickInterval: 1,
            },
            regionalOptions: {
                "": {
                    labels: ["Years", "Months", "Weeks", "Days", "Hours", "Minutes", "Seconds"],
                    labels1: ["Year", "Month", "Week", "Day", "Hour", "Minute", "Second"],
                    compactLabels: ["y", "m", "w", "d"],
                    whichLabels: null,
                    digits: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"],
                    timeSeparator: ":",
                    isRTL: !1,
                },
            },
            _getters: ["getTimes"],
            _rtlClass: e + "-rtl",
            _sectionClass: e + "-section",
            _amountClass: e + "-amount",
            _periodClass: e + "-period",
            _rowClass: e + "-row",
            _holdingClass: e + "-holding",
            _showClass: e + "-show",
            _descrClass: e + "-descr",
            _timerElems: [],
            _init: function () {
                var e = this;
                this._super(), (this._serverSyncs = []);
                var i =
                        "function" == typeof Date.now
                            ? Date.now
                            : function () {
                                  return new Date().getTime();
                              },
                    n = window.performance && "function" == typeof window.performance.now,
                    s = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || null,
                    o = 0;
                !s || t.noRequestAnimationFrame
                    ? ((t.noRequestAnimationFrame = null),
                      setInterval(function () {
                          e._updateElems();
                      }, 980))
                    : ((o = window.animationStartTime || window.webkitAnimationStartTime || window.mozAnimationStartTime || window.oAnimationStartTime || window.msAnimationStartTime || i()),
                      s(function t(a) {
                          var r = a < 1e12 ? (n ? performance.now() + performance.timing.navigationStart : i()) : a || i();
                          1e3 <= r - o && (e._updateElems(), (o = r)), s(t);
                      }));
            },
            UTCDate: function (t, e, i, n, s, o, a, r) {
                "object" == typeof e && e.constructor == Date && ((r = e.getMilliseconds()), (a = e.getSeconds()), (o = e.getMinutes()), (s = e.getHours()), (n = e.getDate()), (i = e.getMonth()), (e = e.getFullYear()));
                var l = new Date();
                return (
                    l.setUTCFullYear(e),
                    l.setUTCDate(1),
                    l.setUTCMonth(i || 0),
                    l.setUTCDate(n || 1),
                    l.setUTCHours(s || 0),
                    l.setUTCMinutes((o || 0) - (Math.abs(t) < 30 ? 60 * t : t)),
                    l.setUTCSeconds(a || 0),
                    l.setUTCMilliseconds(r || 0),
                    l
                );
            },
            periodsToSeconds: function (t) {
                return 31557600 * t[0] + 2629800 * t[1] + 604800 * t[2] + 86400 * t[3] + 3600 * t[4] + 60 * t[5] + t[6];
            },
            _instSettings: function (t, e) {
                return { _periods: [0, 0, 0, 0, 0, 0, 0] };
            },
            _addElem: function (t) {
                this._hasElem(t) || this._timerElems.push(t);
            },
            _hasElem: function (e) {
                return -1 < t.inArray(e, this._timerElems);
            },
            _removeElem: function (e) {
                this._timerElems = t.map(this._timerElems, function (t) {
                    return t == e ? null : t;
                });
            },
            _updateElems: function () {
                for (var t = this._timerElems.length - 1; 0 <= t; t--) this._updateCountdown(this._timerElems[t]);
            },
            _optionsChanged: function (e, i, n) {
                n.layout && (n.layout = n.layout.replace(/&lt;/g, "<").replace(/&gt;/g, ">")), this._resetExtraLabels(i.options, n);
                var s = i.options.timezone != n.timezone;
                t.extend(i.options, n), this._adjustSettings(e, i, null != n.until || null != n.since || s);
                var o = new Date();
                ((i._since && i._since < o) || (i._until && i._until > o)) && this._addElem(e[0]), this._updateCountdown(e, i);
            },
            _updateCountdown: function (e, i) {
                if (((e = e.jquery ? e : t(e)), (i = i || e.data(this.name)))) {
                    if ((e.html(this._generateHTML(i)).toggleClass(this._rtlClass, i.options.isRTL), t.isFunction(i.options.onTick))) {
                        var n = "lap" != i._hold ? i._periods : this._calculatePeriods(i, i._show, i.options.significant, new Date());
                        (1 != i.options.tickInterval && this.periodsToSeconds(n) % i.options.tickInterval != 0) || i.options.onTick.apply(e[0], [n]);
                    }
                    if ("pause" != i._hold && (i._since ? i._now.getTime() < i._since.getTime() : i._now.getTime() >= i._until.getTime()) && !i._expiring) {
                        if (((i._expiring = !0), this._hasElem(e[0]) || i.options.alwaysExpire)) {
                            if ((this._removeElem(e[0]), t.isFunction(i.options.onExpiry) && i.options.onExpiry.apply(e[0], []), i.options.expiryText)) {
                                var s = i.options.layout;
                                (i.options.layout = i.options.expiryText), this._updateCountdown(e[0], i), (i.options.layout = s);
                            }
                            i.options.expiryUrl && (window.location = i.options.expiryUrl);
                        }
                        i._expiring = !1;
                    } else "pause" == i._hold && this._removeElem(e[0]);
                }
            },
            _resetExtraLabels: function (t, e) {
                var i = !1;
                for (var n in e)
                    if ("whichLabels" != n && n.match(/[Ll]abels/)) {
                        i = !0;
                        break;
                    }
                if (i) for (var n in t) n.match(/[Ll]abels[02-9]|compactLabels1/) && (t[n] = null);
            },
            _adjustSettings: function (e, i, n) {
                for (var s, o = 0, a = null, r = 0; r < this._serverSyncs.length; r++)
                    if (this._serverSyncs[r][0] == i.options.serverSync) {
                        a = this._serverSyncs[r][1];
                        break;
                    }
                if (null != a) (o = i.options.serverSync ? a : 0), (s = new Date());
                else {
                    var l = t.isFunction(i.options.serverSync) ? i.options.serverSync.apply(e[0], []) : null;
                    (s = new Date()), (o = l ? s.getTime() - l.getTime() : 0), this._serverSyncs.push([i.options.serverSync, o]);
                }
                var p = i.options.timezone;
                (p = null == p ? -s.getTimezoneOffset() : p),
                    (n || (!n && null == i._until && null == i._since)) &&
                        ((i._since = i.options.since),
                        null != i._since && ((i._since = this.UTCDate(p, this._determineTime(i._since, null))), i._since && o && i._since.setMilliseconds(i._since.getMilliseconds() + o)),
                        (i._until = this.UTCDate(p, this._determineTime(i.options.until, s))),
                        o && i._until.setMilliseconds(i._until.getMilliseconds() + o)),
                    (i._show = this._determineShow(i));
            },
            _preDestroy: function (t, e) {
                this._removeElem(t[0]), t.empty();
            },
            pause: function (t) {
                this._hold(t, "pause");
            },
            lap: function (t) {
                this._hold(t, "lap");
            },
            resume: function (t) {
                this._hold(t, null);
            },
            toggle: function (e) {
                this[(t.data(e, this.name) || {})._hold ? "resume" : "pause"](e);
            },
            toggleLap: function (e) {
                this[(t.data(e, this.name) || {})._hold ? "resume" : "lap"](e);
            },
            _hold: function (e, i) {
                var n = t.data(e, this.name);
                if (n) {
                    if ("pause" == n._hold && !i) {
                        n._periods = n._savePeriods;
                        var s = n._since ? "-" : "+";
                        (n[n._since ? "_since" : "_until"] = this._determineTime(
                            s + n._periods[0] + "y" + s + n._periods[1] + "o" + s + n._periods[2] + "w" + s + n._periods[3] + "d" + s + n._periods[4] + "h" + s + n._periods[5] + "m" + s + n._periods[6] + "s"
                        )),
                            this._addElem(e);
                    }
                    (n._hold = i), (n._savePeriods = "pause" == i ? n._periods : null), t.data(e, this.name, n), this._updateCountdown(e, n);
                }
            },
            getTimes: function (e) {
                var i = t.data(e, this.name);
                return i ? ("pause" == i._hold ? i._savePeriods : i._hold ? this._calculatePeriods(i, i._show, i.options.significant, new Date()) : i._periods) : null;
            },
            _determineTime: function (t, e) {
                var i,
                    n,
                    s = this,
                    o =
                        null == t
                            ? e
                            : "string" == typeof t
                            ? (function (t) {
                                  t = t.toLowerCase();
                                  for (var e = new Date(), i = e.getFullYear(), n = e.getMonth(), o = e.getDate(), a = e.getHours(), r = e.getMinutes(), l = e.getSeconds(), p = /([+-]?[0-9]+)\s*(s|m|h|d|w|o|y)?/g, _ = p.exec(t); _; ) {
                                      switch (_[2] || "s") {
                                          case "s":
                                              l += parseInt(_[1], 10);
                                              break;
                                          case "m":
                                              r += parseInt(_[1], 10);
                                              break;
                                          case "h":
                                              a += parseInt(_[1], 10);
                                              break;
                                          case "d":
                                              o += parseInt(_[1], 10);
                                              break;
                                          case "w":
                                              o += 7 * parseInt(_[1], 10);
                                              break;
                                          case "o":
                                              (n += parseInt(_[1], 10)), (o = Math.min(o, s._getDaysInMonth(i, n)));
                                              break;
                                          case "y":
                                              (i += parseInt(_[1], 10)), (o = Math.min(o, s._getDaysInMonth(i, n)));
                                      }
                                      _ = p.exec(t);
                                  }
                                  return new Date(i, n, o, a, r, l, 0);
                              })(t)
                            : "number" == typeof t
                            ? ((i = t), (n = new Date()).setTime(n.getTime() + 1e3 * i), n)
                            : t;
                return o && o.setMilliseconds(0), o;
            },
            _getDaysInMonth: function (t, e) {
                return 32 - new Date(t, e, 32).getDate();
            },
            _normalLabels: function (t) {
                return t;
            },
            _generateHTML: function (e) {
                var i = this;
                e._periods = e._hold ? e._periods : this._calculatePeriods(e, e._show, e.options.significant, new Date());
                for (var n = !1, s = 0, o = e.options.significant, a = t.extend({}, e._show), r = 0; r <= 6; r++)
                    (n |= "?" == e._show[r] && 0 < e._periods[r]), (a[r] = "?" != e._show[r] || n ? e._show[r] : null), (s += a[r] ? 1 : 0), (o -= 0 < e._periods[r] ? 1 : 0);
                var l = [!1, !1, !1, !1, !1, !1, !1];
                for (r = 6; 0 <= r; r--) e._show[r] && (e._periods[r] ? (l[r] = !0) : ((l[r] = 0 < o), o--));
                var p = e.options.compact ? e.options.compactLabels : e.options.labels,
                    _ = e.options.whichLabels || this._normalLabels,
                    h = e.options.padZeroes ? 2 : 1,
                    u = function (t) {
                        var n = e.options["labels" + _(e._periods[t])];
                        return (!e.options.significant && a[t]) || (e.options.significant && l[t])
                            ? '<span class="' +
                                  i._sectionClass +
                                  '"><span class="pre_time-mid"><span class="' +
                                  i._amountClass +
                                  '">' +
                                  i._minDigits(e, e._periods[t], h) +
                                  '</span><span class="' +
                                  i._periodClass +
                                  '">' +
                                  (n ? n[t] : p[t]) +
                                  "</span></span><span class='pre-countdown_separator'>" +
                                  e.options.timeSeparator +
                                  "</span></span>"
                            : "";
                    };
                return (
                    '<span class="' +
                    this._rowClass +
                    " " +
                    this._showClass +
                    (e.options.significant || s) +
                    (e._hold ? " " + this._holdingClass : "") +
                    '">' +
                    u(0) +
                    u(1) +
                    u(2) +
                    u(3) +
                    u(4) +
                    u(5) +
                    u(6) +
                    "</span>" +
                    (e.options.description ? '<span class="' + this._rowClass + " " + this._descrClass + '">' + e.options.description + "</span>" : "")
                );
            },
            _buildLayout: function (e, i, n, s, o, a) {
                for (
                    var r = e.options[s ? "compactLabels" : "labels"],
                        l = e.options.whichLabels || this._normalLabels,
                        p = function (t) {
                            return (e.options[(s ? "compactLabels" : "labels") + l(e._periods[t])] || r)[t];
                        },
                        _ = function (t, i) {
                            return e.options.digits[Math.floor(t / i) % 10];
                        },
                        h = {
                            desc: e.options.description,
                            sep: e.options.timeSeparator,
                            yl: p(0),
                            yn: this._minDigits(e, e._periods[0], 1),
                            ynn: this._minDigits(e, e._periods[0], 2),
                            ynnn: this._minDigits(e, e._periods[0], 3),
                            y1: _(e._periods[0], 1),
                            y10: _(e._periods[0], 10),
                            y100: _(e._periods[0], 100),
                            y1000: _(e._periods[0], 1e3),
                            ol: p(1),
                            on: this._minDigits(e, e._periods[1], 1),
                            onn: this._minDigits(e, e._periods[1], 2),
                            onnn: this._minDigits(e, e._periods[1], 3),
                            o1: _(e._periods[1], 1),
                            o10: _(e._periods[1], 10),
                            o100: _(e._periods[1], 100),
                            o1000: _(e._periods[1], 1e3),
                            wl: p(2),
                            wn: this._minDigits(e, e._periods[2], 1),
                            wnn: this._minDigits(e, e._periods[2], 2),
                            wnnn: this._minDigits(e, e._periods[2], 3),
                            w1: _(e._periods[2], 1),
                            w10: _(e._periods[2], 10),
                            w100: _(e._periods[2], 100),
                            w1000: _(e._periods[2], 1e3),
                            dl: p(3),
                            dn: this._minDigits(e, e._periods[3], 1),
                            dnn: this._minDigits(e, e._periods[3], 2),
                            dnnn: this._minDigits(e, e._periods[3], 3),
                            d1: _(e._periods[3], 1),
                            d10: _(e._periods[3], 10),
                            d100: _(e._periods[3], 100),
                            d1000: _(e._periods[3], 1e3),
                            hl: p(4),
                            hn: this._minDigits(e, e._periods[4], 1),
                            hnn: this._minDigits(e, e._periods[4], 2),
                            hnnn: this._minDigits(e, e._periods[4], 3),
                            h1: _(e._periods[4], 1),
                            h10: _(e._periods[4], 10),
                            h100: _(e._periods[4], 100),
                            h1000: _(e._periods[4], 1e3),
                            ml: p(5),
                            mn: this._minDigits(e, e._periods[5], 1),
                            mnn: this._minDigits(e, e._periods[5], 2),
                            mnnn: this._minDigits(e, e._periods[5], 3),
                            m1: _(e._periods[5], 1),
                            m10: _(e._periods[5], 10),
                            m100: _(e._periods[5], 100),
                            m1000: _(e._periods[5], 1e3),
                            sl: p(6),
                            sn: this._minDigits(e, e._periods[6], 1),
                            snn: this._minDigits(e, e._periods[6], 2),
                            snnn: this._minDigits(e, e._periods[6], 3),
                            s1: _(e._periods[6], 1),
                            s10: _(e._periods[6], 10),
                            s100: _(e._periods[6], 100),
                            s1000: _(e._periods[6], 1e3),
                        },
                        u = n,
                        c = 0;
                    c <= 6;
                    c++
                ) {
                    var d = "yowdhms".charAt(c),
                        m = new RegExp("\\{" + d + "<\\}([\\s\\S]*)\\{" + d + ">\\}", "g");
                    u = u.replace(m, (!o && i[c]) || (o && a[c]) ? "$1" : "");
                }
                return (
                    t.each(h, function (t, e) {
                        var i = new RegExp("\\{" + t + "\\}", "g");
                        u = u.replace(i, e);
                    }),
                    u
                );
            },
            _minDigits: function (t, e, i) {
                return (e = "" + e).length >= i ? this._translateDigits(t, e) : ((e = "0000000000" + e), this._translateDigits(t, e.substr(e.length - i)));
            },
            _translateDigits: function (t, e) {
                return ("" + e).replace(/[0-9]/g, function (e) {
                    return t.options.digits[e];
                });
            },
            _determineShow: function (t) {
                var e = t.options.format,
                    i = [];
                return (
                    (i[0] = e.match("y") ? "?" : e.match("Y") ? "!" : null),
                    (i[1] = e.match("o") ? "?" : e.match("O") ? "!" : null),
                    (i[2] = e.match("w") ? "?" : e.match("W") ? "!" : null),
                    (i[3] = e.match("d") ? "?" : e.match("D") ? "!" : null),
                    (i[4] = e.match("h") ? "?" : e.match("H") ? "!" : null),
                    (i[5] = e.match("m") ? "?" : e.match("M") ? "!" : null),
                    (i[6] = e.match("s") ? "?" : e.match("S") ? "!" : null),
                    i
                );
            },
            _calculatePeriods: function (t, e, i, n) {
                (t._now = n), t._now.setMilliseconds(0);
                var s = new Date(t._now.getTime());
                t._since ? (n.getTime() < t._since.getTime() ? (t._now = n = s) : (n = t._since)) : (s.setTime(t._until.getTime()), n.getTime() > t._until.getTime() && (t._now = n = s));
                var o = [0, 0, 0, 0, 0, 0, 0];
                if (e[0] || e[1]) {
                    var a = this._getDaysInMonth(n.getFullYear(), n.getMonth()),
                        r = this._getDaysInMonth(s.getFullYear(), s.getMonth()),
                        l = s.getDate() == n.getDate() || (s.getDate() >= Math.min(a, r) && n.getDate() >= Math.min(a, r)),
                        p = function (t) {
                            return 60 * (60 * t.getHours() + t.getMinutes()) + t.getSeconds();
                        },
                        _ = Math.max(0, 12 * (s.getFullYear() - n.getFullYear()) + s.getMonth() - n.getMonth() + ((s.getDate() < n.getDate() && !l) || (l && p(s) < p(n)) ? -1 : 0));
                    (o[0] = e[0] ? Math.floor(_ / 12) : 0), (o[1] = e[1] ? _ - 12 * o[0] : 0);
                    var h = (n = new Date(n.getTime())).getDate() == a,
                        u = this._getDaysInMonth(n.getFullYear() + o[0], n.getMonth() + o[1]);
                    n.getDate() > u && n.setDate(u), n.setFullYear(n.getFullYear() + o[0]), n.setMonth(n.getMonth() + o[1]), h && n.setDate(u);
                }
                var c = Math.floor((s.getTime() - n.getTime()) / 1e3),
                    d = function (t, i) {
                        (o[t] = e[t] ? Math.floor(c / i) : 0), (c -= o[t] * i);
                    };
                if ((d(2, 604800), d(3, 86400), d(4, 3600), d(5, 60), d(6, 1), 0 < c && !t._since))
                    for (var m = [1, 12, 4.3482, 7, 24, 60, 60], g = 6, f = 1, w = 6; 0 <= w; w--) e[w] && (o[g] >= f && ((o[g] = 0), (c = 1)), 0 < c && (o[w]++, (c = 0), (g = w), (f = 1))), (f *= m[w]);
                if (i) for (w = 0; w <= 6; w++) i && o[w] ? i-- : i || (o[w] = 0);
                return o;
            },
        });
    })(jQuery);