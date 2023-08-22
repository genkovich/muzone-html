
    (function () {
        var e,
            t,
            i,
            n,
            s = { frameRate: 150, animationTime: 400, stepSize: 100, pulseAlgorithm: !0, pulseScale: 4, pulseNormalize: 1, accelerationDelta: 50, accelerationMax: 3, keyboardSupport: !0, arrowScroll: 50, fixedBackground: !0, excluded: "" },
            r = s,
            a = !1,
            o = { x: 0, y: 0 },
            l = !1,
            c = document.documentElement,
            u = [],
            d = /^Mac/.test(navigator.platform),
            h = 37,
            p = 38,
            f = 39,
            m = 40,
            g = 32,
            v = 33,
            y = 34,
            b = 35,
            w = 36,
            x = { 37: 1, 38: 1, 39: 1, 40: 1 };
        function T() {
            if (!l && document.body) {
                l = !0;
                var n = document.body,
                    s = document.documentElement,
                    o = window.innerHeight,
                    u = n.scrollHeight;
                if (((c = document.compatMode.indexOf("CSS") >= 0 ? s : n), (e = n), r.keyboardSupport && F("keydown", $), top != self)) a = !0;
                else if (re && u > o && (n.offsetHeight <= o || s.offsetHeight <= o)) {
                    var d,
                        h = document.createElement("div");
                    (h.style.cssText = "position:absolute; z-index:-10000; top:0; left:0; right:0; height:" + c.scrollHeight + "px"),
                        document.body.appendChild(h),
                        (i = function () {
                            d ||
                                (d = setTimeout(function () {
                                    (h.style.height = "0"), (h.style.height = c.scrollHeight + "px"), (d = null);
                                }, 500));
                        }),
                        setTimeout(i, 10),
                        F("resize", i);
                    if (((t = new U(i)).observe(n, { attributes: !0, childList: !0, characterData: !1 }), c.offsetHeight <= o)) {
                        var p = document.createElement("div");
                        (p.style.clear = "both"), n.appendChild(p);
                    }
                }
                r.fixedBackground || ((n.style.backgroundAttachment = "scroll"), (s.style.backgroundAttachment = "scroll"));
            }
        }
        var C = [],
            S = !1,
            _ = Date.now();
        function E(e, t, i) {
            var n, s;
            if (((n = (n = t) > 0 ? 1 : -1), (s = (s = i) > 0 ? 1 : -1), (o.x !== n || o.y !== s) && ((o.x = n), (o.y = s), (C = []), (_ = 0)), 1 != r.accelerationMax)) {
                var a = Date.now() - _;
                if (a < r.accelerationDelta) {
                    var l = (1 + 50 / a) / 2;
                    l > 1 && ((l = Math.min(l, r.accelerationMax)), (t *= l), (i *= l));
                }
                _ = Date.now();
            }
            if ((C.push({ x: t, y: i, lastX: t < 0 ? 0.99 : -0.99, lastY: i < 0 ? 0.99 : -0.99, start: Date.now() }), !S)) {
                var c = K(),
                    u = e === c || e === document.body;
                null == e.$scrollBehavior &&
                    (function (e) {
                        var t = A(e);
                        if (null == L[t]) {
                            var i = getComputedStyle(e, "")["scroll-behavior"];
                            L[t] = "smooth" == i;
                        }
                        return L[t];
                    })(e) &&
                    ((e.$scrollBehavior = e.style.scrollBehavior), (e.style.scrollBehavior = "auto"));
                var d = function (n) {
                    for (var s = Date.now(), a = 0, o = 0, l = 0; l < C.length; l++) {
                        var c = C[l],
                            h = s - c.start,
                            p = h >= r.animationTime,
                            f = p ? 1 : h / r.animationTime;
                        r.pulseAlgorithm && (f = Z(f));
                        var m = (c.x * f - c.lastX) >> 0,
                            g = (c.y * f - c.lastY) >> 0;
                        (a += m), (o += g), (c.lastX += m), (c.lastY += g), p && (C.splice(l, 1), l--);
                    }
                    u ? window.scrollBy(a, o) : (a && (e.scrollLeft += a), o && (e.scrollTop += o)),
                        t || i || (C = []),
                        C.length ? V(d, e, 1e3 / r.frameRate + 1) : ((S = !1), null != e.$scrollBehavior && ((e.style.scrollBehavior = e.$scrollBehavior), (e.$scrollBehavior = null)));
                };
                V(d, e, 0), (S = !0);
            }
        }
        function k(t) {
            l || T();
            var i = t.target;
            if (t.defaultPrevented || t.ctrlKey) return !0;
            if (X(e, "embed") || (X(i, "embed") && /\.pdf/i.test(i.src)) || X(e, "object") || i.shadowRoot) return !0;
            var s = -t.wheelDeltaX || t.deltaX || 0,
                o = -t.wheelDeltaY || t.deltaY || 0;
            d && (t.wheelDeltaX && Y(t.wheelDeltaX, 120) && (s = (t.wheelDeltaX / Math.abs(t.wheelDeltaX)) * -120), t.wheelDeltaY && Y(t.wheelDeltaY, 120) && (o = (t.wheelDeltaY / Math.abs(t.wheelDeltaY)) * -120)),
                s || o || (o = -t.wheelDelta || 0),
                1 === t.deltaMode && ((s *= 40), (o *= 40));
            var c = N(i);
            return c
                ? !!(function (e) {
                      if (!e) return;
                      u.length || (u = [e, e, e]);
                      (e = Math.abs(e)),
                          u.push(e),
                          u.shift(),
                          clearTimeout(n),
                          (n = setTimeout(function () {
                              try {
                                  localStorage.SS_deltaBuffer = u.join(",");
                              } catch (e) {}
                          }, 1e3));
                      var t = e > 120 && W(e);
                      return !W(120) && !W(100) && !t;
                  })(o) || (Math.abs(s) > 1.2 && (s *= r.stepSize / 120), Math.abs(o) > 1.2 && (o *= r.stepSize / 120), E(c, s, o), t.preventDefault(), void I())
                : !a || !te || (Object.defineProperty(t, "target", { value: window.frameElement }), parent.wheel(t));
        }
        function $(t) {
            var i = t.target,
                n = t.ctrlKey || t.altKey || t.metaKey || (t.shiftKey && t.keyCode !== g);
            document.body.contains(e) || (e = document.activeElement);
            var s = /^(button|submit|radio|checkbox|file|color|image)$/i;
            if (
                t.defaultPrevented ||
                /^(textarea|select|embed|object)$/i.test(i.nodeName) ||
                (X(i, "input") && !s.test(i.type)) ||
                X(e, "video") ||
                (function (e) {
                    var t = e.target,
                        i = !1;
                    if (-1 != document.URL.indexOf("www.youtube.com/watch"))
                        do {
                            if ((i = t.classList && t.classList.contains("html5-video-controls"))) break;
                        } while ((t = t.parentNode));
                    return i;
                })(t) ||
                i.isContentEditable ||
                n
            )
                return !0;
            if ((X(i, "button") || (X(i, "input") && s.test(i.type))) && t.keyCode === g) return !0;
            if (X(i, "input") && "radio" == i.type && x[t.keyCode]) return !0;
            var o = 0,
                l = 0,
                c = N(e);
            if (!c) return !a || !te || parent.keydown(t);
            var u = c.clientHeight;
            switch ((c == document.body && (u = window.innerHeight), t.keyCode)) {
                case p:
                    l = -r.arrowScroll;
                    break;
                case m:
                    l = r.arrowScroll;
                    break;
                case g:
                    l = -(t.shiftKey ? 1 : -1) * u * 0.9;
                    break;
                case v:
                    l = 0.9 * -u;
                    break;
                case y:
                    l = 0.9 * u;
                    break;
                case w:
                    c == document.body && document.scrollingElement && (c = document.scrollingElement), (l = -c.scrollTop);
                    break;
                case b:
                    var d = c.scrollHeight - c.scrollTop - u;
                    l = d > 0 ? d + 10 : 0;
                    break;
                case h:
                    o = -r.arrowScroll;
                    break;
                case f:
                    o = r.arrowScroll;
                    break;
                default:
                    return !0;
            }
            E(c, o, l), t.preventDefault(), I();
        }
        function M(t) {
            e = t.target;
        }
        var P,
            A = (function () {
                var e = 0;
                return function (t) {
                    return t.uniqueID || (t.uniqueID = e++);
                };
            })(),
            D = {},
            O = {},
            L = {};
        function I() {
            clearTimeout(P),
                (P = setInterval(function () {
                    D = O = L = {};
                }, 1e3));
        }
        function z(e, t, i) {
            for (var n = i ? D : O, s = e.length; s--; ) n[A(e[s])] = t;
            return t;
        }
        function j(e, t) {
            return (t ? D : O)[A(e)];
        }
        function N(e) {
            var t = [],
                i = document.body,
                n = c.scrollHeight;
            do {
                var s = j(e, !1);
                if (s) return z(t, s);
                if ((t.push(e), n === e.scrollHeight)) {
                    var r = (q(c) && q(i)) || H(c);
                    if ((a && R(c)) || (!a && r)) return z(t, K());
                } else if (R(e) && H(e)) return z(t, e);
            } while ((e = e.parentElement));
        }
        function R(e) {
            return e.clientHeight + 10 < e.scrollHeight;
        }
        function q(e) {
            return "hidden" !== getComputedStyle(e, "").getPropertyValue("overflow-y");
        }
        function H(e) {
            var t = getComputedStyle(e, "").getPropertyValue("overflow-y");
            return "scroll" === t || "auto" === t;
        }
        function F(e, t, i) {
            window.addEventListener(e, t, i || !1);
        }
        function B(e, t, i) {
            window.removeEventListener(e, t, i || !1);
        }
        function X(e, t) {
            return e && (e.nodeName || "").toLowerCase() === t.toLowerCase();
        }
        if (window.localStorage && localStorage.SS_deltaBuffer)
            try {
                u = localStorage.SS_deltaBuffer.split(",");
            } catch (e) {}
        function Y(e, t) {
            return Math.floor(e / t) == e / t;
        }
        function W(e) {
            return Y(u[0], e) && Y(u[1], e) && Y(u[2], e);
        }
        var G,
            V =
                window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                function (e, t, i) {
                    window.setTimeout(e, i || 1e3 / 60);
                },
            U = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver,
            K =
                ((G = document.scrollingElement),
                function () {
                    if (!G) {
                        var e = document.createElement("div");
                        (e.style.cssText = "height:10000px;width:1px;"), document.body.appendChild(e);
                        var t = document.body.scrollTop;
                        document.documentElement.scrollTop, window.scrollBy(0, 3), (G = document.body.scrollTop != t ? document.body : document.documentElement), window.scrollBy(0, -3), document.body.removeChild(e);
                    }
                    return G;
                });
        function Q(e) {
            var t, i;
            return (e *= r.pulseScale) < 1 ? (t = e - (1 - Math.exp(-e))) : ((e -= 1), (t = (i = Math.exp(-1)) + (1 - Math.exp(-e)) * (1 - i))), t * r.pulseNormalize;
        }
        function Z(e) {
            return e >= 1 ? 1 : e <= 0 ? 0 : (1 == r.pulseNormalize && (r.pulseNormalize /= Q(1)), Q(e));
        }
        var J = window.navigator.userAgent,
            ee = /Edge/.test(J),
            te = /chrome/i.test(J) && !ee,
            ie = /safari/i.test(J) && !ee,
            ne = /mobile/i.test(J),
            se = /Windows NT 6.1/i.test(J) && /rv:11/i.test(J),
            re = ie && (/Version\/8/i.test(J) || /Version\/9/i.test(J)),
            ae = (te || ie || se) && !ne,
            oe = !1;
        try {
            window.addEventListener(
                "test",
                null,
                Object.defineProperty({}, "passive", {
                    get: function () {
                        oe = !0;
                    },
                })
            );
        } catch (e) {}
        var le = !!oe && { passive: !1 },
            ce = "onwheel" in document.createElement("div") ? "wheel" : "mousewheel";
        function ue(e) {
            for (var t in e) s.hasOwnProperty(t) && (r[t] = e[t]);
        }
        ce && ae && (F(ce, k, le), F("mousedown", M), F("load", T)),
            (ue.destroy = function () {
                t && t.disconnect(), B(ce, k), B("mousedown", M), B("keydown", $), B("resize", i), B("load", T);
            }),
            window.SmoothScrollOptions && ue(window.SmoothScrollOptions),
            "function" == typeof define && define.amd
                ? define(function () {
                      return ue;
                  })
                : "object" == typeof exports
                ? (module.exports = ue)
                : (window.SmoothScroll = ue);
    })();