  !(function (t, e) {
    'object' == typeof exports && 'object' == typeof module
      ? (module.exports = e())
      : 'function' == typeof define && define.amd
      ? define([], e)
      : 'object' == typeof exports
      ? (exports.Pickr = e())
      : (t.Pickr = e());
  })(window, function () {
    return (function (t) {
      var e = {};
      function n(o) {
        if (e[o]) return e[o].exports;
        var r = (e[o] = { i: o, l: !1, exports: {} });
        return t[o].call(r.exports, r, r.exports, n), (r.l = !0), r.exports;
      }
      return (
        (n.m = t),
        (n.c = e),
        (n.d = function (t, e, o) {
          n.o(t, e) || Object.defineProperty(t, e, { enumerable: !0, get: o });
        }),
        (n.r = function (t) {
          'undefined' != typeof Symbol &&
            Symbol.toStringTag &&
            Object.defineProperty(t, Symbol.toStringTag, { value: 'Module' }),
            Object.defineProperty(t, '__esModule', { value: !0 });
        }),
        (n.t = function (t, e) {
          if ((1 & e && (t = n(t)), 8 & e)) return t;
          if (4 & e && 'object' == typeof t && t && t.__esModule) return t;
          var o = Object.create(null);
          if (
            (n.r(o),
            Object.defineProperty(o, 'default', { enumerable: !0, value: t }),
            2 & e && 'string' != typeof t)
          )
            for (var r in t)
              n.d(
                o,
                r,
                function (e) {
                  return t[e];
                }.bind(null, r)
              );
          return o;
        }),
        (n.n = function (t) {
          var e =
            t && t.__esModule
              ? function () {
                  return t.default;
                }
              : function () {
                  return t;
                };
          return n.d(e, 'a', e), e;
        }),
        (n.o = function (t, e) {
          return Object.prototype.hasOwnProperty.call(t, e);
        }),
        (n.p = 'dist/'),
        n((n.s = 1))
      );
    })([
      function (t, e, n) {},
      function (t, e, n) {
        'use strict';
        n.r(e);
        var o = {};
        n.r(o),
          n.d(o, 'once', function () {
            return i;
          }),
          n.d(o, 'on', function () {
            return a;
          }),
          n.d(o, 'off', function () {
            return c;
          }),
          n.d(o, 'createElementFromString', function () {
            return u;
          }),
          n.d(o, 'removeAttribute', function () {
            return l;
          }),
          n.d(o, 'createFromTemplate', function () {
            return p;
          }),
          n.d(o, 'eventPath', function () {
            return d;
          }),
          n.d(o, 'adjustableInputNumbers', function () {
            return h;
          });
        var r = {};
        n.r(r),
          n.d(r, 'hsvToRgb', function () {
            return m;
          }),
          n.d(r, 'hsvToHex', function () {
            return b;
          }),
          n.d(r, 'hsvToCmyk', function () {
            return _;
          }),
          n.d(r, 'hsvToHsl', function () {
            return w;
          }),
          n.d(r, 'parseToHSV', function () {
            return A;
          }),
          n(0);
        var i = function (t, e, n, o) {
            return a(
              t,
              e,
              function t() {
                n.apply(this, arguments), this.removeEventListener(e, t);
              },
              o
            );
          },
          a = s.bind(null, 'addEventListener'),
          c = s.bind(null, 'removeEventListener');
        function s(t, e, n, o) {
          var r = 4 < arguments.length && void 0 !== arguments[4] ? arguments[4] : {};
          return (
            e instanceof HTMLCollection || e instanceof NodeList
              ? (e = Array.from(e))
              : Array.isArray(e) || (e = [e]),
            Array.isArray(n) || (n = [n]),
            e.forEach(function (e) {
              return n.forEach(function (n) {
                return e[t](
                  n,
                  o,
                  (function (t) {
                    for (var e = 1; e < arguments.length; e++) {
                      var n = null != arguments[e] ? arguments[e] : {},
                        o = Object.keys(n);
                      'function' == typeof Object.getOwnPropertySymbols &&
                        (o = o.concat(
                          Object.getOwnPropertySymbols(n).filter(function (t) {
                            return Object.getOwnPropertyDescriptor(n, t).enumerable;
                          })
                        )),
                        o.forEach(function (e) {
                          var o, r, i;
                          (o = t),
                            (i = n[(r = e)]),
                            r in o
                              ? Object.defineProperty(o, r, {
                                  value: i,
                                  enumerable: !0,
                                  configurable: !0,
                                  writable: !0,
                                })
                              : (o[r] = i);
                        });
                    }
                    return t;
                  })({ capture: !1 }, r)
                );
              });
            }),
            Array.prototype.slice.call(arguments, 1)
          );
        }
        function u(t) {
          var e = document.createElement('div');
          return (e.innerHTML = t.trim()), e.firstElementChild;
        }
        function l(t, e) {
          var n = t.getAttribute(e);
          return t.removeAttribute(e), n;
        }
        function p(t) {
          return (function t(e) {
            var n = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : {},
              o = l(e, 'data-con'),
              r = l(e, 'data-key');
            r && (n[r] = e);
            for (
              var i = Array.from(e.children), a = o ? (n[o] = {}) : n, c = 0;
              c < i.length;
              c++
            ) {
              var s = i[c],
                u = l(s, 'data-arr');
              u ? (a[u] || (a[u] = [])).push(s) : t(s, a);
            }
            return n;
          })(u(t));
        }
        function d(t) {
          var e = t.path || (t.composedPath && t.composedPath());
          if (e) return e;
          var n = t.target.parentElement;
          for (e = [t.target, n]; (n = n.parentElement); ) e.push(n);
          return e.push(document, window), e;
        }
        function h(t) {
          var e = !(1 < arguments.length && void 0 !== arguments[1]) || arguments[1],
            n = function (t) {
              return ('0' <= t && t <= '9') || '-' === t || '.' === t;
            };
          function o(o) {
            for (
              var r = t.value, i = t.selectionStart, a = i, c = '', s = i - 1;
              0 < s && n(r[s]);
              s--
            )
              (c = r[s] + c), a--;
            for (var u = i, l = r.length; u < l && n(r[u]); u++) c += r[u];
            if (0 < c.length && !isNaN(c) && isFinite(c)) {
              var p = o.deltaY < 0 ? 1 : -1,
                d = o.ctrlKey ? 5 * p : p,
                h = Number(c) + d;
              !e && h < 0 && (h = 0);
              var f = r.substr(0, a) + h + r.substring(a + c.length, r.length),
                v = a + String(h).length;
              (t.value = f), t.focus(), t.setSelectionRange(v, v);
            }
            o.preventDefault(), t.dispatchEvent(new Event('input'));
          }
          a(t, 'focus', function () {
            return a(window, 'wheel', o);
          }),
            a(t, 'blur', function () {
              return c(window, 'wheel', o);
            });
        }
        function f(t, e) {
          return (
            (function (t) {
              if (Array.isArray(t)) return t;
            })(t) ||
            (function (t, e) {
              var n = [],
                o = !0,
                r = !1,
                i = void 0;
              try {
                for (
                  var a, c = t[Symbol.iterator]();
                  !(o = (a = c.next()).done) && (n.push(a.value), !e || n.length !== e);
                  o = !0
                );
              } catch (t) {
                (r = !0), (i = t);
              } finally {
                try {
                  o || null == c.return || c.return();
                } finally {
                  if (r) throw i;
                }
              }
              return n;
            })(t, e) ||
            (function () {
              throw new TypeError('Invalid attempt to destructure non-iterable instance');
            })()
          );
        }
        function v(t) {
          return (
            (function (t) {
              if (Array.isArray(t)) {
                for (var e = 0, n = new Array(t.length); e < t.length; e++) n[e] = t[e];
                return n;
              }
            })(t) ||
            (function (t) {
              if (
                Symbol.iterator in Object(t) ||
                '[object Arguments]' === Object.prototype.toString.call(t)
              )
                return Array.from(t);
            })(t) ||
            (function () {
              throw new TypeError('Invalid attempt to spread non-iterable instance');
            })()
          );
        }
        var y = Math.min,
          g = Math.max;
        function m(t, e, n) {
          (t = (t / 360) * 6), (e /= 100), (n /= 100);
          var o = Math.floor(t),
            r = t - o,
            i = n * (1 - e),
            a = n * (1 - r * e),
            c = n * (1 - (1 - r) * e),
            s = o % 6;
          return [
            255 * [n, a, i, i, c, n][s],
            255 * [c, n, n, a, i, i][s],
            255 * [i, i, c, n, n, a][s],
          ];
        }
        function b(t, e, n) {
          return m(t, e, n).map(function (t) {
            return Math.round(t).toString(16).padStart(2, '0');
          });
        }
        function _(t, e, n) {
          var o,
            r = m(t, e, n),
            i = r[0] / 255,
            a = r[1] / 255,
            c = r[2] / 255;
          return [
            100 * (1 === (o = y(1 - i, 1 - a, 1 - c)) ? 0 : (1 - i - o) / (1 - o)),
            100 * (1 === o ? 0 : (1 - a - o) / (1 - o)),
            100 * (1 === o ? 0 : (1 - c - o) / (1 - o)),
            100 * o,
          ];
        }
        function w(t, e, n) {
          var o = ((2 - (e /= 100)) * (n /= 100)) / 2;
          return (
            0 !== o && (e = 1 === o ? 0 : o < 0.5 ? (e * n) / (2 * o) : (e * n) / (2 - 2 * o)),
            [t, 100 * e, 100 * o]
          );
        }
        function k(t, e, n) {
          var o,
            r,
            i,
            a = y((t /= 255), (e /= 255), (n /= 255)),
            c = g(t, e, n),
            s = c - a;
          if (((i = c), 0 === s)) o = r = 0;
          else {
            r = s / c;
            var u = ((c - t) / 6 + s / 2) / s,
              l = ((c - e) / 6 + s / 2) / s,
              p = ((c - n) / 6 + s / 2) / s;
            t === c ? (o = p - l) : e === c ? (o = 1 / 3 + u - p) : n === c && (o = 2 / 3 + l - u),
              o < 0 ? (o += 1) : 1 < o && (o -= 1);
          }
          return [360 * o, 100 * r, 100 * i];
        }
        function A(t) {
          var e,
            n,
            o,
            r,
            i,
            a,
            c,
            s,
            u,
            l = {
              cmyk: /^cmyk[\D]+(\d+)[\D]+(\d+)[\D]+(\d+)[\D]+(\d+)/i,
              rgba: /^(rgb|rgba)[\D]+(\d+)[\D]+(\d+)[\D]+(\d+)[\D]*?([\d.]+|$)/i,
              hsla: /^(hsl|hsla)[\D]+(\d+)[\D]+(\d+)[\D]+(\d+)[\D]*?([\d.]+|$)/i,
              hsva: /^(hsv|hsva)[\D]+(\d+)[\D]+(\d+)[\D]+(\d+)[\D]*?([\d.]+|$)/i,
              hex: /^#?(([\dA-Fa-f]{3,4})|([\dA-Fa-f]{6})|([\dA-Fa-f]{8}))$/i,
            },
            p = function (t) {
              return t.map(function (t) {
                return /^(|\d+)\.\d+|\d+$/.test(t) ? Number(t) : void 0;
              });
            };
          for (var d in l)
            if ((e = l[d].exec(t)))
              switch (d) {
                case 'cmyk':
                  var h = f(p(e), 5),
                    g = h[1],
                    m = h[2],
                    b = h[3],
                    _ = h[4];
                  return 100 < g || 100 < m || 100 < b || 100 < _
                    ? null
                    : v(
                        ((a = g),
                        (c = m),
                        (s = b),
                        (u = _),
                        (c /= 100),
                        (s /= 100),
                        v(
                          k(
                            255 * (1 - y(1, (a /= 100) * (1 - (u /= 100)) + u)),
                            255 * (1 - y(1, c * (1 - u) + u)),
                            255 * (1 - y(1, s * (1 - u) + u))
                          )
                        ))
                      ).concat([1]);
                case 'rgba':
                  var w = f(p(e), 6),
                    A = w[2],
                    C = w[3],
                    S = w[4],
                    O = w[5],
                    j = void 0 === O ? 1 : O;
                  return 255 < A || 255 < C || 255 < S || j < 0 || 1 < j
                    ? null
                    : v(k(A, C, S)).concat([j]);
                case 'hex':
                  var x = function (t, e) {
                      return [t.substring(0, e), t.substring(e, t.length)];
                    },
                    E = f(e, 2)[1];
                  3 === E.length ? (E += 'F') : 6 === E.length && (E += 'FF');
                  var H = void 0;
                  if (4 === E.length) {
                    var R = f(
                      x(E, 3).map(function (t) {
                        return t + t;
                      }),
                      2
                    );
                    (E = R[0]), (H = R[1]);
                  } else if (8 === E.length) {
                    var B = f(x(E, 6), 2);
                    (E = B[0]), (H = B[1]);
                  }
                  return (
                    (H = parseInt(H, 16) / 255),
                    v(
                      ((i = E),
                      k.apply(
                        void 0,
                        v(
                          i.match(/.{2}/g).map(function (t) {
                            return parseInt(t, 16);
                          })
                        )
                      ))
                    ).concat([H])
                  );
                case 'hsla':
                  var P = f(p(e), 6),
                    L = P[2],
                    D = P[3],
                    T = P[4],
                    F = P[5],
                    M = void 0 === F ? 1 : F;
                  return 360 < L || 100 < D || 100 < T || M < 0 || 1 < M
                    ? null
                    : v(
                        ((n = L),
                        (o = D),
                        (r = T),
                        (o /= 100),
                        [
                          n,
                          ((2 * (o *= (r /= 100) < 0.5 ? r : 1 - r)) / (r + o)) * 100,
                          100 * (r + o),
                        ])
                      ).concat([M]);
                case 'hsva':
                  var N = f(p(e), 6),
                    X = N[2],
                    I = N[3],
                    V = N[4],
                    Y = N[5],
                    z = void 0 === Y ? 1 : Y;
                  return 360 < X || 100 < I || 100 < V || z < 0 || 1 < z ? null : [X, I, V, z];
              }
          return null;
        }
        function C() {
          var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0,
            e = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 0,
            n = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0,
            o = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : 1,
            i = Math.ceil,
            a = {
              h: t,
              s: e,
              v: n,
              a: o,
              toHSVA: function () {
                var t = [a.h, a.s, a.v],
                  e = t.map(i);
                return (
                  (t.toString = function () {
                    return 'hsva('
                      .concat(e[0], ', ')
                      .concat(e[1], '%, ')
                      .concat(e[2], '%, ')
                      .concat(a.a.toFixed(1), ')');
                  }),
                  t
                );
              },
              toHSLA: function () {
                var t = w(a.h, a.s, a.v),
                  e = t.map(i);
                return (
                  (t.toString = function () {
                    return 'hsla('
                      .concat(e[0], ', ')
                      .concat(e[1], '%, ')
                      .concat(e[2], '%, ')
                      .concat(a.a.toFixed(1), ')');
                  }),
                  t
                );
              },
              toRGBA: function () {
                var t = m(a.h, a.s, a.v),
                  e = t.map(i);
                return (
                  (t.toString = function () {
                    return 'rgba('
                      .concat(e[0], ', ')
                      .concat(e[1], ', ')
                      .concat(e[2], ', ')
                      .concat(a.a.toFixed(1), ')');
                  }),
                  t
                );
              },
              toCMYK: function () {
                var t = _(a.h, a.s, a.v),
                  e = t.map(i);
                return (
                  (t.toString = function () {
                    return 'cmyk('
                      .concat(e[0], '%, ')
                      .concat(e[1], '%, ')
                      .concat(e[2], '%, ')
                      .concat(e[3], '%)');
                  }),
                  t
                );
              },
              toHEX: function () {
                var t = b.apply(r, [a.h, a.s, a.v]);
                return (
                  (t.toString = function () {
                    var e =
                      1 <= a.a
                        ? ''
                        : Number((255 * a.a).toFixed(0))
                            .toString(16)
                            .toUpperCase()
                            .padStart(2, '0');
                    return '#'.concat(t.join('').toUpperCase() + e);
                  }),
                  t
                );
              },
              clone: function () {
                return C(a.h, a.s, a.v, a.a);
              },
            };
          return a;
        }
        function S(t) {
          var e = {
            options: Object.assign(
              {
                lockX: !1,
                lockY: !1,
                onchange: function () {
                  return 0;
                },
              },
              t
            ),
            _tapstart: function (t) {
              a(document, ['mouseup', 'touchend', 'touchcancel'], e._tapstop),
                a(document, ['mousemove', 'touchmove'], e._tapmove),
                t.preventDefault(),
                (e.wrapperRect = e.options.wrapper.getBoundingClientRect()),
                e._tapmove(t);
            },
            _tapmove: function (t) {
              var n = e.options,
                o = e.cache,
                r = n.element,
                i = e.wrapperRect,
                a = 0,
                c = 0;
              if (t) {
                var s = t && t.touches && t.touches[0];
                (a = t ? (s || t).clientX : 0),
                  (c = t ? (s || t).clientY : 0),
                  a < i.left ? (a = i.left) : a > i.left + i.width && (a = i.left + i.width),
                  c < i.top ? (c = i.top) : c > i.top + i.height && (c = i.top + i.height),
                  (a -= i.left),
                  (c -= i.top);
              } else o && ((a = o.x), (c = o.y));
              n.lockX || (r.style.left = a - r.offsetWidth / 2 + 'px'),
                n.lockY || (r.style.top = c - r.offsetHeight / 2 + 'px'),
                (e.cache = { x: a, y: c }),
                n.onchange(a, c);
            },
            _tapstop: function () {
              c(document, ['mouseup', 'touchend', 'touchcancel'], e._tapstop),
                c(document, ['mousemove', 'touchmove'], e._tapmove);
            },
            trigger: function () {
              (e.wrapperRect = e.options.wrapper.getBoundingClientRect()), e._tapmove();
            },
            update: function () {
              var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0,
                n = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 0;
              (e.wrapperRect = e.options.wrapper.getBoundingClientRect()),
                e._tapmove({ clientX: e.wrapperRect.left + t, clientY: e.wrapperRect.top + n });
            },
            destroy: function () {
              var t = e.options,
                n = e._tapstart;
              c([t.wrapper, t.element], 'mousedown', n),
                c([t.wrapper, t.element], 'touchstart', n, { passive: !1 });
            },
          };
          e.wrapperRect = e.options.wrapper.getBoundingClientRect();
          var n = e.options,
            o = e._tapstart;
          return (
            a([n.wrapper, n.element], 'mousedown', o),
            a([n.wrapper, n.element], 'touchstart', o, { passive: !1 }),
            e
          );
        }
        function O(t) {
          return (
            (function (t) {
              if (Array.isArray(t)) {
                for (var e = 0, n = new Array(t.length); e < t.length; e++) n[e] = t[e];
                return n;
              }
            })(t) ||
            (function (t) {
              if (
                Symbol.iterator in Object(t) ||
                '[object Arguments]' === Object.prototype.toString.call(t)
              )
                return Array.from(t);
            })(t) ||
            (function () {
              throw new TypeError('Invalid attempt to spread non-iterable instance');
            })()
          );
        }
        function j(t, e) {
          for (var n = 0; n < e.length; n++) {
            var o = e[n];
            (o.enumerable = o.enumerable || !1),
              (o.configurable = !0),
              'value' in o && (o.writable = !0),
              Object.defineProperty(t, o.key, o);
          }
        }
        var x = (function () {
          function t(e) {
            !(function (t, e) {
              if (!(t instanceof e)) throw new TypeError('Cannot call a class as a function');
            })(this, t),
              (this.options = Object.assign(
                {
                  useAsButton: !1,
                  disabled: !1,
                  comparison: !0,
                  components: { interaction: {} },
                  strings: {},
                  default: 'fff',
                  defaultRepresentation: 'HEX',
                  position: 'middle',
                  adjustableNumbers: !0,
                  showAlways: !1,
                  parent: void 0,
                  closeWithKey: 'Escape',
                  onChange: function () {
                    return 0;
                  },
                  onSave: function () {
                    return 0;
                  },
                },
                e
              )),
              this.options.components.interaction || (this.options.components.interaction = {}),
              (this._initializingActive = !0),
              (this._recalc = !0),
              (this._color = new C()),
              (this._lastColor = new C()),
              this._preBuild(),
              this._rePositioningPicker(),
              this._buildComponents(),
              this._bindEvents(),
              this.setColor(this.options.default),
              (this._representation = this.options.defaultRepresentation),
              this.setColorRepresentation(this._representation),
              (this._initializingActive = !1),
              this._finalBuild();
          }
          var e, n;
          return (
            (e = t),
            (n = [
              {
                key: '_preBuild',
                value: function () {
                  var t,
                    e,
                    n,
                    o,
                    r,
                    i,
                    a,
                    c = this.options;
                  'string' == typeof c.el && (c.el = document.querySelector(c.el)),
                    (this._root =
                      ((e = (t = c).components),
                      (n = t.strings),
                      (o = t.useAsButton),
                      (r = function (t) {
                        return t ? '' : 'style="display:none" hidden';
                      }),
                      (i = p(
                        '\n        <div data-key="root" class="pickr">\n        \n            '
                          .concat(
                            o ? '' : '<div data-key="button" class="pcr-button"></div>',
                            '\n\n            <div data-key="app" class="pcr-app">\n                <div class="pcr-selection">\n                    <div data-con="preview" class="pcr-color-preview" '
                          )
                          .concat(
                            r(e.preview),
                            '>\n                        <div data-key="lastColor" class="pcr-last-color"></div>\n                        <div data-key="currentColor" class="pcr-current-color"></div>\n                    </div>\n\n                    <div data-con="palette" class="pcr-color-palette">\n                        <div data-key="picker" class="pcr-picker"></div>\n                        <div data-key="palette" class="pcr-palette"></div>\n                    </div>\n\n                    <div data-con="hue" class="pcr-color-chooser" '
                          )
                          .concat(
                            r(e.hue),
                            '>\n                        <div data-key="picker" class="pcr-picker"></div>\n                        <div data-key="slider" class="pcr-hue pcr-slider"></div>\n                    </div>\n\n                    <div data-con="opacity" class="pcr-color-opacity" '
                          )
                          .concat(
                            r(e.opacity),
                            '>\n                        <div data-key="picker" class="pcr-picker"></div>\n                        <div data-key="slider" class="pcr-opacity pcr-slider"></div>\n                    </div>\n                </div>\n\n                <div data-con="interaction" class="pcr-interaction" '
                          )
                          .concat(
                            r(e.interaction),
                            '>\n                    <input data-key="result" class="pcr-result" type="text" spellcheck="false" '
                          )
                          .concat(
                            r(e.interaction.input),
                            '>\n\n                    <input data-arr="options" class="pcr-type" data-type="HEX" value="HEX" type="button" '
                          )
                          .concat(
                            r(e.interaction.hex),
                            '>\n                    <input data-arr="options" class="pcr-type" data-type="RGBA" value="RGBa" type="button" '
                          )
                          .concat(
                            r(e.interaction.rgba),
                            '>\n                    <input data-arr="options" class="pcr-type" data-type="HSLA" value="HSLa" type="button" '
                          )
                          .concat(
                            r(e.interaction.hsla),
                            '>\n                    <input data-arr="options" class="pcr-type" data-type="HSVA" value="HSVa" type="button" '
                          )
                          .concat(
                            r(e.interaction.hsva),
                            '>\n                    <input data-arr="options" class="pcr-type" data-type="CMYK" value="CMYK" type="button" '
                          )
                          .concat(
                            r(e.interaction.cmyk),
                            '>\n\n                    <input data-key="save" class="pcr-save" value="'
                          )
                          .concat(n.save || 'Save', '" type="button" ')
                          .concat(
                            r(e.interaction.save),
                            '>\n                    <input data-key="clear" class="pcr-clear" value="'
                          )
                          .concat(n.clear || 'Clear', '" type="button" ')
                          .concat(
                            r(e.interaction.clear),
                            '>\n                </div>\n            </div>\n        </div>\n    '
                          )
                      )),
                      (a = i.interaction).options.find(function (t) {
                        return !t.hidden && !t.classList.add('active');
                      }),
                      (a.type = function () {
                        return a.options.find(function (t) {
                          return t.classList.contains('active');
                        });
                      }),
                      i)),
                    c.useAsButton && (c.parent || (c.parent = 'body'), (this._root.button = c.el)),
                    document.body.appendChild(this._root.root);
                },
              },
              {
                key: '_finalBuild',
                value: function () {
                  var t = this.options,
                    e = this._root;
                  document.body.removeChild(e.root),
                    t.parent &&
                      ('string' == typeof t.parent && (t.parent = document.querySelector(t.parent)),
                      t.parent.appendChild(e.app)),
                    t.useAsButton || t.el.parentElement.replaceChild(e.root, t.el),
                    t.disabled && this.disable(),
                    t.comparison ||
                      ((e.button.style.transition = 'none'),
                      t.useAsButton || (e.preview.lastColor.style.transition = 'none')),
                    t.showAlways ? e.app.classList.add('visible') : this.hide();
                },
              },
              {
                key: '_buildComponents',
                value: function () {
                  var t = this,
                    e = this.options.components,
                    n = {
                      palette: S({
                        element: t._root.palette.picker,
                        wrapper: t._root.palette.palette,
                        onchange: function (e, n) {
                          var o = t._color,
                            r = t._root,
                            i = t.options;
                          (o.s = (e / this.wrapper.offsetWidth) * 100),
                            (o.v = 100 - (n / this.wrapper.offsetHeight) * 100),
                            o.v < 0 && (o.v = 0);
                          var a = o.toRGBA().toString();
                          (this.element.style.background = a),
                            (this.wrapper.style.background =
                              '\n                        linear-gradient(to top, rgba(0, 0, 0, '
                                .concat(
                                  o.a,
                                  '), transparent), \n                        linear-gradient(to left, hsla('
                                )
                                .concat(o.h, ', 100%, 50%, ')
                                .concat(o.a, '), rgba(255, 255, 255, ')
                                .concat(o.a, '))\n                    ')),
                            i.comparison ||
                              ((r.button.style.background = a),
                              i.useAsButton || (r.preview.lastColor.style.background = a)),
                            (r.preview.currentColor.style.background = a),
                            t._recalc && t._updateOutput(),
                            r.button.classList.remove('clear');
                        },
                      }),
                      hue: S({
                        lockX: !0,
                        element: t._root.hue.picker,
                        wrapper: t._root.hue.slider,
                        onchange: function (o, r) {
                          e.hue &&
                            ((t._color.h = (r / this.wrapper.offsetHeight) * 360),
                            (this.element.style.backgroundColor = 'hsl('.concat(
                              t._color.h,
                              ', 100%, 50%)'
                            )),
                            n.palette.trigger());
                        },
                      }),
                      opacity: S({
                        lockX: !0,
                        element: t._root.opacity.picker,
                        wrapper: t._root.opacity.slider,
                        onchange: function (n, o) {
                          e.opacity &&
                            ((t._color.a = Math.round((o / this.wrapper.offsetHeight) * 100) / 100),
                            (this.element.style.background = 'rgba(0, 0, 0, '.concat(
                              t._color.a,
                              ')'
                            )),
                            t.components.palette.trigger());
                        },
                      }),
                      selectable: (function () {
                        var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {},
                          e = {
                            options: Object.assign(
                              {
                                onchange: function () {
                                  return 0;
                                },
                                className: '',
                                elements: [],
                              },
                              t
                            ),
                            _ontap: function (t) {
                              var n = e.options;
                              n.elements.forEach(function (e) {
                                return e.classList[t.target === e ? 'add' : 'remove'](n.className);
                              }),
                                n.onchange(t);
                            },
                            destroy: function () {
                              c(e.options.elements, 'click', this._ontap);
                            },
                          };
                        return a(e.options.elements, 'click', e._ontap), e;
                      })({
                        elements: t._root.interaction.options,
                        className: 'active',
                        onchange: function (e) {
                          (t._representation = e.target.getAttribute('data-type').toUpperCase()),
                            t._updateOutput();
                        },
                      }),
                    };
                  this.components = n;
                },
              },
              {
                key: '_bindEvents',
                value: function () {
                  var t = this,
                    e = this._root,
                    n = this.options,
                    o = [
                      a(e.interaction.clear, 'click', function () {
                        return t._clearColor();
                      }),
                      a(e.preview.lastColor, 'click', function () {
                        return t.setHSVA.apply(t, O(t._lastColor.toHSVA()));
                      }),
                      a(e.interaction.save, 'click', function () {
                        !t._saveColor() && !n.showAlways && t.hide();
                      }),
                      a(e.interaction.result, ['keyup', 'input'], function (e) {
                        (t._recalc = !1),
                          t.setColor(e.target.value, !0) &&
                            !t._initializingActive &&
                            t.options.onChange(t._color, t),
                          e.stopImmediatePropagation();
                      }),
                      a(
                        [
                          e.palette.palette,
                          e.palette.picker,
                          e.hue.slider,
                          e.hue.picker,
                          e.opacity.slider,
                          e.opacity.picker,
                        ],
                        ['mousedown', 'touchstart'],
                        function () {
                          return (t._recalc = !0);
                        }
                      ),
                      a(window, 'resize', function () {
                        return t._rePositioningPicker;
                      }),
                    ];
                  if (!n.showAlways) {
                    o.push(
                      a(e.button, 'click', function () {
                        return t.isOpen() ? t.hide() : t.show();
                      })
                    );
                    var r = n.closeWithKey;
                    o.push(
                      a(document, 'keyup', function (e) {
                        return t.isOpen() && (e.key === r || e.code === r) && t.hide();
                      })
                    ),
                      o.push(
                        a(
                          document,
                          ['touchstart', 'mousedown'],
                          function (n) {
                            t.isOpen() &&
                              !d(n).some(function (t) {
                                return t === e.app || t === e.button;
                              }) &&
                              t.hide();
                          },
                          { capture: !0 }
                        )
                      );
                  }
                  n.adjustableNumbers && h(e.interaction.result, !1), (this._eventBindings = o);
                },
              },
              {
                key: '_rePositioningPicker',
                value: function () {
                  var t = this._root,
                    e = this._root.app;
                  if (this.options.parent) {
                    var n = t.button.getBoundingClientRect();
                    (e.style.position = 'fixed'),
                      (e.style.marginLeft = ''.concat(n.left, 'px')),
                      (e.style.marginTop = ''.concat(n.top, 'px'));
                  }
                  var o = t.button.getBoundingClientRect(),
                    r = e.getBoundingClientRect(),
                    i = e.style;
                  r.bottom > window.innerHeight
                    ? (i.top = ''.concat(-r.height - 5, 'px'))
                    : o.bottom + r.height < window.innerHeight &&
                      (i.top = ''.concat(o.height + 5, 'px'));
                  var a = {
                      left: -r.width + o.width,
                      middle: -r.width / 2 + o.width / 2,
                      right: 0,
                    },
                    c = parseInt(getComputedStyle(e).left, 10),
                    s = a[this.options.position];
                  r.left - c + s < 0
                    ? (s = a.right)
                    : r.left - c - s > window.innerWidth && (s = a.left),
                    (i.left = ''.concat(s, 'px'));
                },
              },
              {
                key: '_updateOutput',
                value: function () {
                  var t,
                    e = this;
                  this._root.interaction.type() &&
                    (this._root.interaction.result.value =
                      ((t = 'to' + e._root.interaction.type().getAttribute('data-type')),
                      'function' == typeof e._color[t] ? e._color[t]().toString() : '')),
                    this._initializingActive || this.options.onChange(this._color, this);
                },
              },
              {
                key: '_saveColor',
                value: function () {
                  var t = this._root,
                    e = t.preview,
                    n = t.button,
                    o = this._color.toRGBA().toString();
                  (e.lastColor.style.background = o),
                    this.options.useAsButton || (n.style.background = o),
                    n.classList.remove('clear'),
                    (this._lastColor = this._color.clone()),
                    this._initializingActive || this.options.onSave(this._color, this);
                },
              },
              {
                key: '_clearColor',
                value: function () {
                  var t = this._root,
                    e = this.options;
                  e.useAsButton || (t.button.style.background = 'rgba(255, 255, 255, 0.4)'),
                    t.button.classList.add('clear'),
                    e.showAlways || this.hide(),
                    e.onSave(null, this);
                },
              },
              {
                key: 'destroy',
                value: function () {
                  var t = this;
                  this._eventBindings.forEach(function (t) {
                    return c.apply(o, O(t));
                  }),
                    Object.keys(this.components).forEach(function (e) {
                      return t.components[e].destroy();
                    });
                },
              },
              {
                key: 'destroyAndRemove',
                value: function () {
                  this.destroy();
                  var t = this._root.root;
                  t.parentElement.removeChild(t);
                },
              },
              {
                key: 'hide',
                value: function () {
                  return this._root.app.classList.remove('visible'), this;
                },
              },
              {
                key: 'show',
                value: function () {
                  if (!this.options.disabled)
                    return (
                      this._root.app.classList.add('visible'), this._rePositioningPicker(), this
                    );
                },
              },
              {
                key: 'isOpen',
                value: function () {
                  return this._root.app.classList.contains('visible');
                },
              },
              {
                key: 'setHSVA',
                value: function () {
                  var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 360,
                    e = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 0,
                    n = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0,
                    o = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : 1,
                    r = 4 < arguments.length && void 0 !== arguments[4] && arguments[4],
                    i = this._recalc;
                  if (
                    ((this._recalc = !1),
                    t < 0 || 360 < t || e < 0 || 100 < e || n < 0 || 100 < n || o < 0 || 1 < o)
                  )
                    return !1;
                  var a = this.components,
                    c = a.hue,
                    s = a.opacity,
                    u = a.palette,
                    l = c.options.wrapper.offsetHeight * (t / 360);
                  c.update(0, l);
                  var p = s.options.wrapper.offsetHeight * o;
                  s.update(0, p);
                  var d = u.options.wrapper,
                    h = d.offsetWidth * (e / 100),
                    f = d.offsetHeight * (1 - n / 100);
                  return (
                    u.update(h, f),
                    (this._color = new C(t, e, n, o)),
                    (this._recalc = i),
                    this._recalc && this._updateOutput(),
                    r || this._saveColor(),
                    !0
                  );
                },
              },
              {
                key: 'setColor',
                value: function (t) {
                  var e = 1 < arguments.length && void 0 !== arguments[1] && arguments[1];
                  if (null === t) return this._clearColor(), !0;
                  var n = A(t);
                  return n ? this.setHSVA.apply(this, O(n).concat([e])) : void 0;
                },
              },
              {
                key: 'setColorRepresentation',
                value: function (t) {
                  return (
                    (t = t.toUpperCase()),
                    !!this._root.interaction.options.find(function (e) {
                      return e.getAttribute('data-type') === t && !e.click();
                    })
                  );
                },
              },
              {
                key: 'getColorRepresentation',
                value: function () {
                  return this._representation;
                },
              },
              {
                key: 'getColor',
                value: function () {
                  return this._color;
                },
              },
              {
                key: 'getRoot',
                value: function () {
                  return this._root;
                },
              },
              {
                key: 'disable',
                value: function () {
                  return (
                    this.hide(),
                    (this.options.disabled = !0),
                    this._root.button.classList.add('disabled'),
                    this
                  );
                },
              },
              {
                key: 'enable',
                value: function () {
                  return (
                    (this.options.disabled = !1),
                    this._root.button.classList.remove('disabled'),
                    this
                  );
                },
              },
            ]) && j(e.prototype, n),
            t
          );
        })();
        (x.utils = {
          once: i,
          on: a,
          off: c,
          eventPath: d,
          createElementFromString: u,
          adjustableInputNumbers: h,
          removeAttribute: l,
          createFromTemplate: p,
        }),
          (x.create = function (t) {
            return new x(t);
          }),
          (x.version = '0.3.1'),
          (e.default = x);
      },
    ]).default;
  });
  const pickr1 = new Pickr({
    el: '#color-picker-1',
    default: '303030',
    components: {
      preview: true,
      opacity: true,
      hue: true,

      interaction: {
        hex: true,
        rgba: true,
        hsla: true,
        hsva: true,
        cmyk: true,
        input: true,
        clear: true,
        save: true,
      },
    },
  });
  const pickr2 = new Pickr({
    el: '#color-picker-2',
    useAsButton: true,
    default: '123456',

    components: {
      preview: true,
      opacity: true,
      hue: true,

      interaction: {
        hex: true,
        rgba: true,
        hsla: true,
        hsva: true,
        cmyk: true,
        input: true,
        clear: true,
        save: true,
      },
    },
  });
  const pickr3 = new Pickr({
    el: '#color-picker-3',
    useAsButton: true,
    default: '303030',
    components: {
      preview: true,
      opacity: true,
      hue: true,

      interaction: {
        hex: true,
        rgba: true,
        hsla: true,
        hsva: true,
        cmyk: true,
        input: true,
        clear: true,
        save: true,
      },
    },

    onChange(hsva, instance) {
      $('.bg-color').css('background-color', hsva.toRGBA().toString());
    },
  });

  const pickr4 = new Pickr({
    el: '#color-picker-4',
    default: '303030',
    useAsButton: true,
    components: {
      preview: true,
      opacity: true,
      hue: true,

      interaction: {
        hex: true,
        rgba: true,
        hsla: true,
        hsva: true,
        cmyk: true,
        input: true,
        clear: true,
        save: true,
      },
    },

    onChange(hsva, instance) {
      $('.text-color').css('color', hsva.toRGBA().toString());
    },
  });
  let colorArray = [];
  const pickr5 = new Pickr({
    el: '#color-picker-5',
    default: '030303',
    useAsButton: true,
    components: {
      preview: true,
      opacity: true,
      hue: true,

      interaction: {
        hex: true,
        rgba: true,
        hsla: true,
        hsva: true,
        cmyk: true,
        input: true,
        clear: true,
        save: true,
      },
    },

    onSave(hsva, instance) {
      colorArray.push({
        hex: hsva.toHEX().toString(),
        rgba: hsva.toRGBA().toString(),
        hsla: hsva.toHSLA().toString(),
        hsva: hsva.toHSVA().toString(),
        cmyk: hsva.toCMYK().toString(),
      });
      copyToClipboard();
    },
  });

  function copyToClipboard() {
    const el = document.createElement('textarea');
    colorArray.forEach(function (elem) {
      el.value += '{';
      el.value += 'hex: ' + "'" + elem.hex + "'" + ', ';
      el.value += 'rgba: ' + "'" + elem.rgba + "'" + ', ';
      el.value += 'hsla: ' + "'" + elem.hsla + "'" + ', ';
      el.value += 'hsva: ' + "'" + elem.hsva + "'" + ', ';
      el.value += 'cmyk: ' + "'" + elem.cmyk + "'";
      el.value += '}, ';
    });
    $(el).attr('readonly', '');
    $(el).css('position', 'absolute');
    $(el).css('left', '-9999px');
    $(el).appendTo(document.body);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
  }
  const pickr6 = new Pickr({
    el: '#color-picker-6',
    useAsButton: true,

    components: {
      preview: true,
      opacity: true,
      hue: true,

      interaction: {
        hex: true,
        rgba: true,
        hsla: true,
        hsva: true,
        cmyk: true,
        input: true,
        clear: true,
        save: true,
      },
    },

    onChange(hsva) {
      let colorObject = {
        hex: hsva.toHEX().toString(),
        rgba: hsva.toRGBA().toString(),
        hsla: hsva.toHSLA().toString(),
        hsva: hsva.toHSVA().toString(),
        cmyk: hsva.toCMYK().toString(),
      };
      for (let col in colorObject) {
        $('#' + col).text(col + ': ' + colorObject[col]);
      }
    },
  });
  const pickr7 = new Pickr({
    el: '#color-picker-7',
    useAsButton: true,

    components: {
      preview: true,
      opacity: true,
      hue: true,

      interaction: {
        hex: true,
        rgba: true,
        hsla: true,
        hsva: true,
        cmyk: true,
        input: true,
        clear: true,
        save: true,
      },
    },

    onChange(hsva) {
      $(document.body).css('background-color', hsva.toHEX().toString());
    },
  });