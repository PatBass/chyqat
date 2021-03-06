﻿var currentElem = null;
var currentScroll = null;
(function (b) {
    var a = {
        init: function (d) {
            return this.each(function () {
                var r = b(this);
                var v = b(".ffSelectMenuMid", r);
                var q = b("UL", r);
                b(".ffSelectMenuWrapper", r).css("display", "block");
                var s = v.height();
                var f = v.width();
                var m = q.height();
                var o = f - q.width();
                var u = m / s;
                b(".ffSelectMenuWrapper", r).css("display", "none");
                if (u > 1) {
                    v.css({
                        overflow: "hidden",
                        position: "relative"
                    });
                    var p = b('<div class="scrollingBarWrapper">').css({
                        position: "absolute",
                        top: "0"
                    });
                    if (v.css("direction") == "ltr") {
                        p.css("right", "0")
                    } else {
                        p.css("left", "0")
                    }
                    var g = s / u;
                    var j = b('<div class="scrollingHandle">').css({
                        position: "absolute",
                        top: "0"
                    });
                    var l = b('<div class="scrollingContent">').css({
                        position: "absolute",
                        width: f,
                        top: "0"
                    });
                    v.height(s).append(l.append(b("UL", v))).append(p.append(j));
                    var k = parseInt(j.css("paddingTop"));
                    if ((g - k) < 0) {
                        g = k;
                        u = (m - s) / (s - g * 2);
                        b("UL LI", l).css("paddingRight", parseInt(b("UL LI:first", l).css("paddingRight")) + o)
                    } else {
                        g = parseInt(g - parseInt(j.css("paddingTop")))
                    }
                    j.height(g);
                    j.append(b('<div class="scrollingHandleBottom">').height(g));
                    var t = 10;
                    var i = s - (g + k);
                    var w = (m - s) / t;
                    if ((i / w) > 1) {
                        j.data("pm", t);
                        j.data("sm", (i / w))
                    } else {
                        var h = 1 / (i / w);
                        j.data("sm", 1);
                        j.data("pm", t * h)
                    }
                    j.data("sr", u);
                    j.draggable({
                        containment: "parent",
                        drag: function (x, y) {
                            l.css("top", (-1 * y.position.top) * u)
                        },
                        stop: function (x, y) {
                            q.data("ds", true);
                            setTimeout(function () {
                                q.data("ds", false)
                            }, 50)
                        }
                    });
                    v.hover(function () {
                        currentElem = l;
                        currentScroll = j
                    }, function () {
                        currentElem = null;
                        currentScroll = null
                    });
                    p.click(function (y) {
                        var x = y.pageY - b(this).offset().top;
                        j.css("top", x - (j.outerHeight() / 2));
                        if (parseInt(j.css("top")) < 0) {
                            j.css("top", "0")
                        } else {
                            if ((parseInt(j.css("top")) + j.outerHeight()) > p.outerHeight()) {
                                j.css("top", p.outerHeight() - j.outerHeight())
                            }
                        }
                        l.css("top", (-1 * parseInt(j.css("top"))) * u);
                        y.stopPropagation()
                    });
                    var n = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel";
                    var e = v[0];
                    if (e.attachEvent) {
                        e.attachEvent("on" + n, c)
                    } else {
                        if (e.addEventListener) {
                            e.addEventListener(n, c, false)
                        }
                    }
                }
            })
        },
        ffCustomScrollCheckPosition: function () {
            return this.each(function () {
                var e = b(this);
                var i = e.parent(".scrollingContent");
                var f = parseInt(i.css("top"));
                var h = i.next(".scrollingBarWrapper").children(".scrollingHandle");
                var j = e.closest(".ffSelectMenuMid");
                var d = parseInt(j.height());
                var g = b("LI.on", e);
                if ((d - f) < (g.offset().top - e.offset().top + g.outerHeight())) {
                    if ((b("LI:last", e).offset().top - g.offset().top) < d) {
                        i.css("top", d - parseInt(i.height()))
                    } else {
                        i.css("top", -(g.offset().top - e.offset().top))
                    }
                    h.css("top", parseInt(i.css("top")) / (-1 * parseFloat(h.data("sr"))))
                } else {
                    if (-(f) > (g.offset().top - e.offset().top)) {
                        if ((g.offset().top - b("LI:first", e).offset().top) < d) {
                            i.css("top", "0")
                        } else {
                            i.css("top", -(g.offset().top - e.offset().top) + (d - g.outerHeight()))
                        }
                        h.css("top", parseInt(i.css("top")) / (-1 * parseFloat(h.data("sr"))))
                    }
                }
            })
        }
    };

    function c(g) {
        var j = window.event || g;
        var i = j.detail ? j.detail * (-120) : j.wheelDelta;
        var h = currentScroll.data("sm");
        var d = currentScroll.data("pm");
        if (i <= 0) {
            if (currentElem != null) {
                var f = parseInt(currentScroll.closest(".scrollingBarWrapper").outerHeight()) - (parseInt(currentScroll.outerHeight()) + parseInt(currentScroll.css("top")));
                if (f > h) {
                    currentElem.css("top", parseInt(currentElem.css("top")) - d);
                    currentScroll.css("top", parseInt(currentScroll.css("top")) + h)
                } else {
                    if (f > 0) {
                        currentElem.css("top", parseInt(currentElem.closest(".ffSelectMenuMid").height()) - parseInt(currentElem.height()));
                        currentScroll.css("top", parseInt(currentScroll.css("top")) + f)
                    }
                }
            }
        } else {
            if (currentElem != null) {
                if (parseInt(currentElem.css("top")) < -d) {
                    currentElem.css("top", parseInt(currentElem.css("top")) + d);
                    currentScroll.css("top", parseInt(currentScroll.css("top")) - h)
                } else {
                    if (parseInt(currentElem.css("top")) < 0) {
                        currentElem.css("top", 0);
                        currentScroll.css("top", 0)
                    }
                }
            }
        } if (j.preventDefault) {
            j.preventDefault()
        } else {
            return false
        }
    }
    b.fn.ffCustomScroll = function (d) {
        if (a[d]) {
            return a[d].apply(this, Array.prototype.slice.call(arguments, 1))
        } else {
            if (typeof d === "object" || !d) {
                return a.init.apply(this, arguments)
            } else {
                b.error("Method " + d + " does not exist on jQuery.tooltip")
            }
        }
    }
})(jQuery);