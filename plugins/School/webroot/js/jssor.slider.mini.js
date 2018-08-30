/*Jssor*/
(function (g, f, b, h, c, e, l) {/*! Jssor */
    new (function () {
    });
    var d = {Pd: function (a) {
            return a
        }, mc: function (a) {
            return-b.cos(a * b.PI) / 2 + .5
        }, n: function (a) {
            return-a * (a - 2)
        }, d: function (a) {
            return 1 - b.cos(a * b.PI * 2)
        }}, q = {Zc: function (a) {
            return(a & 3) > 0
        }, Xc: function (a) {
            return(a & 12) > 0
        }}, u = {vd: 37, Qd: 39}, o, m, a = new function () {
        var d = this, lb = 1, F = 2, F = 3, fb = 4, jb = 5, q = 0, k = 0, t = 0, Y = 0, D = 0, qb = navigator.appName, j = navigator.userAgent, p = f.documentElement, B;
        function x() {
            if (!q)
                if (qb == "Microsoft Internet Explorer" && !!g.attachEvent && !!g.ActiveXObject) {
                    var d = j.indexOf("MSIE");
                    q = lb;
                    t = m(j.substring(d + 5, j.indexOf(";", d)));/*@cc_on Y=@_jscript_version@*/
                    ;
                    k = f.documentMode || t
                } else if (qb == "Netscape" && !!g.addEventListener) {
                    var c = j.indexOf("Firefox"), a = j.indexOf("Safari"), h = j.indexOf("Chrome"), b = j.indexOf("AppleWebKit");
                    if (c >= 0) {
                        q = F;
                        k = m(j.substring(c + 8))
                    } else if (a >= 0) {
                        var i = j.substring(0, a).lastIndexOf("/");
                        q = h >= 0 ? fb : F;
                        k = m(j.substring(i + 1, a))
                    }
                    if (b >= 0)
                        D = m(j.substring(b + 12))
                } else {
                    var e = /(opera)(?:.*version|)[ \/]([\w.]+)/i.exec(j);
                    if (e) {
                        q = jb;
                        k = m(e[2])
                    }
                }
        }
        function s() {
            x();
            return q == lb
        }
        function N() {
            return s() && (k < 6 || f.compatMode == "BackCompat")
        }
        function eb() {
            x();
            return q == F
        }
        function db() {
            x();
            return q == fb
        }
        function ib() {
            x();
            return q == jb
        }
        function Z() {
            return eb() && D > 534 && D < 535
        }
        function A() {
            return s() && k < 9
        }
        function u(a) {
            if (!B) {
                i(["transform", "WebkitTransform", "msTransform", "MozTransform", "OTransform"], function (b) {
                    if (a.style[b] != l) {
                        B = b;
                        return c
                    }
                });
                B = B || "transform"
            }
            return B
        }
        function ob(a) {
            return Object.prototype.toString.call(a)
        }
        var I;
        function i(a, d) {
            if (ob(a) == "[object Array]") {
                for (var b = 0; b < a.length; b++)
                    if (d(a[b], b, a))
                        return c
            } else
                for (var e in a)
                    if (d(a[e], e, a))
                        return c
        }
        function vb() {
            if (!I) {
                I = {};
                i(["Boolean", "Number", "String", "Function", "Array", "Date", "RegExp", "Object"], function (a) {
                    I["[object " + a + "]"] = a.toLowerCase()
                })
            }
            return I
        }
        function z(a) {
            return a == h ? String(a) : vb()[ob(a)] || "object"
        }
        function y(a, b) {
            return{x: a, y: b}
        }
        function pb(b, a) {
            setTimeout(b, a || 0)
        }
        function G(b, d, c) {
            var a = !b || b == "inherit" ? "" : b;
            i(d, function (c) {
                var b = c.exec(a);
                if (b) {
                    var d = a.substr(0, b.index), e = a.substr(b.lastIndex + 1, a.length - (b.lastIndex + 1));
                    a = d + e
                }
            });
            a = c + (a.indexOf(" ") != 0 ? " " : "") + a;
            return a
        }
        function bb(b, a) {
            if (k < 9)
                b.style.filter = a
        }
        function sb(b, a, c) {
            if (Y < 9) {
                var f = b.style.filter, h = new RegExp(/[\s]*progid:DXImageTransform\.Microsoft\.Matrix\([^\)]*\)/g), g = a ? "progid:DXImageTransform.Microsoft.Matrix(M11=" + a[0][0] + ", M12=" + a[0][1] + ", M21=" + a[1][0] + ", M22=" + a[1][1] + ", SizingMethod='auto expand')" : "", e = G(f, [h], g);
                bb(b, e);
                d.Yc(b, c.y);
                d.ad(b, c.x)
            }
        }
        d.Db = s;
        d.Dd = eb;
        d.Fb = db;
        d.md = ib;
        d.ab = A;
        d.P = function () {
            return k
        };
        d.Te = function () {
            return t || k
        };
        d.ac = function () {
            x();
            return D
        };
        d.j = pb;
        function mb(a) {
            a.constructor === mb.caller && a.dd && a.dd()
        }
        d.dd = mb;
        d.ub = function (a) {
            if (d.Se(a))
                a = f.getElementById(a);
            return a
        };
        function v(a) {
            return a || g.event
        }
        d.ed = function (a) {
            a = v(a);
            return a.target || a.srcElement || f
        };
        d.id = function (a) {
            a = v(a);
            var b = f.body;
            return{x: a.pageX || a.clientX + (p.scrollLeft || b.scrollLeft || 0) - (p.clientLeft || b.clientLeft || 0) || 0, y: a.pageY || a.clientY + (p.scrollTop || b.scrollTop || 0) - (p.clientTop || b.clientTop || 0) || 0}
        };
        function E(c, d, a) {
            if (a != l)
                c.style[d] = a;
            else {
                var b = c.currentStyle || c.style;
                a = b[d];
                if (a == "" && g.getComputedStyle) {
                    b = c.ownerDocument.defaultView.getComputedStyle(c, h);
                    b && (a = b.getPropertyValue(d) || b[d])
                }
                return a
            }
        }
        function V(b, c, a, d) {
            if (a != l) {
                d && (a += "px");
                E(b, c, a)
            } else
                return m(E(b, c))
        }
        function n(d, a) {
            var b = a & 2, c = a ? V : E;
            return function (e, a) {
                return c(e, d, a, b)
            }
        }
        function tb(b) {
            if (s() && t < 9) {
                var a = /opacity=([^)]*)/.exec(b.style.filter || "");
                return a ? m(a[1]) / 100 : 1
            } else
                return m(b.style.opacity || "1")
        }
        function ub(c, a, f) {
            if (s() && t < 9) {
                var h = c.style.filter || "", i = new RegExp(/[\s]*alpha\([^\)]*\)/g), e = b.round(100 * a), d = "";
                if (e < 100 || f)
                    d = "alpha(opacity=" + e + ") ";
                var g = G(h, [i], d);
                bb(c, g)
            } else
                c.style.opacity = a == 1 ? "" : b.round(a * 100) / 100
        }
        function X(f, a) {
            var e = a.v || 0, c = a.J == l ? 1 : a.J;
            if (A()) {
                var k = d.ke(e / 180 * b.PI, c, c);
                sb(f, !e && c == 1 ? h : k, d.ze(k, a.gb, a.hb))
            } else {
                var i = u(f);
                if (i) {
                    var j = "rotate(" + e % 360 + "deg) scale(" + c + ")";
                    if (db() && D > 535 && "ontouchstart"in g)
                        j += " perspective(2000px)";
                    f.style[i] = j
                }
            }
        }
        d.se = function (b, a) {
            if (Z())
                pb(d.Jb(h, X, b, a));
            else
                X(b, a)
        };
        d.we = function (b, c) {
            var a = u(b);
            if (a)
                b.style[a + "Origin"] = c
        };
        d.le = function (a, c) {
            if (s() && t < 9 || t < 10 && N())
                a.style.zoom = c == 1 ? "" : c;
            else {
                var b = u(a);
                if (b) {
                    var f = "scale(" + c + ")", e = a.style[b], g = new RegExp(/[\s]*scale\(.*?\)/g), d = G(e, [g], f);
                    a.style[b] = d
                }
            }
        };
        d.qe = function (a) {
            if (!a.style[u(a)] || a.style[u(a)] == "none")
                a.style[u(a)] = "perspective(2000px)"
        };
        d.We = function (a) {
            a.style[u(a)] = "none"
        };
        d.ld = function (b, a) {
            return function (c) {
                c = v(c);
                var f = c.type, e = c.relatedTarget || (f == "mouseout" ? c.toElement : c.fromElement);
                (!e || e !== a && !d.Ne(a, e)) && b(c)
            }
        };
        d.u = function (a, c, e, b) {
            a = d.ub(a);
            if (a.addEventListener) {
                c == "mousewheel" && a.addEventListener("DOMMouseScroll", e, b);
                a.addEventListener(c, e, b)
            } else if (a.attachEvent) {
                a.attachEvent("on" + c, e);
                b && a.setCapture && a.setCapture()
            }
        };
        d.Ib = function (a, c, e, b) {
            a = d.ub(a);
            if (a.removeEventListener) {
                c == "mousewheel" && a.removeEventListener("DOMMouseScroll", e, b);
                a.removeEventListener(c, e, b)
            } else if (a.detachEvent) {
                a.detachEvent("on" + c, e);
                b && a.releaseCapture && a.releaseCapture()
            }
        };
        d.Q = function (a) {
            a = v(a);
            a.preventDefault && a.preventDefault();
            a.cancel = c;
            a.returnValue = e
        };
        d.xc = function (a) {
            a = v(a);
            a.stopPropagation && a.stopPropagation();
            a.cancelBubble = c
        };
        d.Jb = function (d, c) {
            var a = [].slice.call(arguments, 2), b = function () {
                var b = a.concat([].slice.call(arguments, 0));
                return c.apply(d, b)
            };
            return b
        };
        d.ie = function (a, b) {
            if (b == l)
                return a.textContent || a.innerText;
            var c = f.createTextNode(b);
            d.Bc(a);
            a.appendChild(c)
        };
        d.Bc = function (a) {
            a.innerHTML = ""
        };
        d.fb = function (c) {
            for (var b = [], a = c.firstChild; a; a = a.nextSibling)
                a.nodeType == 1 && b.push(a);
            return b
        };
        function nb(a, c, e, b) {
            b = b || "u";
            for (a = a?a.firstChild:h; a; a = a.nextSibling)
                if (a.nodeType == 1) {
                    if (R(a, b) == c)
                        return a;
                    if (!e) {
                        var d = nb(a, c, e, b);
                        if (d)
                            return d
                    }
                }
        }
        d.G = nb;
        function gb(a, c, d) {
            for (a = a?a.firstChild:h; a; a = a.nextSibling)
                if (a.nodeType == 1) {
                    if (a.tagName == c)
                        return a;
                    if (!d) {
                        var b = gb(a, c, d);
                        if (b)
                            return b
                    }
                }
        }
        d.te = gb;
        function ab(a, c, e) {
            var b = [];
            for (a = a?a.firstChild:h; a; a = a.nextSibling)
                if (a.nodeType == 1) {
                    (!c || a.tagName == c) && b.push(a);
                    if (!e) {
                        var d = ab(a, c, e);
                        if (d.length)
                            b = b.concat(d)
                    }
                }
            return b
        }
        d.ue = ab;
        function U(c) {
            for (var b = 1; b < arguments.length; b++) {
                var a = arguments[b];
                if (a)
                    for (var d in a)
                        c[d] = a[d]
            }
            return c
        }
        d.B = U;
        d.Ec = function (a) {
            return z(a) == "function"
        };
        d.Ae = function (a) {
            return z(a) == "array"
        };
        d.Se = function (a) {
            return z(a) == "string"
        };
        d.Yb = function (a) {
            return!isNaN(m(a)) && isFinite(a)
        };
        d.i = i;
        function O(a) {
            return f.createElement(a)
        }
        d.Bb = function () {
            return O("DIV", f)
        };
        d.Fc = function () {
        };
        function S(b, c, a) {
            if (a == l)
                return b.getAttribute(c);
            b.setAttribute(c, a)
        }
        function R(a, b) {
            return S(a, b) || S(a, "data-" + b)
        }
        d.Y = R;
        function r(b, a) {
            if (a == l)
                return b.className;
            b.className = a
        }
        d.Sc = r;
        d.Pe = function (a) {
            return a.parentNode
        };
        d.H = function (a) {
            d.T(a, "none")
        };
        d.S = function (a, b) {
            d.T(a, b ? "none" : "")
        };
        d.Pc = function (b, a) {
            b.removeAttribute(a)
        };
        d.Ge = function () {
            return s() && k < 10
        };
        d.Ee = function (d, c) {
            if (c)
                d.style.clip = "rect(" + b.round(c.b) + "px " + b.round(c.s) + "px " + b.round(c.q) + "px " + b.round(c.a) + "px)";
            else {
                var g = d.style.cssText, f = [new RegExp(/[\s]*clip: rect\(.*?\)[;]?/i), new RegExp(/[\s]*cliptop: .*?[;]?/i), new RegExp(/[\s]*clipright: .*?[;]?/i), new RegExp(/[\s]*clipbottom: .*?[;]?/i), new RegExp(/[\s]*clipleft: .*?[;]?/i)], e = G(g, f, "");
                a.gc(d, e)
            }
        };
        d.U = function () {
            return+new Date
        };
        d.M = function (b, a) {
            b.appendChild(a)
        };
        d.hc = function (c, b, a) {
            c.insertBefore(b, a)
        };
        d.Qc = function (b, a) {
            b.removeChild(a)
        };
        d.Ke = function (b, a) {
            i(a, function (a) {
                d.Qc(b, a)
            })
        };
        d.Ie = function (a) {
            d.Ke(a, d.fb(a))
        };
        function m(a) {
            return parseFloat(a)
        }
        d.wd = m;
        d.Ne = function (b, a) {
            var c = f.body;
            while (a && b != a && c != a)
                try {
                    a = a.parentNode
                } catch (d) {
                    return e
                }
            return b == a
        };
        function T(e, c, b) {
            var a = e.cloneNode(!c);
            !b && d.Pc(a, "id");
            return a
        }
        d.X = T;
        function M(a) {
            if (a) {
                var b = a.jf;
                if (b & 1)
                    a.x = a.zd || 1;
                if (b & 2)
                    a.x = -a.zd || -1;
                if (b & 4)
                    a.y = a.Cd || 1;
                if (b & 8)
                    a.y = -a.Cd || -1;
                if (a.v == c)
                    a.v = 1;
                M(a.Hb)
            }
        }
        d.Tb = function (a) {
            if (a) {
                for (var b = 0; b < a.length; b++)
                    M(a[b]);
                for (var c in a)
                    M(a[c])
            }
        };
        d.mb = function (f, g) {
            var a = new Image;
            function b(c) {
                d.Ib(a, "load", b);
                d.Ib(a, "abort", e);
                d.Ib(a, "error", e);
                g && g(a, c)
            }
            function e() {
                b(c)
            }
            if (ib() && k < 11.6 || !f)
                b(!f);
            else {
                d.u(a, "load", b);
                d.u(a, "abort", e);
                d.u(a, "error", e);
                a.src = f
            }
        };
        d.Ad = function (e, a, f) {
            var c = e.length + 1;
            function b(b) {
                c--;
                if (a && b && b.src == a.src)
                    a = b;
                !c && f && f(a)
            }
            i(e, function (a) {
                d.mb(a.src, b)
            });
            b()
        };
        d.lb = E;
        d.jb = n("overflow");
        d.kb = n("top", 2);
        d.xb = n("left", 2);
        d.C = n("width", 2);
        d.K = n("height", 2);
        d.ad = n("marginLeft", 2);
        d.Yc = n("marginTop", 2);
        d.I = n("position");
        d.T = n("display");
        d.W = n("zIndex", 1);
        d.rb = function (b, a, c) {
            if (a != l)
                ub(b, a, c);
            else
                return tb(b)
        };
        d.gc = function (a, b) {
            if (b != l)
                a.style.cssText = b;
            else
                return a.style.cssText
        };
        var Q = {F: d.rb, b: d.kb, a: d.xb, bb: d.C, db: d.K, qb: d.I, hf: d.T, cb: d.W}, w;
        function H() {
            if (!w)
                w = U({ff: d.Yc, gf: d.ad, c: d.Ee, ib: d.se}, Q);
            return w
        }
        function kb() {
            H();
            w.ib = w.ib;
            return w
        }
        d.ee = H;
        d.E = function (c, b) {
            var a = H();
            i(b, function (d, b) {
                a[b] && a[b](c, d)
            })
        };
        d.ce = function (b, a) {
            kb();
            d.E(b, a)
        };
        o = new function () {
            var a = this;
            function b(d, g) {
                for (var j = d[0].length, i = d.length, h = g[0].length, f = [], c = 0; c < i; c++)
                    for (var k = f[c] = [], b = 0; b < h; b++) {
                        for (var e = 0, a = 0; a < j; a++)
                            e += d[c][a] * g[a][b];
                        k[b] = e
                    }
                return f
            }
            a.Eb = function (d, c) {
                var a = b(d, [[c.x], [c.y]]);
                return y(a[0][0], a[1][0])
            }
        };
        d.ke = function (d, a, c) {
            var e = b.cos(d), f = b.sin(d);
            return[[e * a, -f * c], [f * a, e * c]]
        };
        d.ze = function (d, c, a) {
            var e = o.Eb(d, y(-c / 2, -a / 2)), f = o.Eb(d, y(c / 2, -a / 2)), g = o.Eb(d, y(c / 2, a / 2)), h = o.Eb(d, y(-c / 2, a / 2));
            return y(b.min(e.x, f.x, g.x, h.x) + c / 2, b.min(e.y, f.y, g.y, h.y) + a / 2)
        };
        d.ib = function (j, k, t, q, u, w, g) {
            var c = k;
            if (j) {
                c = {};
                for (var e in k) {
                    var x = w[e] || 1, r = u[e] || [0, 1], d = (t - r[0]) / r[1];
                    d = b.min(b.max(d, 0), 1);
                    d = d * x;
                    var o = b.floor(d);
                    if (d != o)
                        d -= o;
                    var v = q[e] || q.V, p = v(d), f, s = j[e], n = k[e];
                    if (a.Yb(n))
                        f = s + (n - s) * p;
                    else {
                        f = a.B({D: {}}, j[e]);
                        a.i(n.D, function (c, b) {
                            var a = c * p;
                            f.D[b] = a;
                            f[b] += a
                        })
                    }
                    c[e] = f
                }
                if (j.p)
                    c.ib = {v: c.v || 0, J: c.p, gb: g.gb, hb: g.hb}
            }
            if (k.c && g.Cb) {
                var i = c.c.D, m = (i.b || 0) + (i.q || 0), l = (i.a || 0) + (i.s || 0);
                c.a = (c.a || 0) + l;
                c.b = (c.b || 0) + m;
                c.c.a -= l;
                c.c.s -= l;
                c.c.b -= m;
                c.c.q -= m
            }
            if (c.c && a.Ge() && !c.c.b && !c.c.a && c.c.s == g.gb && c.c.q == g.hb)
                c.c = h;
            return c
        }
    }, n = function () {
        var b = this, d = [];
        function i(a, b) {
            d.push({lc: a, jc: b})
        }
        function h(b, c) {
            a.i(d, function (a, e) {
                a.lc == b && a.jc === c && d.splice(e, 1)
            })
        }
        b.pb = b.addEventListener = i;
        b.removeEventListener = h;
        b.o = function (b) {
            var c = [].slice.call(arguments, 1);
            a.i(d, function (a) {
                try {
                    a.lc == b && a.jc.apply(g, c)
                } catch (d) {
                }
            })
        }
    };
    m = function (n, z, j, R, P, L) {
        n = n || 0;
        var f = this, r, o, p, x, A = 0, I, J, H, C, E = 0, l = 0, u = 0, D, m = n, k, i, q, y = [], B;
        function M(a) {
            k += a;
            i += a;
            m += a;
            l += a;
            u += a;
            E = a
        }
        function Q(a, b) {
            var c = a - k + n * b;
            M(c);
            return i
        }
        function w(g, n) {
            var d = g;
            if (q && (d >= i || d <= k))
                d = ((d - k) % q + q) % q + k;
            if (!D || x || n || l != d) {
                var e = b.min(d, i);
                e = b.max(e, k);
                if (!D || x || n || e != u) {
                    if (L) {
                        var h = (e - m) / (z || 1);
                        if (j.kc)
                            h = 1 - h;
                        var o = a.ib(P, L, h, I, H, J, j);
                        a.i(o, function (b, a) {
                            B[a] && B[a](R, b)
                        })
                    }
                    f.nc(u - m, e - m)
                }
                u = e;
                a.i(y, function (b, c) {
                    var a = g < l ? y[y.length - c - 1] : b;
                    a.N(g - E, n)
                });
                var r = l, p = g;
                l = d;
                D = c;
                f.Nb(r, p)
            }
        }
        function F(a, c, d) {
            c && a.Lc(i, 1);
            !d && (i = b.max(i, a.sb() + E));
            y.push(a)
        }
        var s = g.requestAnimationFrame || g.webkitRequestAnimationFrame || g.mozRequestAnimationFrame || g.msRequestAnimationFrame;
        if (a.Dd() && a.P() < 7)
            s = h;
        s = s || function (b) {
            a.j(b, j.R)
        };
        function K() {
            if (r) {
                var d = a.U(), e = b.min(d - A, j.Oc), c = l + e * p;
                A = d;
                if (c * p >= o * p)
                    c = o;
                w(c);
                if (!x && c * p >= o * p)
                    N(C);
                else
                    s(K)
            }
        }
        function v(d, e, g) {
            if (!r) {
                r = c;
                x = g;
                C = e;
                d = b.max(d, k);
                d = b.min(d, i);
                o = d;
                p = o < l ? -1 : 1;
                f.Nc();
                A = a.U();
                s(K)
            }
        }
        function N(a) {
            if (r) {
                x = r = C = e;
                f.Gc();
                a && a()
            }
        }
        f.Ic = function (a, b, c) {
            v(a ? l + a : i, b, c)
        };
        f.Uc = v;
        f.Z = N;
        f.Xd = function (a) {
            v(a)
        };
        f.O = function () {
            return l
        };
        f.Tc = function () {
            return o
        };
        f.tb = function () {
            return u
        };
        f.N = w;
        f.Vc = function () {
            w(k, c)
        };
        f.Cb = function (a) {
            w(l + a)
        };
        f.yc = function () {
            return r
        };
        f.Me = function (a) {
            q = a
        };
        f.Lc = Q;
        f.dc = M;
        f.Qb = function (a) {
            F(a, 0)
        };
        f.Xb = function (a) {
            F(a, 1)
        };
        f.sb = function () {
            return i
        };
        f.Nb = f.Nc = f.Gc = f.nc = a.Fc;
        f.Vb = a.U();
        j = a.B({R: 16, Oc: 50}, j);
        q = j.Ac;
        B = a.B({}, a.ee(), j.Cc);
        k = m = n;
        i = n + z;
        J = j.k || {};
        H = j.l || {};
        I = a.B({V: a.Ec(j.e) && j.e || d.mc}, j.e)
    };
    var r, i = {}, s;
    new function () {
        var o = 0, k = 1, w = 2, t = 3, I = 1, H = 2, J = 4, G = 8, O = 256, P = 512, N = 1024, M = 2048, z = M + I, y = M + H, E = P + I, C = P + H, D = O + J, A = O + G, B = N + J, F = N + G;
        function S(a) {
            return(a & H) == H
        }
        function T(a) {
            return(a & J) == J
        }
        function x(b, a, c) {
            c.push(a);
            b[a] = b[a] || [];
            b[a].push(c)
        }
        i.Mb = function (e) {
            var m = e.f, n = e.g, r = e.t, l = e.Rb, q = [], p = [], i = 0, a = 0, b = 0, f = m - 1, g = n - 1, h, d, j = 0;
            switch (r) {
                case z:
                    a = f;
                    b = 0;
                    d = [w, k, t, o];
                    break;
                case B:
                    a = 0;
                    b = g;
                    d = [o, t, k, w];
                    break;
                case E:
                    a = f;
                    b = g;
                    d = [t, k, w, o];
                    break;
                case D:
                    a = f;
                    b = g;
                    d = [k, t, o, w];
                    break;
                case y:
                    a = 0;
                    b = 0;
                    d = [w, o, t, k];
                    break;
                case A:
                    a = f;
                    b = 0;
                    d = [k, w, o, t];
                    break;
                case C:
                    a = 0;
                    b = g;
                    d = [t, o, w, k];
                    break;
                default:
                    a = 0;
                    b = 0;
                    d = [o, w, k, t]
            }
            i = 0;
            while (i < l) {
                h = b + "," + a;
                if (a >= 0 && a < m && b >= 0 && b < n && !p[h]) {
                    p[h] = c;
                    x(q, i++, [b, a])
                } else
                    switch (d[j++ % d.length]) {
                        case o:
                            a--;
                            break;
                        case w:
                            b--;
                            break;
                        case k:
                            a++;
                            break;
                        case t:
                            b++
                    }
                switch (d[j % d.length]) {
                    case o:
                        a++;
                        break;
                    case w:
                        b++;
                        break;
                    case k:
                        a--;
                        break;
                    case t:
                        b--
                }
            }
            return q
        };
        i.Pb = function (d) {
            var l = d.f, m = d.g, p = d.t, j = d.Rb, h = [], i = 0, a = 0, b = 0, e = l - 1, f = m - 1, n, c, g = 0;
            switch (p) {
                case z:
                    a = e;
                    b = 0;
                    c = [w, k, t, k];
                    break;
                case B:
                    a = 0;
                    b = f;
                    c = [o, t, k, t];
                    break;
                case E:
                    a = e;
                    b = f;
                    c = [t, k, w, k];
                    break;
                case D:
                    a = e;
                    b = f;
                    c = [k, t, o, t];
                    break;
                case y:
                    a = 0;
                    b = 0;
                    c = [w, o, t, o];
                    break;
                case A:
                    a = e;
                    b = 0;
                    c = [k, w, o, w];
                    break;
                case C:
                    a = 0;
                    b = f;
                    c = [t, o, w, o];
                    break;
                default:
                    a = 0;
                    b = 0;
                    c = [o, w, k, w]
            }
            i = 0;
            while (i < j) {
                n = b + "," + a;
                if (a >= 0 && a < l && b >= 0 && b < m && typeof h[n] == "undefined") {
                    x(h, i++, [b, a]);
                    switch (c[g % c.length]) {
                        case o:
                            a++;
                            break;
                        case w:
                            b++;
                            break;
                        case k:
                            a--;
                            break;
                        case t:
                            b--
                    }
                } else {
                    switch (c[g++ % c.length]) {
                        case o:
                            a--;
                            break;
                        case w:
                            b--;
                            break;
                        case k:
                            a++;
                            break;
                        case t:
                            b++
                    }
                    switch (c[g++ % c.length]) {
                        case o:
                            a++;
                            break;
                        case w:
                            b++;
                            break;
                        case k:
                            a--;
                            break;
                        case t:
                            b--
                    }
                }
            }
            return h
        };
        i.qc = function (h) {
            var l = h.f, m = h.g, e = h.t, k = h.Rb, i = [], j = 0, c = 0, d = 0, f = l - 1, g = m - 1, o = k - 1;
            switch (e) {
                case z:
                case C:
                case E:
                case y:
                    var a = 0, b = 0;
                    break;
                case A:
                case B:
                case D:
                case F:
                    var a = f, b = 0;
                    break;
                default:
                    e = F;
                    var a = f, b = 0
            }
            c = a;
            d = b;
            while (j < k) {
                if (T(e) || S(e))
                    x(i, o - j++, [d, c]);
                else
                    x(i, j++, [d, c]);
                switch (e) {
                    case z:
                    case C:
                        c--;
                        d++;
                        break;
                    case E:
                    case y:
                        c++;
                        d--;
                        break;
                    case A:
                    case B:
                        c--;
                        d--;
                        break;
                    case F:
                    case D:
                    default:
                        c++;
                        d++
                }
                if (c < 0 || d < 0 || c > f || d > g) {
                    switch (e) {
                        case z:
                        case C:
                            a++;
                            break;
                        case A:
                        case B:
                        case E:
                        case y:
                            b++;
                            break;
                        case F:
                        case D:
                        default:
                            a--
                    }
                    if (a < 0 || b < 0 || a > f || b > g) {
                        switch (e) {
                            case z:
                            case C:
                                a = f;
                                b++;
                                break;
                            case E:
                            case y:
                                b = g;
                                a++;
                                break;
                            case A:
                            case B:
                                b = g;
                                a--;
                                break;
                            case F:
                            case D:
                            default:
                                a = 0;
                                b++
                        }
                        if (b > g)
                            b = g;
                        else if (b < 0)
                            b = 0;
                        else if (a > f)
                            a = f;
                        else if (a < 0)
                            a = 0
                    }
                    d = b;
                    c = a
                }
            }
            return i
        };
        i.uc = function (h) {
            var a = h.f || 1, c = h.g || 1, i = [], d, e, f, g, j;
            f = a < c ? (c - a) / 2 : 0;
            g = a > c ? (a - c) / 2 : 0;
            j = b.round(b.max(a / 2, c / 2)) + 1;
            for (d = 0; d < a; d++)
                for (e = 0; e < c; e++)
                    x(i, j - b.min(d + 1 + f, e + 1 + g, a - d + f, c - e + g), [e, d]);
            return i
        };
        i.Nd = function (d) {
            for (var e = [], a, c = 0; c < d.g; c++)
                for (a = 0; a < d.f; a++)
                    x(e, b.ceil(1e5 * b.random()) % 13, [c, a]);
            return e
        };
        function Q(a) {
            var b = a.r(a);
            return a.kc ? b.reverse() : b
        }
        function K(h, g) {
            var f = {R: g, m: 1, j: 0, f: 1, g: 1, F: 0, p: 0, c: 0, Cb: e, A: e, kc: e, r: i.Nd, t: F, ob: {yb: 0, zb: 0}, e: d.mc, k: {}, Kb: [], l: {}};
            a.B(f, h);
            f.Rb = f.f * f.g;
            if (a.Ec(f.e))
                f.e = {V: f.e};
            f.Mc = b.ceil(f.m / f.R);
            f.Hc = R(f);
            f.ud = function (b, a) {
                b /= f.f;
                a /= f.g;
                var e = b + "x" + a;
                if (!f.Kb[e]) {
                    f.Kb[e] = {bb: b, db: a};
                    for (var c = 0; c < f.f; c++)
                        for (var d = 0; d < f.g; d++)
                            f.Kb[e][d + "," + c] = {b: d * a, s: c * b + b, q: d * a + a, a: c * b}
                }
                return f.Kb[e]
            };
            if (f.Hb) {
                f.Hb = K(f.Hb, g);
                f.A = c
            }
            return f
        }
        function R(e) {
            var c = e.e;
            if (!c.V)
                c.V = d.mc;
            var f = e.Mc, g = c.nb;
            if (!g) {
                var h = a.B({}, e.e, e.k);
                g = c.nb = {};
                a.i(h, function (n, l) {
                    var d = c[l] || c.V, j = e.k[l] || 1;
                    if (!a.Ae(d.nb))
                        d.nb = [];
                    var h = d.nb[f] = d.nb[f] || [];
                    if (!h[j]) {
                        h[j] = [0];
                        for (var k = 1; k <= f; k++) {
                            var i = k / f * j, m = b.floor(i);
                            if (i != m)
                                i -= m;
                            h[j][k] = d(i)
                        }
                    }
                    g[l] = h
                })
            }
            return g
        }
        function L(C, i, d, x, n, k) {
            var A = this, u, v = {}, m = {}, l = [], g, f, s, p = d.ob.yb || 0, r = d.ob.zb || 0, h = d.ud(n, k), o = Q(d), D = o.length - 1, t = d.m + d.j * D, y = x + t, j = d.A, z;
            y += a.Fb() ? 260 : 50;
            A.Jc = y;
            A.Gb = function (c) {
                c -= x;
                var e = c < t;
                if (e || z) {
                    z = e;
                    if (!j)
                        c = t - c;
                    var f = b.ceil(c / d.R);
                    a.i(m, function (c, e) {
                        var d = b.max(f, c.Ed);
                        d = b.min(d, c.length - 1);
                        if (c.Wc != d) {
                            if (!c.Wc && !j)
                                a.S(l[e]);
                            else
                                d == c.ef && j && a.H(l[e]);
                            c.Wc = d;
                            a.ce(l[e], c[d])
                        }
                    })
                }
            };
            function w(b) {
                a.We(b);
                var c = a.fb(b);
                a.i(c, function (a) {
                    w(a)
                })
            }
            i = a.X(i);
            w(i);
            if (a.ab()) {
                var E = !i["no-image"], B = a.ue(i);
                a.i(B, function (b) {
                    (E || b["jssor-slider"]) && a.rb(b, a.rb(b), c)
                })
            }
            a.i(o, function (i, l) {
                a.i(i, function (K) {
                    var O = K[0], N = K[1], y = O + "," + N, t = e, w = e, z = e;
                    if (p && N % 2) {
                        if (q.Zc(p))
                            t = !t;
                        if (q.Xc(p))
                            w = !w;
                        if (p & 16)
                            z = !z
                    }
                    if (r && O % 2) {
                        if (q.Zc(r))
                            t = !t;
                        if (q.Xc(r))
                            w = !w;
                        if (r & 16)
                            z = !z
                    }
                    d.b = d.b || d.c & 4;
                    d.q = d.q || d.c & 8;
                    d.a = d.a || d.c & 1;
                    d.s = d.s || d.c & 2;
                    var F = w ? d.q : d.b, C = w ? d.b : d.q, E = t ? d.s : d.a, D = t ? d.a : d.s;
                    d.c = F || C || E || D;
                    s = {};
                    f = {b: 0, a: 0, F: 1, bb: n, db: k};
                    g = a.B({}, f);
                    u = a.B({}, h[y]);
                    if (d.F)
                        f.F = 2 - d.F;
                    if (d.cb) {
                        f.cb = d.cb;
                        g.cb = 0
                    }
                    var M = d.f * d.g > 1 || d.c;
                    if (d.p || d.v) {
                        var L = c;
                        if (a.Db() && a.Te() < 9)
                            if (d.f * d.g > 1)
                                L = e;
                            else
                                M = e;
                        if (L) {
                            f.p = d.p ? d.p - 1 : 1;
                            g.p = 1;
                            if (a.ab() || a.md())
                                f.p = b.min(f.p, 2);
                            var R = d.v;
                            f.v = R * 360 * (z ? -1 : 1);
                            g.v = 0
                        }
                    }
                    if (M) {
                        if (d.c) {
                            var x = d.df || 1, o = u.D = {};
                            if (F && C) {
                                o.b = h.db / 2 * x;
                                o.q = -o.b
                            } else if (F)
                                o.q = -h.db * x;
                            else if (C)
                                o.b = h.db * x;
                            if (E && D) {
                                o.a = h.bb / 2 * x;
                                o.s = -o.a
                            } else if (E)
                                o.s = -h.bb * x;
                            else if (D)
                                o.a = h.bb * x
                        }
                        s.c = u;
                        g.c = h[y]
                    }
                    var P = t ? 1 : -1, Q = w ? 1 : -1;
                    if (d.x)
                        f.a += n * d.x * P;
                    if (d.y)
                        f.b += k * d.y * Q;
                    a.i(f, function (b, c) {
                        if (a.Yb(b))
                            if (b != g[c])
                                s[c] = b - g[c]
                    });
                    v[y] = j ? g : f;
                    var J = b.round(l * d.j / d.R);
                    m[y] = new Array(J);
                    m[y].Ed = J;
                    for (var B = d.Mc, I = 0; I <= B; I++) {
                        var i = {};
                        a.i(s, function (f, c) {
                            var m = d.Hc[c] || d.Hc.V, l = m[d.k[c] || 1], k = d.l[c] || [0, 1], e = (I / B - k[0]) / k[1] * B;
                            e = b.round(b.min(B, b.max(e, 0)));
                            var j = l[e];
                            if (a.Yb(f))
                                i[c] = g[c] + f * j;
                            else {
                                var h = i[c] = a.B({}, g[c]);
                                h.D = [];
                                a.i(f.D, function (c, b) {
                                    var a = c * j;
                                    h.D[b] = a;
                                    h[b] += a
                                })
                            }
                        });
                        if (g.p)
                            i.ib = {v: i.v || 0, J: i.p, gb: n, hb: k};
                        if (i.c && d.Cb) {
                            var A = i.c.D, H = (A.b || 0) + (A.q || 0), G = (A.a || 0) + (A.s || 0);
                            i.a = (i.a || 0) + G;
                            i.b = (i.b || 0) + H;
                            i.c.a -= G;
                            i.c.s -= G;
                            i.c.b -= H;
                            i.c.q -= H
                        }
                        i.cb = i.cb || 1;
                        m[y].push(i)
                    }
                })
            });
            o.reverse();
            a.i(o, function (b) {
                a.i(b, function (c) {
                    var f = c[0], e = c[1], d = f + "," + e, b = i;
                    if (e || f)
                        b = a.X(i);
                    a.E(b, v[d]);
                    a.jb(b, "hidden");
                    a.I(b, "absolute");
                    C.Le(b);
                    l[d] = b;
                    a.S(b, !j)
                })
            })
        }
        s = function (g, k, i, l, p) {
            var d = this, o, e, c, s = 0, r = l.Ve, j, f = 8;
            function q() {
                var a = this, b = 0;
                m.call(a, 0, o);
                a.Nb = function (d, a) {
                    if (a - b > f) {
                        b = a;
                        c && c.Gb(a);
                        e && e.Gb(a)
                    }
                };
                a.Rc = j
            }
            d.Oe = function () {
                var a = 0, c = l.ec, d = c.length;
                if (r)
                    a = s++ % d;
                else
                    a = b.floor(b.random() * d);
                c[a] && (c[a].eb = a);
                return c[a]
            };
            d.me = function (w, x, n, p, a) {
                j = a;
                a = K(a, f);
                var m = p.pd, l = n.pd;
                m["no-image"] = !p.Zb;
                l["no-image"] = !n.Zb;
                var q = m, r = l, v = a, h = a.Hb || K({}, f);
                if (!a.A) {
                    q = l;
                    r = m
                }
                var s = h.dc || 0;
                e = new L(g, r, h, b.max(s - h.R, 0), k, i);
                c = new L(g, q, v, b.max(h.R - s, 0), k, i);
                e.Gb(0);
                c.Gb(0);
                o = b.max(e.Jc, c.Jc);
                d.eb = w
            };
            d.vb = function () {
                g.vb();
                e = h;
                c = h
            };
            d.he = function () {
                var a = h;
                if (c)
                    a = new q;
                return a
            };
            if (a.ab() || a.md() || p && a.ac() < 537)
                f = 16;
            n.call(d);
            m.call(d, -1e7, 1e7)
        };
        function j(o, lc) {
            var i = this;
            function Hc() {
                var a = this;
                m.call(a, -1e8, 2e8);
                a.ye = function () {
                    var c = a.tb(), d = b.floor(c), f = s(d), e = c - b.floor(c);
                    return{eb: f, De: d, qb: e}
                };
                a.Nb = function (d, a) {
                    var e = b.floor(a);
                    if (e != a && a > d)
                        e++;
                    Yb(e, c);
                    i.o(j.Be, s(a), s(d), a, d)
                }
            }
            function Gc() {
                var b = this;
                m.call(b, 0, 0, {Ac: r});
                a.i(D, function (a) {
                    H & 1 && a.Me(r);
                    b.Xb(a);
                    a.dc(mb / fc)
                })
            }
            function Fc() {
                var a = this, b = Xb.Lb;
                m.call(a, -1, 2, {e: d.Pd, Cc: {qb: dc}, Ac: r}, b, {qb: 1}, {qb: -1});
                a.Ub = b
            }
            function uc(o, n) {
                var a = this, d, f, g, l, b;
                m.call(a, -1e8, 2e8, {Oc: 100});
                a.Nc = function () {
                    S = c;
                    Y = h;
                    i.o(j.ve, s(y.O()), y.O())
                };
                a.Gc = function () {
                    S = e;
                    l = e;
                    var a = y.ye();
                    i.o(j.Ce, s(y.O()), y.O());
                    !a.qb && Jc(a.De, q)
                };
                a.Nb = function (h, e) {
                    var a;
                    if (l)
                        a = b;
                    else {
                        a = f;
                        if (g) {
                            var c = e / g;
                            a = k.je(c) * (f - d) + d
                        }
                    }
                    y.N(a)
                };
                a.Ab = function (b, e, c, h) {
                    d = b;
                    f = e;
                    g = c;
                    y.N(b);
                    a.N(0);
                    a.Uc(c, h)
                };
                a.ge = function (d) {
                    l = c;
                    b = d;
                    a.Ic(d, h, c)
                };
                a.He = function (a) {
                    b = a
                };
                y = new Hc;
                y.Qb(o);
                y.Qb(n)
            }
            function vc() {
                var c = this, b = cc();
                a.W(b, 0);
                a.lb(b, "pointerEvents", "none");
                c.Lb = b;
                c.Le = function (c) {
                    a.M(b, c);
                    a.S(b)
                };
                c.vb = function () {
                    a.H(b);
                    a.Bc(b)
                }
            }
            function Ec(p, o) {
                var d = this, v, x, I, y, g, A = [], G, u, S, H, P, F, f, w, l;
                m.call(d, -t, t + 1, {});
                function E(a) {
                    x && x.oc();
                    v && v.oc();
                    R(p, a);
                    F = c;
                    v = new J.L(p, J, 1);
                    x = new J.L(p, J);
                    x.Vc();
                    v.Vc()
                }
                function Z() {
                    v.Vb < J.Vb && E()
                }
                function K(o, q, n) {
                    if (!H) {
                        H = c;
                        if (g && n) {
                            var f = n.width, b = n.height, m = f, l = b;
                            if (f && b && k.wb) {
                                if (k.wb & 3 && (!(k.wb & 4) || f > M || b > L)) {
                                    var h = e, p = M / L * b / f;
                                    if (k.wb & 1)
                                        h = p > 1;
                                    else if (k.wb & 2)
                                        h = p < 1;
                                    m = h ? f * L / b : M;
                                    l = h ? L : b * M / f
                                }
                                a.C(g, m);
                                a.K(g, l);
                                a.kb(g, (L - l) / 2);
                                a.xb(g, (M - m) / 2)
                            }
                            a.I(g, "absolute");
                            i.o(j.pe, ic)
                        }
                    }
                    a.H(q);
                    o && o(d)
                }
                function W(b, c, e, f) {
                    if (f == Y && q == o && T)
                        if (!Ic) {
                            var a = s(b);
                            B.me(a, o, c, d, e);
                            c.re();
                            fb.Lc(a, 1);
                            fb.N(a);
                            z.Ab(b, b, 0)
                        }
                }
                function ab(b) {
                    if (b == Y && q == o) {
                        if (!f) {
                            var a = h;
                            if (B)
                                if (B.eb == o)
                                    a = B.he();
                                else
                                    B.vb();
                            Z();
                            f = new Cc(p, o, a, d.oe(), d.Qe());
                            f.od(l)
                        }
                        !f.yc() && f.Sb()
                    }
                }
                function Q(e, c, j) {
                    if (e == o) {
                        if (e != c)
                            D[c] && D[c].Bd();
                        else
                            !j && f && f.Jd();
                        l && l.Kc();
                        var m = Y = a.U();
                        d.mb(a.Jb(h, ab, m))
                    } else {
                        var i = b.abs(o - e), g = t + k.Kd;
                        (!P || i <= g || r - i <= g) && d.mb()
                    }
                }
                function bb() {
                    if (q == o && f) {
                        f.Z();
                        l && l.Fd();
                        l && l.Hd();
                        f.qd()
                    }
                }
                function cb() {
                    q == o && f && f.Z()
                }
                function O(b) {
                    if (V)
                        a.Q(b);
                    else
                        i.o(j.sd, o, b)
                }
                function N() {
                    l = w.pInstance;
                    f && f.od(l)
                }
                d.mb = function (d, b) {
                    b = b || y;
                    if (A.length && !H) {
                        a.S(b);
                        if (!S) {
                            S = c;
                            i.o(j.yd);
                            a.i(A, function (b) {
                                if (!b.src) {
                                    b.src = a.Y(b, "src2");
                                    a.T(b, b["display-origin"])
                                }
                            })
                        }
                        a.Ad(A, g, a.Jb(h, K, d, b))
                    } else
                        K(d, b)
                };
                d.xd = function () {
                    if (B) {
                        var b = B.Oe(r);
                        if (b) {
                            var e = Y = a.U(), c = o + bc, d = D[s(c)];
                            return d.mb(a.Jb(h, W, c, d, b, e), y)
                        }
                    }
                    gb(q + k.Zd * bc)
                };
                d.wc = function () {
                    Q(o, o, c)
                };
                d.Bd = function () {
                    l && l.Fd();
                    l && l.Hd();
                    d.fd();
                    f && f.be();
                    f = h;
                    E()
                };
                d.re = function () {
                    a.H(p)
                };
                d.fd = function () {
                    a.S(p)
                };
                d.Yd = function () {
                    l && l.Kc()
                };
                function R(b, f, d) {
                    if (b["jssor-slider"])
                        return;
                    d = d || 0;
                    if (!F) {
                        if (b.tagName == "IMG") {
                            A.push(b);
                            if (!b.src) {
                                P = c;
                                b["display-origin"] = a.T(b);
                                a.H(b)
                            }
                        }
                        a.ab() && a.W(b, (a.W(b) || 0) + 1);
                        if (k.hd && a.ac())
                            (!X || a.ac() < 534 || !kb && !a.Fb()) && a.qe(b)
                    }
                    var h = a.fb(b);
                    a.i(h, function (h) {
                        var j = a.Y(h, "u");
                        if (j == "player" && !w) {
                            w = h;
                            if (w.pInstance)
                                N();
                            else
                                a.u(w, "dataavailable", N)
                        }
                        if (j == "caption") {
                            if (!a.Db() && !f) {
                                var i = a.X(h, e, c);
                                a.hc(b, i, h);
                                a.Qc(b, h);
                                h = i;
                                f = c
                            }
                        } else if (!F && !d && !g) {
                            if (h.tagName == "A") {
                                if (a.Y(h, "u") == "image")
                                    g = a.te(h, "IMG");
                                else
                                    g = a.G(h, "image", c);
                                if (g) {
                                    G = h;
                                    a.E(G, U);
                                    u = a.X(G, c);
                                    a.u(u, "click", O);
                                    a.T(u, "block");
                                    a.E(u, U);
                                    a.rb(u, 0);
                                    a.lb(u, "backgroundColor", "#000")
                                }
                            } else if (h.tagName == "IMG" && a.Y(h, "u") == "image")
                                g = h;
                            if (g) {
                                g.border = 0;
                                a.E(g, U)
                            }
                        }
                        R(h, f, d + 1)
                    })
                }
                d.nc = function (c, b) {
                    var a = t - b;
                    dc(I, a)
                };
                d.oe = function () {
                    return v
                };
                d.Qe = function () {
                    return x
                };
                d.eb = o;
                n.call(d);
                var C = a.G(p, "thumb", c);
                if (C) {
                    a.X(C);
                    a.Pc(C, "id");
                    a.H(C)
                }
                a.S(p);
                y = a.X(jb);
                a.W(y, 1e3);
                a.u(p, "click", O);
                E(c);
                d.Zb = g;
                d.gd = u;
                d.pd = p;
                d.Ub = I = p;
                a.M(I, y);
                i.pb(203, Q);
                i.pb(28, cb);
                i.pb(24, bb)
            }
            function Cc(F, h, r, v, u) {
                var b = this, n = 0, x = 0, o, g, d, f, l, s, w, t, p = D[h];
                m.call(b, 0, 0);
                function y() {
                    a.Ie(P);
                    jc && l && p.gd && a.M(P, p.gd);
                    a.S(P, !l && p.Zb)
                }
                function z() {
                    if (s) {
                        s = e;
                        i.o(j.fe, h, d, n, g, d, f);
                        b.N(g)
                    }
                    b.Sb()
                }
                function A(a) {
                    t = a;
                    b.Z();
                    b.Sb()
                }
                b.Sb = function () {
                    var a = b.tb();
                    if (!C && !S && !t && q == h) {
                        if (!a) {
                            if (o && !l) {
                                l = c;
                                b.qd(c);
                                i.o(j.de, h, n, x, o, f)
                            }
                            y()
                        }
                        var e, m = j.bd;
                        if (a != f)
                            if (a == d)
                                e = f;
                            else if (a == g)
                                e = d;
                            else if (!a)
                                e = g;
                            else if (a > d) {
                                s = c;
                                e = d;
                                m = j.Md
                            } else
                                e = b.Tc();
                        i.o(m, h, a, n, g, d, f);
                        var k = T && (!K || G);
                        if (a == f)
                            (d != f && !(K & 12) || k) && p.xd();
                        else
                            (k || a != d) && b.Uc(e, z)
                    }
                };
                b.Jd = function () {
                    d == f && d == b.tb() && b.N(g)
                };
                b.be = function () {
                    B && B.eb == h && B.vb();
                    var a = b.tb();
                    a < f && i.o(j.bd, h, -a - 1, n, g, d, f)
                };
                b.qd = function (b) {
                    r && a.jb(ob, b && r.Rc.z ? "" : "hidden")
                };
                b.nc = function (b, a) {
                    if (l && a >= o) {
                        l = e;
                        y();
                        p.fd();
                        B.vb();
                        i.o(j.Od, h, n, x, o, f)
                    }
                    i.o(j.Ud, h, a, n, g, d, f)
                };
                b.od = function (a) {
                    if (a && !w) {
                        w = a;
                        a.pb($JssorPlayer$.Ue, A)
                    }
                };
                r && b.Xb(r);
                o = b.sb();
                b.sb();
                b.Xb(v);
                g = v.sb();
                d = g + (a.wd(a.Y(F, "idle")) || k.rd);
                u.dc(d);
                b.Qb(u);
                f = b.sb()
            }
            function dc(e, g) {
                var f = w > 0 ? w : nb, c = Fb * g * (f & 1), d = Gb * g * (f >> 1 & 1);
                if (a.Fb() && a.P() < 38) {
                    c = c.toFixed(3);
                    d = d.toFixed(3)
                } else {
                    c = b.round(c);
                    d = b.round(d)
                }
                if (a.Db() && a.P() >= 10 && a.P() < 11)
                    e.style.msTransform = "translate(" + c + "px, " + d + "px)";
                else if (a.Fb() && a.P() >= 30 && a.P() < 34) {
                    e.style.WebkitTransition = "transform 0s";
                    e.style.WebkitTransform = "translate3d(" + c + "px, " + d + "px, 0px) perspective(2000px)"
                } else {
                    a.xb(e, c);
                    a.kb(e, d)
                }
            }
            function Ac(c) {
                var b = a.ed(c).tagName;
                !N && b != "INPUT" && b != "TEXTAREA" && b != "SELECT" && yc() && zc(c)
            }
            function Tb() {
                vb = S;
                Pb = z.Tc();
                E = y.O()
            }
            function mc() {
                Tb();
                if (C || !G && K & 12) {
                    z.Z();
                    i.o(j.Vd)
                }
            }
            function kc(e) {
                e && Tb();
                if (!C && (G || !(K & 12)) && !z.yc()) {
                    var c = y.O(), a = b.ceil(E);
                    if (e && b.abs(F) >= k.nd) {
                        a = b.ceil(c);
                        a += lb
                    }
                    if (!(H & 1))
                        a = b.min(r - t, b.max(a, 0));
                    var d = b.abs(a - c);
                    d = 1 - b.pow(1 - d, 5);
                    if (!V && vb)
                        z.Xd(Pb);
                    else if (c == a) {
                        yb.Yd();
                        yb.wc()
                    } else
                        z.Ab(c, a, d * Zb)
                }
            }
            function zc(b) {
                C = c;
                Eb = e;
                Y = h;
                a.u(f, tb, gc);
                a.U();
                V = 0;
                mc();
                if (!vb)
                    w = 0;
                if (hb) {
                    var g = b.touches[0];
                    zb = g.clientX;
                    Ab = g.clientY
                } else {
                    var d = a.id(b);
                    zb = d.x;
                    Ab = d.y;
                    a.Q(b)
                }
                F = 0;
                ib = 0;
                lb = 0;
                i.o(j.Rd, s(E), E, b)
            }
            function gc(e) {
                if (C && (!a.ab() || e.button)) {
                    var f;
                    if (hb) {
                        var l = e.touches;
                        if (l && l.length > 0)
                            f = {x: l[0].clientX, y: l[0].clientY}
                    } else
                        f = a.id(e);
                    if (f) {
                        var j = f.x - zb, k = f.y - Ab;
                        if (b.floor(E) != E)
                            w = w || nb & N;
                        if ((j || k) && !w) {
                            if (N == 3)
                                if (b.abs(k) > b.abs(j))
                                    w = 2;
                                else
                                    w = 1;
                            else
                                w = N;
                            if (X && w == 1 && b.abs(k) - b.abs(j) > 3)
                                Eb = c
                        }
                        if (w) {
                            var d = k, i = Gb;
                            if (w == 1) {
                                d = j;
                                i = Fb
                            }
                            if (!(H & 1)) {
                                if (d > 0) {
                                    var g = i * q, h = d - g;
                                    if (h > 0)
                                        d = g + b.sqrt(h) * 5
                                }
                                if (d < 0) {
                                    var g = i * (r - t - q), h = -d - g;
                                    if (h > 0)
                                        d = -g - b.sqrt(h) * 5
                                }
                            }
                            if (F - ib < -2)
                                lb = 0;
                            else if (F - ib > 2)
                                lb = -1;
                            ib = F;
                            F = d;
                            xb = E - F / i / (eb || 1);
                            if (F && w && !Eb) {
                                a.Q(e);
                                if (!S)
                                    z.ge(xb);
                                else
                                    z.He(xb)
                            } else
                                a.ab() && a.Q(e)
                        }
                    }
                } else
                    Jb(e)
            }
            function Jb(d) {
                wc();
                if (C) {
                    C = e;
                    a.U();
                    a.Ib(f, tb, gc);
                    V = F;
                    V && a.Q(d);
                    z.Z();
                    var b = y.O();
                    i.o(j.Sd, s(b), b, s(E), E, d);
                    kc(c)
                }
            }
            function tc(a) {
                D[q];
                q = s(a);
                yb = D[q];
                Yb(a);
                return q
            }
            function Jc(a, b) {
                w = 0;
                tc(a);
                i.o(j.Td, s(a), b)
            }
            function Yb(b, c) {
                Cb = b;
                a.i(R, function (a) {
                    a.ic(s(b), b, c)
                })
            }
            function yc() {
                var b = j.jd || 0, a = Q;
                if (X)
                    a & 1 && (a &= 1);
                j.jd |= a;
                return N = a & ~b
            }
            function wc() {
                if (N) {
                    j.jd &= ~Q;
                    N = 0
                }
            }
            function cc() {
                var b = a.Bb();
                a.E(b, U);
                a.I(b, "absolute");
                return b
            }
            function s(a) {
                return(a % r + r) % r
            }
            function qc(a, c) {
                if (c)
                    if (!H) {
                        a = b.min(b.max(a + Cb, 0), r - t);
                        c = e
                    } else if (H & 2) {
                        a = s(a + Cb);
                        c = e
                    }
                gb(a, k.sc, c)
            }
            function Db() {
                a.i(R, function (a) {
                    a.pc(a.Ob.Xe <= G)
                })
            }
            function oc() {
                if (!G) {
                    G = 1;
                    Db();
                    if (!C) {
                        K & 12 && kc();
                        K & 3 && D[q].wc()
                    }
                }
            }
            function nc() {
                if (G) {
                    G = 0;
                    Db();
                    C || !(K & 12) || mc()
                }
            }
            function pc() {
                U = {bb: M, db: L, b: 0, a: 0};
                a.i(Z, function (b) {
                    a.E(b, U);
                    a.I(b, "absolute");
                    a.jb(b, "hidden");
                    a.H(b)
                });
                a.E(jb, U)
            }
            function rb(b, a) {
                gb(b, a, c)
            }
            function gb(g, f, j) {
                if (Vb && (!C || k.cd)) {
                    S = c;
                    C = e;
                    z.Z();
                    if (f == l)
                        f = Zb;
                    var d = Kb.tb(), a = g;
                    if (j) {
                        a = d + g;
                        if (g > 0)
                            a = b.ceil(a);
                        else
                            a = b.floor(a)
                    }
                    if (H & 2)
                        a = s(a);
                    if (!(H & 1))
                        a = b.max(0, b.min(a, r - t));
                    var i = (a - d) % r;
                    a = d + i;
                    var h = d == a ? 0 : f * b.abs(i);
                    h = b.min(h, f * t * 1.5);
                    z.Ab(d, a, h || 1)
                }
            }
            i.Wd = function () {
                rb(1)
            };
            i.Ic = function () {
                if (!T) {
                    T = c;
                    D[q] && D[q].wc()
                }
            };
            i.Je = function (b) {
                a.Tb(b);
                k.kd.ec = b
            };
            function db() {
                return a.C(x || o)
            }
            function pb() {
                return a.K(x || o)
            }
            i.gb = db;
            i.hb = pb;
            function Mb(c, d) {
                if (c == l)
                    return a.C(o);
                if (!x) {
                    var b = a.Bb(f);
                    a.Sc(b, a.Sc(o));
                    a.gc(b, a.gc(o));
                    a.T(b, "block");
                    a.I(b, "relative");
                    a.kb(b, 0);
                    a.xb(b, 0);
                    a.jb(b, "visible");
                    x = a.Bb(f);
                    a.I(x, "absolute");
                    a.kb(x, 0);
                    a.xb(x, 0);
                    a.C(x, a.C(o));
                    a.K(x, a.K(o));
                    a.we(x, "0 0");
                    a.M(x, b);
                    var j = a.fb(o);
                    a.M(o, x);
                    a.lb(o, "backgroundImage", "");
                    var i = {navigator: bb && bb.J == e, arrowleft: O && O.J == e, arrowright: O && O.J == e, thumbnavigator: I && I.J == e, thumbwrapper: I && I.J == e};
                    a.i(j, function (c) {
                        a.M(i[a.Y(c, "u")] ? o : b, c)
                    })
                }
                eb = c / (d ? a.K : a.C)(x);
                a.le(x, eb);
                var h = d ? eb * db() : c, g = d ? c : eb * pb();
                a.C(o, h);
                a.K(o, g);
                a.i(R, function (a) {
                    a.fc(h, g)
                })
            }
            n.call(i);
            i.Lb = o = a.ub(o);
            var k = a.B({wb: 0, Kd: 1, vc: 0, rc: e, xe: 1, hd: c, cd: c, Zd: 1, rd: 3e3, Wb: 1, sc: 500, je: d.n, nd: 20, zc: 0, Dc: 1, ne: 0, Re: 1, bc: 1, cc: 1}, lc), nb = k.bc & 3, bc = (k.bc & 4) / -4 || 1, cb = k.kd, J = a.B({L: v}, k.Ye);
            a.Tb(J.Fe);
            var bb = k.Ze, O = k.bf, I = k.af, W = !k.Re, x, A = a.G(o, "slides", W), jb = a.G(o, "loading", W) || a.Bb(f), Ob = a.G(o, "navigator", W), hc = a.G(o, "arrowleft", W), ec = a.G(o, "arrowright", W), Nb = a.G(o, "thumbnavigator", W), sc = a.C(A), rc = a.K(A), U, Z = [], Bc = a.fb(A);
            a.i(Bc, function (b) {
                b.tagName == "DIV" && !a.Y(b, "u") && Z.push(b)
            });
            var q = -1, Cb, yb, r = Z.length, M = k.Id || sc, L = k.td || rc, ac = k.zc, Fb = M + ac, Gb = L + ac, fc = nb & 1 ? Fb : Gb, t = b.min(k.Dc, r), ob, w, N, Eb, hb, X, R = [], Ub, Wb, Sb, jc, Ic, T, K = k.Wb, Zb = k.sc, wb, kb, mb, Vb = t < r, H = Vb ? k.xe : 0, Q, V, G = 1, S, C, Y, zb = 0, Ab = 0, F, ib, lb, Kb, y, fb, z, Xb = new vc, eb;
            T = k.rc;
            i.Ob = lc;
            pc();
            o["jssor-slider"] = c;
            a.W(A, a.W(A) || 0);
            a.I(A, "absolute");
            ob = a.X(A, c);
            a.hc(a.Pe(A), ob, A);
            if (cb) {
                jc = cb.Ld;
                wb = cb.L;
                a.Tb(cb.ec);
                kb = t == 1 && r > 1 && wb && (!a.Db() || a.P() >= 8)
            }
            mb = kb || t >= r || !(H & 1) ? 0 : k.ne;
            Q = (t > 1 || mb ? nb : -1) & k.cc;
            var Bb = A, D = [], B, P, Ib = "mousedown", tb = "mousemove", Lb = "mouseup", sb, E, vb, Pb, xb, ab;
            if (g.navigator.pointerEnabled || (ab = g.navigator.msPointerEnabled)) {
                X = c;
                Ib = ab ? "MSPointerDown" : "pointerdown";
                tb = ab ? "MSPointerMove" : "pointermove";
                Lb = ab ? "MSPointerUp" : "pointerup";
                sb = ab ? "MSPointerCancel" : "pointercancel";
                if (Q) {
                    var Hb = "auto";
                    if (Q == 2)
                        Hb = "pan-x";
                    else if (Q)
                        Hb = "pan-y";
                    a.lb(Bb, ab ? "msTouchAction" : "touchAction", Hb)
                }
            } else if ("ontouchstart"in g || "createTouch"in f) {
                hb = c;
                X = c;
                Ib = "touchstart";
                tb = "touchmove";
                Lb = "touchend";
                sb = "touchcancel"
            }
            fb = new Fc;
            if (kb)
                B = new wb(Xb, M, L, cb, hb);
            a.M(ob, fb.Ub);
            a.jb(A, "hidden");
            P = cc();
            a.lb(P, "backgroundColor", "#000");
            a.rb(P, 0);
            a.hc(Bb, P, Bb.firstChild);
            for (var ub = 0; ub < Z.length; ub++) {
                var Dc = Z[ub], ic = new Ec(Dc, ub);
                D.push(ic)
            }
            a.H(jb);
            Kb = new Gc;
            z = new uc(Kb, fb);
            if (Q) {
                a.u(A, Ib, Ac);
                a.u(f, Lb, Jb);
                sb && a.u(f, sb, Jb)
            }
            K &= X ? 10 : 5;
            if (Ob && bb) {
                Ub = new bb.L(Ob, bb, db(), pb());
                R.push(Ub)
            }
            if (O && hc && ec) {
                Wb = new O.L(hc, ec, O, db(), pb());
                R.push(Wb)
            }
            if (Nb && I) {
                I.vc = k.vc;
                Sb = new I.L(Nb, I);
                R.push(Sb)
            }
            a.i(R, function (a) {
                a.tc(r, D, jb);
                a.pb(p.ae, qc)
            });
            Mb(db());
            a.u(o, "mouseout", a.ld(oc, o));
            a.u(o, "mouseover", a.ld(nc, o));
            Db();
            k.cf && a.u(f, "keydown", function (a) {
                if (a.keyCode == u.vd)
                    rb(-1);
                else
                    a.keyCode == u.Qd && rb(1)
            });
            var qb = k.vc;
            if (!(H & 1))
                qb = b.max(0, b.min(qb, r - t));
            z.Ab(qb, qb, 0)
        }
        j.sd = 21;
        j.Rd = 22;
        j.Sd = 23;
        j.ve = 24;
        j.Ce = 25;
        j.yd = 26;
        j.pe = 27;
        j.Vd = 28;
        j.Be = 202;
        j.Td = 203;
        j.de = 206;
        j.Od = 207;
        j.Ud = 208;
        j.bd = 209;
        j.Md = 210;
        j.fe = 211;
        r = j
    };
    var p = {ae: 1};
    function v() {
        m.call(this, 0, 0);
        this.oc = a.Fc
    }
    var j = {}, k = {}, t = [];
    j["Swing Outside in Stairs"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, r: i.qc, t: 260, e: {a: d.d, b: d.d, c: d.n}, z: c, k: {a: 1.3, b: 2.5}};
    k["Swing Outside in Stairs"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Outside in ZigZag"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, r: i.Pb, t: 260, e: {a: d.d, b: d.d, c: d.n}, z: c, k: {a: 1.3, b: 2.5}};
    k["Swing Outside in ZigZag"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationZigZag,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Outside in Swirl"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, r: i.Mb, t: 260, e: {a: d.d, b: d.d, c: d.n}, z: c, k: {a: 1.3, b: 2.5}};
    k["Swing Outside in Swirl"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationSwirl,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Outside in Random"] = {m: 1200, x: .2, y: -.1, j: 80, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, e: {a: d.d, b: d.d, c: d.n}, z: c, k: {a: 1.3, b: 2.5}};
    k["Swing Outside in Random"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:80,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Outside in Random Chess"] = {m: 1200, x: .2, y: -.1, j: 80, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, ob: {yb: 3, zb: 3}, e: {a: d.d, b: d.d, c: d.n}, z: c, k: {a: 1.3, b: 2.5}};
    k["Swing Outside in Random Chess"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:80,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:3},$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Outside in Square"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, r: i.uc, e: {a: d.d, b: d.d, c: d.n}, z: c, k: {a: 1.3, b: 2.5}};
    k["Swing Outside in Square"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationSquare,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Outside out Stairs"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, A: c, r: i.qc, t: 260, e: {a: d.d, b: d.d, c: d.n}, z: c, k: {a: 1.3, b: 2.5}};
    k["Swing Outside out Stairs"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Outside out ZigZag"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, A: c, r: i.Pb, t: 260, e: {a: d.d, b: d.d, c: d.n}, z: c, k: {a: 1.3, b: 2.5}};
    k["Swing Outside out ZigZag"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationZigZag,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Outside out Swirl"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, A: c, r: i.Mb, t: 260, e: {a: d.d, b: d.d, c: d.n}, z: c, k: {a: 1.3, b: 2.5}};
    k["Swing Outside out Swirl"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationSwirl,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Outside out Random"] = {m: 1200, x: .2, y: -.1, j: 80, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, A: c, e: {a: d.d, b: d.d, c: d.n}, z: c, k: {a: 1.3, b: 2.5}};
    k["Swing Outside out Random"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:80,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Outside out Random Chess"] = {m: 1200, x: .2, y: -.1, j: 80, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, A: c, ob: {yb: 3, zb: 3}, e: {a: d.d, b: d.d, c: d.n}, z: c, k: {a: 1.3, b: 2.5}};
    k["Swing Outside out Random Chess"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:80,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$ChessMode:{$Column:3,$Row:3},$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Outside out Square"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, A: c, r: i.uc, e: {a: d.d, b: d.d, c: d.n}, z: c, k: {a: 1.3, b: 2.5}};
    k["Swing Outside out Square"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationSquare,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Outside:true,$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Inside in Stairs"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, r: i.qc, t: 260, e: {a: d.d, b: d.d, c: d.n}, k: {a: 1.3, b: 2.5}};
    k["Swing Inside in Stairs"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationStraightStairs,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Inside in ZigZag"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, r: i.Pb, t: 260, e: {a: d.d, b: d.d, c: d.n}, k: {a: 1.3, b: 2.5}};
    k["Swing Inside in ZigZag"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationZigZag,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Inside in Swirl"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, r: i.Mb, t: 260, e: {a: d.d, b: d.d, c: d.n}, k: {a: 1.3, b: 2.5}};
    k["Swing Inside in Swirl"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationSwirl,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Inside in Random"] = {m: 1200, x: .2, y: -.1, j: 80, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, e: {a: d.d, b: d.d, c: d.n}, k: {a: 1.3, b: 2.5}};
    k["Swing Inside in Random"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:80,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Inside in Random Chess"] = {m: 1200, x: .2, y: -.1, j: 80, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, ob: {yb: 3, zb: 3}, e: {a: d.d, b: d.d, c: d.n}, k: {a: 1.3, b: 2.5}};
    k["Swing Inside in Random Chess"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:80,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:3},$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Inside in Square"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, r: i.uc, e: {a: d.d, b: d.d, c: d.n}, k: {a: 1.3, b: 2.5}};
    k["Swing Inside in Square"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$Formation:$JssorSlideshowFormations$.$FormationSquare,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Inside out ZigZag"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, A: c, r: i.Pb, t: 260, e: {a: d.d, b: d.d, c: d.n}, k: {a: 1.3, b: 2.5}};
    k["Swing Inside out ZigZag"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationZigZag,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Round:{$Left:1.3,$Top:2.5}}";
    j["Swing Inside out Swirl"] = {m: 1200, x: .2, y: -.1, j: 20, f: 8, g: 4, c: 15, l: {a: [.3, .7], b: [.3, .7]}, A: c, r: i.Mb, t: 260, e: {a: d.d, b: d.d, c: d.n}, k: {a: 1.3, b: 2.5}};
    k["Swing Inside out Swirl"] = "{$Duration:1200,x:0.2,y:-0.1,$Delay:20,$Cols:8,$Rows:4,$Clip:15,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationSwirl,$Assembly:260,$Easing:{$Left:$JssorEasing$.$EaseInWave,$Top:$JssorEasing$.$EaseInWave,$Clip:$JssorEasing$.$EaseOutQuad},$Round:{$Left:1.3,$Top:2.5}}";
    a.i(j, function (a) {
        t.push(a)
    });
    jssor_slider1_starter = function (e) {
        var d = new r(e, {rc: c, rd: 1e3, cc: 3, Wb: 1, kd: {L: s, ec: t, Ve: 1, Ld: c}});
        PlaySlideshowTransition = function (b) {
            a.xc(b);
            a.Q(b);
            try {
                var f = a.ed(b), e = a.ie(f);
                d.Wd();
                d.Je([j[e]]);
                var g = k[e], c = a.ub("stTransition");
                if (c)
                    c.value = g
            } catch (h) {
            }
        };
    };
})(window, document, Math, null, true, false);