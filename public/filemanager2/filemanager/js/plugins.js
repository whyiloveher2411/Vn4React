! function(t) {
    "use strict";
    t(function() {
        t.support.transition = function() {
            var t = function() {
                var t, e = document.createElement("bootstrap"),
                    n = {
                        WebkitTransition: "webkitTransitionEnd",
                        MozTransition: "transitionend",
                        OTransition: "oTransitionEnd otransitionend",
                        transition: "transitionend"
                    };
                for (t in n)
                    if (void 0 !== e.style[t]) return n[t]
            }();
            return t && {
                end: t
            }
        }()
    })
}(window.jQuery), ! function(t) {
    "use strict";
    var e = function(e, n) {
        this.options = t.extend({}, t.fn.affix.defaults, n), this.$window = t(window).on("scroll.affix.data-api", t.proxy(this.checkPosition, this)).on("click.affix.data-api", t.proxy(function() {
            setTimeout(t.proxy(this.checkPosition, this), 1)
        }, this)), this.$element = t(e), this.checkPosition()
    };
    e.prototype.checkPosition = function() {
        if (this.$element.is(":visible")) {
            var e, n = t(document).height(),
                o = this.$window.scrollTop(),
                i = this.$element.offset(),
                a = this.options.offset,
                s = a.bottom,
                r = a.top,
                l = "affix affix-top affix-bottom";
            "object" != typeof a && (s = r = a), "function" == typeof r && (r = a.top()), "function" == typeof s && (s = a.bottom()), e = !(null != this.unpin && o + this.unpin <= i.top) && (null != s && i.top + this.$element.height() >= n - s ? "bottom" : null != r && o <= r && "top"), this.affixed !== e && (this.affixed = e, this.unpin = "bottom" == e ? i.top - o : null, this.$element.removeClass(l).addClass("affix" + (e ? "-" + e : "")))
        }
    };
    var n = t.fn.affix;
    t.fn.affix = function(n) {
        return this.each(function() {
            var o = t(this),
                i = o.data("affix"),
                a = "object" == typeof n && n;
            i || o.data("affix", i = new e(this, a)), "string" == typeof n && i[n]()
        })
    }, t.fn.affix.Constructor = e, t.fn.affix.defaults = {
        offset: 0
    }, t.fn.affix.noConflict = function() {
        return t.fn.affix = n, this
    }, t(window).on("load", function() {
        t('[data-spy="affix"]').each(function() {
            var e = t(this),
                n = e.data();
            n.offset = n.offset || {}, n.offsetBottom && (n.offset.bottom = n.offsetBottom), n.offsetTop && (n.offset.top = n.offsetTop), e.affix(n)
        })
    })
}(window.jQuery), ! function(t) {
    "use strict";

    function e() {
        t(o).each(function() {
            n(t(this)).removeClass("open")
        })
    }

    function n(e) {
        var n, o = e.attr("data-target");
        return o || (o = e.attr("href"), o = o && /#/.test(o) && o.replace(/.*(?=#[^\s]*$)/, "")), n = o && t(o), n && n.length || (n = e.parent()), n
    }
    var o = "[data-toggle=dropdown]",
        i = function(e) {
            var n = t(e).on("click.dropdown.data-api", this.toggle);
            t("html").on("click.dropdown.data-api", function() {
                n.parent().removeClass("open")
            })
        };
    i.prototype = {
        constructor: i,
        toggle: function(o) {
            var i, a, s = t(this);
            if (!s.is(".disabled, :disabled")) return i = n(s), a = i.hasClass("open"), e(), a || i.toggleClass("open"), s.focus(), !1
        },
        keydown: function(e) {
            var i, a, s, r, l;
            if (/(38|40|27)/.test(e.keyCode) && (i = t(this), e.preventDefault(), e.stopPropagation(), !i.is(".disabled, :disabled"))) {
                if (s = n(i), r = s.hasClass("open"), !r || r && 27 == e.keyCode) return 27 == e.which && s.find(o).focus(), i.click();
                a = t("[role=menu] li:not(.divider):visible a", s), a.length && (l = a.index(a.filter(":focus")), 38 == e.keyCode && l > 0 && l--, 40 == e.keyCode && l < a.length - 1 && l++, ~l || (l = 0), a.eq(l).focus())
            }
        }
    };
    var a = t.fn.dropdown;
    t.fn.dropdown = function(e) {
        return this.each(function() {
            var n = t(this),
                o = n.data("dropdown");
            o || n.data("dropdown", o = new i(this)), "string" == typeof e && o[e].call(n)
        })
    }, t.fn.dropdown.Constructor = i, t.fn.dropdown.noConflict = function() {
        return t.fn.dropdown = a, this
    }, t(document).on("click.dropdown.data-api", e).on("click.dropdown.data-api", ".dropdown form", function(t) {
        t.stopPropagation()
    }).on("click.dropdown-menu", function(t) {
        t.stopPropagation()
    }).on("click.dropdown.data-api", o, i.prototype.toggle).on("keydown.dropdown.data-api", o + ", [role=menu]", i.prototype.keydown)
}(window.jQuery), ! function(t) {
    "use strict";
    var e = '[data-dismiss="alert"]',
        n = function(n) {
            t(n).on("click", e, this.close)
        };
    n.prototype.close = function(e) {
        function n() {
            o.trigger("closed").remove()
        }
        var o, i = t(this),
            a = i.attr("data-target");
        a || (a = i.attr("href"), a = a && a.replace(/.*(?=#[^\s]*$)/, "")), o = t(a), e && e.preventDefault(), o.length || (o = i.hasClass("alert") ? i : i.parent()), o.trigger(e = t.Event("close")), e.isDefaultPrevented() || (o.removeClass("in"), t.support.transition && o.hasClass("fade") ? o.on(t.support.transition.end, n) : n())
    };
    var o = t.fn.alert;
    t.fn.alert = function(e) {
        return this.each(function() {
            var o = t(this),
                i = o.data("alert");
            i || o.data("alert", i = new n(this)), "string" == typeof e && i[e].call(o)
        })
    }, t.fn.alert.Constructor = n, t.fn.alert.noConflict = function() {
        return t.fn.alert = o, this
    }, t(document).on("click.alert.data-api", e, n.prototype.close)
}(window.jQuery), ! function(t) {
    "use strict";
    var e = function(e, n) {
        this.$element = t(e), this.options = t.extend({}, t.fn.button.defaults, n)
    };
    e.prototype.setState = function(t) {
        var e = "disabled",
            n = this.$element,
            o = n.data(),
            i = n.is("input") ? "val" : "html";
        t += "Text", o.resetText || n.data("resetText", n[i]()), n[i](o[t] || this.options[t]), setTimeout(function() {
            "loadingText" == t ? n.addClass(e).attr(e, e) : n.removeClass(e).removeAttr(e)
        }, 0)
    }, e.prototype.toggle = function() {
        var t = this.$element.closest('[data-toggle="buttons-radio"]');
        t && t.find(".active").removeClass("active"), this.$element.toggleClass("active")
    };
    var n = t.fn.button;
    t.fn.button = function(n) {
        return this.each(function() {
            var o = t(this),
                i = o.data("button"),
                a = "object" == typeof n && n;
            i || o.data("button", i = new e(this, a)), "toggle" == n ? i.toggle() : n && i.setState(n)
        })
    }, t.fn.button.defaults = {
        loadingText: "loading..."
    }, t.fn.button.Constructor = e, t.fn.button.noConflict = function() {
        return t.fn.button = n, this
    }, t(document).on("click.button.data-api", "[data-toggle^=button]", function(e) {
        var n = t(e.target);
        n.hasClass("btn") || (n = n.closest(".btn")), n.button("toggle")
    })
}(window.jQuery), ! function(t) {
    "use strict";
    var e = function(e, n) {
        this.$element = t(e), this.options = t.extend({}, t.fn.collapse.defaults, n), this.options.parent && (this.$parent = t(this.options.parent)), this.options.toggle && this.toggle()
    };
    e.prototype = {
        constructor: e,
        dimension: function() {
            var t = this.$element.hasClass("width");
            return t ? "width" : "height"
        },
        show: function() {
            var e, n, o, i;
            if (!this.transitioning && !this.$element.hasClass("in")) {
                if (e = this.dimension(), n = t.camelCase(["scroll", e].join("-")), o = this.$parent && this.$parent.find("> .accordion-group > .in"), o && o.length) {
                    if (i = o.data("collapse"), i && i.transitioning) return;
                    o.collapse("hide"), i || o.data("collapse", null)
                }
                this.$element[e](0), this.transition("addClass", t.Event("show"), "shown"), t.support.transition && this.$element[e](this.$element[0][n])
            }
        },
        hide: function() {
            var e;
            !this.transitioning && this.$element.hasClass("in") && (e = this.dimension(), this.reset(this.$element[e]()), this.transition("removeClass", t.Event("hide"), "hidden"), this.$element[e](0))
        },
        reset: function(t) {
            var e = this.dimension();
            return this.$element.removeClass("collapse")[e](t || "auto")[0].offsetWidth, this.$element[null !== t ? "addClass" : "removeClass"]("collapse"), this
        },
        transition: function(e, n, o) {
            var i = this,
                a = function() {
                    "show" == n.type && i.reset(), i.transitioning = 0, i.$element.trigger(o)
                };
            this.$element.trigger(n), n.isDefaultPrevented() || (this.transitioning = 1, this.$element[e]("in"), t.support.transition && this.$element.hasClass("collapse") ? this.$element.one(t.support.transition.end, a) : a())
        },
        toggle: function() {
            this[this.$element.hasClass("in") ? "hide" : "show"]()
        }
    };
    var n = t.fn.collapse;
    t.fn.collapse = function(n) {
        return this.each(function() {
            var o = t(this),
                i = o.data("collapse"),
                a = t.extend({}, t.fn.collapse.defaults, o.data(), "object" == typeof n && n);
            i || o.data("collapse", i = new e(this, a)), "string" == typeof n && i[n]()
        })
    }, t.fn.collapse.defaults = {
        toggle: !0
    }, t.fn.collapse.Constructor = e, t.fn.collapse.noConflict = function() {
        return t.fn.collapse = n, this
    }, t(document).on("click.collapse.data-api", "[data-toggle=collapse]", function(e) {
        var n, o = t(this),
            i = o.attr("data-target") || e.preventDefault() || (n = o.attr("href")) && n.replace(/.*(?=#[^\s]+$)/, ""),
            a = t(i).data("collapse") ? "toggle" : o.data();
        o[t(i).hasClass("in") ? "addClass" : "removeClass"]("collapsed"), t(i).collapse(a)
    })
}(window.jQuery), ! function(t) {
    "use strict";
    var e = function(e, n) {
        this.options = n, this.$element = t(e).delegate('[data-dismiss="modal"]', "click.dismiss.modal", t.proxy(this.hide, this)), this.options.remote && this.$element.find(".modal-body").load(this.options.remote)
    };
    e.prototype = {
        constructor: e,
        toggle: function() {
            return this[this.isShown ? "hide" : "show"]()
        },
        show: function() {
            var e = this,
                n = t.Event("show");
            this.$element.trigger(n), this.isShown || n.isDefaultPrevented() || (this.isShown = !0, this.escape(), this.backdrop(function() {
                var n = t.support.transition && e.$element.hasClass("fade");
                e.$element.parent().length || e.$element.appendTo(document.body), e.$element.show(), n && e.$element[0].offsetWidth, e.$element.addClass("in").attr("aria-hidden", !1), e.enforceFocus(), n ? e.$element.one(t.support.transition.end, function() {
                    e.$element.focus().trigger("shown")
                }) : e.$element.focus().trigger("shown")
            }))
        },
        hide: function(e) {
            e && e.preventDefault();
            e = t.Event("hide"), this.$element.trigger(e), this.isShown && !e.isDefaultPrevented() && (this.isShown = !1, this.escape(), t(document).off("focusin.modal"), this.$element.removeClass("in").attr("aria-hidden", !0), t.support.transition && this.$element.hasClass("fade") ? this.hideWithTransition() : this.hideModal())
        },
        enforceFocus: function() {
            var e = this;
            t(document).on("focusin.modal", function(t) {
                e.$element[0] === t.target || e.$element.has(t.target).length || e.$element.focus()
            })
        },
        escape: function() {
            var t = this;
            this.isShown && this.options.keyboard ? this.$element.on("keyup.dismiss.modal", function(e) {
                27 == e.which && t.hide()
            }) : this.isShown || this.$element.off("keyup.dismiss.modal")
        },
        hideWithTransition: function() {
            var e = this,
                n = setTimeout(function() {
                    e.$element.off(t.support.transition.end), e.hideModal()
                }, 500);
            this.$element.one(t.support.transition.end, function() {
                clearTimeout(n), e.hideModal()
            })
        },
        hideModal: function() {
            var t = this;
            this.$element.hide(), this.backdrop(function() {
                t.removeBackdrop(), t.$element.trigger("hidden")
            })
        },
        removeBackdrop: function() {
            this.$backdrop && this.$backdrop.remove(), this.$backdrop = null
        },
        backdrop: function(e) {
            var n = this.$element.hasClass("fade") ? "fade" : "";
            if (this.isShown && this.options.backdrop) {
                var o = t.support.transition && n;
                if (this.$backdrop = t('<div class="modal-backdrop ' + n + '" />').appendTo(document.body), this.$backdrop.click("static" == this.options.backdrop ? t.proxy(this.$element[0].focus, this.$element[0]) : t.proxy(this.hide, this)), o && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !e) return;
                o ? this.$backdrop.one(t.support.transition.end, e) : e()
            } else !this.isShown && this.$backdrop ? (this.$backdrop.removeClass("in"), t.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one(t.support.transition.end, e) : e()) : e && e()
        }
    };
    var n = t.fn.modal;
    t.fn.modal = function(n) {
        return this.each(function() {
            var o = t(this),
                i = o.data("modal"),
                a = t.extend({}, t.fn.modal.defaults, o.data(), "object" == typeof n && n);
            i || o.data("modal", i = new e(this, a)), "string" == typeof n ? i[n]() : a.show && i.show()
        })
    }, t.fn.modal.defaults = {
        backdrop: !0,
        keyboard: !0,
        show: !0
    }, t.fn.modal.Constructor = e, t.fn.modal.noConflict = function() {
        return t.fn.modal = n, this
    }, t(document).on("click.modal.data-api", '[data-toggle="modal"]', function(e) {
        var n = t(this),
            o = n.attr("href"),
            i = t(n.attr("data-target") || o && o.replace(/.*(?=#[^\s]+$)/, "")),
            a = i.data("modal") ? "toggle" : t.extend({
                remote: !/#/.test(o) && o
            }, i.data(), n.data());
        e.preventDefault(), i.modal(a).one("hide", function() {
            n.focus()
        })
    })
}(window.jQuery), ! function(t) {
    "use strict";
    var e = function(t, e) {
        this.init("tooltip", t, e)
    };
    e.prototype = {
        constructor: e,
        init: function(e, n, o) {
            var i, a, s, r, l;
            for (this.type = e, this.$element = t(n), this.options = this.getOptions(o), this.enabled = !0, s = this.options.trigger.split(" "), l = s.length; l--;) r = s[l], "click" == r ? this.$element.on("click." + this.type, this.options.selector, t.proxy(this.toggle, this)) : "manual" != r && (i = "hover" == r ? "mouseenter" : "focus", a = "hover" == r ? "mouseleave" : "blur", this.$element.on(i + "." + this.type, this.options.selector, t.proxy(this.enter, this)), this.$element.on(a + "." + this.type, this.options.selector, t.proxy(this.leave, this)));
            this.options.selector ? this._options = t.extend({}, this.options, {
                trigger: "manual",
                selector: ""
            }) : this.fixTitle()
        },
        getOptions: function(e) {
            return e = t.extend({}, t.fn[this.type].defaults, this.$element.data(), e), e.delay && "number" == typeof e.delay && (e.delay = {
                show: e.delay,
                hide: e.delay
            }), e
        },
        enter: function(e) {
            var n, o = t.fn[this.type].defaults,
                i = {};
            return this._options && t.each(this._options, function(t, e) {
                o[t] != e && (i[t] = e)
            }, this), n = t(e.currentTarget)[this.type](i).data(this.type), n.options.delay && n.options.delay.show ? (clearTimeout(this.timeout), n.hoverState = "in", void(this.timeout = setTimeout(function() {
                "in" == n.hoverState && n.show()
            }, n.options.delay.show))) : n.show()
        },
        leave: function(e) {
            var n = t(e.currentTarget)[this.type](this._options).data(this.type);
            return this.timeout && clearTimeout(this.timeout), n.options.delay && n.options.delay.hide ? (n.hoverState = "out", void(this.timeout = setTimeout(function() {
                "out" == n.hoverState && n.hide()
            }, n.options.delay.hide))) : n.hide()
        },
        show: function() {
            var e, n, o, i, a, s, r = t.Event("show");
            if (this.hasContent() && this.enabled) {
                if (this.$element.trigger(r), r.isDefaultPrevented()) return;
                switch (e = this.tip(), this.setContent(), this.options.animation && e.addClass("fade"), a = "function" == typeof this.options.placement ? this.options.placement.call(this, e[0], this.$element[0]) : this.options.placement, e.detach().css({
                    top: 0,
                    left: 0,
                    display: "block"
                }), this.options.container ? e.appendTo(this.options.container) : e.insertAfter(this.$element), n = this.getPosition(), o = e[0].offsetWidth, i = e[0].offsetHeight, a) {
                    case "bottom":
                        s = {
                            top: n.top + n.height,
                            left: n.left + n.width / 2 - o / 2
                        };
                        break;
                    case "top":
                        s = {
                            top: n.top - i,
                            left: n.left + n.width / 2 - o / 2
                        };
                        break;
                    case "left":
                        s = {
                            top: n.top + n.height / 2 - i / 2,
                            left: n.left - o
                        };
                        break;
                    case "right":
                        s = {
                            top: n.top + n.height / 2 - i / 2,
                            left: n.left + n.width
                        }
                }
                this.applyPlacement(s, a), this.$element.trigger("shown")
            }
        },
        applyPlacement: function(t, e) {
            var n, o, i, a, s = this.tip(),
                r = s[0].offsetWidth,
                l = s[0].offsetHeight;
            s.offset(t).addClass(e).addClass("in"), n = s[0].offsetWidth, o = s[0].offsetHeight, "top" == e && o != l && (t.top = t.top + l - o, a = !0), "bottom" == e || "top" == e ? (i = 0, t.left < 0 && (i = t.left * -2, t.left = 0, s.offset(t), n = s[0].offsetWidth, o = s[0].offsetHeight), this.replaceArrow(i - r + n, n, "left")) : this.replaceArrow(o - l, o, "top"), a && s.offset(t)
        },
        replaceArrow: function(t, e, n) {
            this.arrow().css(n, t ? 50 * (1 - t / e) + "%" : "")
        },
        setContent: function() {
            var t = this.tip(),
                e = this.getTitle();
            t.find(".tooltip-inner")[this.options.html ? "html" : "text"](e), t.removeClass("fade in top bottom left right")
        },
        hide: function() {
            function e() {
                var e = setTimeout(function() {
                    n.off(t.support.transition.end).detach()
                }, 500);
                n.one(t.support.transition.end, function() {
                    clearTimeout(e), n.detach()
                })
            }
            var n = this.tip(),
                o = t.Event("hide");
            if (this.$element.trigger(o), !o.isDefaultPrevented()) return n.removeClass("in"), t.support.transition && this.$tip.hasClass("fade") ? e() : n.detach(), this.$element.trigger("hidden"), this
        },
        fixTitle: function() {
            var t = this.$element;
            (t.attr("title") || "string" != typeof t.attr("data-original-title")) && t.attr("data-original-title", t.attr("title") || "").attr("title", "")
        },
        hasContent: function() {
            return this.getTitle()
        },
        getPosition: function() {
            var e = this.$element[0];
            return t.extend({}, "function" == typeof e.getBoundingClientRect ? e.getBoundingClientRect() : {
                width: e.offsetWidth,
                height: e.offsetHeight
            }, this.$element.offset())
        },
        getTitle: function() {
            var t, e = this.$element,
                n = this.options;
            return t = e.attr("data-original-title") || ("function" == typeof n.title ? n.title.call(e[0]) : n.title)
        },
        tip: function() {
            return this.$tip = this.$tip || t(this.options.template)
        },
        arrow: function() {
            return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
        },
        validate: function() {
            this.$element[0].parentNode || (this.hide(), this.$element = null, this.options = null)
        },
        enable: function() {
            this.enabled = !0
        },
        disable: function() {
            this.enabled = !1
        },
        toggleEnabled: function() {
            this.enabled = !this.enabled
        },
        toggle: function(e) {
            var n = e ? t(e.currentTarget)[this.type](this._options).data(this.type) : this;
            n.tip().hasClass("in") ? n.hide() : n.show()
        },
        destroy: function() {
            this.hide().$element.off("." + this.type).removeData(this.type)
        }
    };
    var n = t.fn.tooltip;
    t.fn.tooltip = function(n) {
        return this.each(function() {
            var o = t(this),
                i = o.data("tooltip"),
                a = "object" == typeof n && n;
            i || o.data("tooltip", i = new e(this, a)), "string" == typeof n && i[n]()
        })
    }, t.fn.tooltip.Constructor = e, t.fn.tooltip.defaults = {
        animation: !0,
        placement: "top",
        selector: !1,
        template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        trigger: "hover focus",
        title: "",
        delay: 0,
        html: !1,
        container: !1
    }, t.fn.tooltip.noConflict = function() {
        return t.fn.tooltip = n, this
    }
}(window.jQuery), ! function(t) {
    "use strict";
    var e = function(t, e) {
        this.init("popover", t, e)
    };
    e.prototype = t.extend({}, t.fn.tooltip.Constructor.prototype, {
        constructor: e,
        setContent: function() {
            var t = this.tip(),
                e = this.getTitle(),
                n = this.getContent();
            t.find(".popover-title")[this.options.html ? "html" : "text"](e), t.find(".popover-content")[this.options.html ? "html" : "text"](n), t.removeClass("fade top bottom left right in")
        },
        hasContent: function() {
            return this.getTitle() || this.getContent()
        },
        getContent: function() {
            var t, e = this.$element,
                n = this.options;
            return t = ("function" == typeof n.content ? n.content.call(e[0]) : n.content) || e.attr("data-content")
        },
        tip: function() {
            return this.$tip || (this.$tip = t(this.options.template)), this.$tip
        },
        destroy: function() {
            this.hide().$element.off("." + this.type).removeData(this.type)
        }
    });
    var n = t.fn.popover;
    t.fn.popover = function(n) {
        return this.each(function() {
            var o = t(this),
                i = o.data("popover"),
                a = "object" == typeof n && n;
            i || o.data("popover", i = new e(this, a)), "string" == typeof n && i[n]()
        })
    }, t.fn.popover.Constructor = e, t.fn.popover.defaults = t.extend({}, t.fn.tooltip.defaults, {
        placement: "right",
        trigger: "click",
        content: "",
        template: '<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    }), t.fn.popover.noConflict = function() {
        return t.fn.popover = n, this
    }
}(window.jQuery), ! function(t) {
    "use strict";

    function e(e, n) {
        var o, i = t.proxy(this.process, this),
            a = t(t(e).is("body") ? window : e);
        this.options = t.extend({}, t.fn.scrollspy.defaults, n), this.$scrollElement = a.on("scroll.scroll-spy.data-api", i), this.selector = (this.options.target || (o = t(e).attr("href")) && o.replace(/.*(?=#[^\s]+$)/, "") || "") + " .nav li > a", this.$body = t("body"), this.refresh(), this.process()
    }
    e.prototype = {
        constructor: e,
        refresh: function() {
            var e, n = this;
            this.offsets = t([]), this.targets = t([]), e = this.$body.find(this.selector).map(function() {
                var e = t(this),
                    o = e.data("target") || e.attr("href"),
                    i = /^#\w/.test(o) && t(o);
                return i && i.length && [
                    [i.position().top + (!t.isWindow(n.$scrollElement.get(0)) && n.$scrollElement.scrollTop()), o]
                ] || null
            }).sort(function(t, e) {
                return t[0] - e[0]
            }).each(function() {
                n.offsets.push(this[0]), n.targets.push(this[1])
            })
        },
        process: function() {
            var t, e = this.$scrollElement.scrollTop() + this.options.offset,
                n = this.$scrollElement[0].scrollHeight || this.$body[0].scrollHeight,
                o = n - this.$scrollElement.height(),
                i = this.offsets,
                a = this.targets,
                s = this.activeTarget;
            if (e >= o) return s != (t = a.last()[0]) && this.activate(t);
            for (t = i.length; t--;) s != a[t] && e >= i[t] && (!i[t + 1] || e <= i[t + 1]) && this.activate(a[t])
        },
        activate: function(e) {
            var n, o;
            this.activeTarget = e, t(this.selector).parent(".active").removeClass("active"), o = this.selector + '[data-target="' + e + '"],' + this.selector + '[href="' + e + '"]', n = t(o).parent("li").addClass("active"), n.parent(".dropdown-menu").length && (n = n.closest("li.dropdown").addClass("active")), n.trigger("activate")
        }
    };
    var n = t.fn.scrollspy;
    t.fn.scrollspy = function(n) {
        return this.each(function() {
            var o = t(this),
                i = o.data("scrollspy"),
                a = "object" == typeof n && n;
            i || o.data("scrollspy", i = new e(this, a)), "string" == typeof n && i[n]()
        })
    }, t.fn.scrollspy.Constructor = e, t.fn.scrollspy.defaults = {
        offset: 10
    }, t.fn.scrollspy.noConflict = function() {
        return t.fn.scrollspy = n, this
    }, t(window).on("load", function() {
        t('[data-spy="scroll"]').each(function() {
            var e = t(this);
            e.scrollspy(e.data())
        })
    })
}(window.jQuery), ! function(t) {
    "use strict";
    var e = function(e) {
        this.element = t(e)
    };
    e.prototype = {
        constructor: e,
        show: function() {
            var e, n, o, i = this.element,
                a = i.closest("ul:not(.dropdown-menu)"),
                s = i.attr("data-target");
            s || (s = i.attr("href"), s = s && s.replace(/.*(?=#[^\s]*$)/, "")), i.parent("li").hasClass("active") || (e = a.find(".active:last a")[0], o = t.Event("show", {
                relatedTarget: e
            }), i.trigger(o), o.isDefaultPrevented() || (n = t(s), this.activate(i.parent("li"), a), this.activate(n, n.parent(), function() {
                i.trigger({
                    type: "shown",
                    relatedTarget: e
                })
            })))
        },
        activate: function(e, n, o) {
            function i() {
                a.removeClass("active").find("> .dropdown-menu > .active").removeClass("active"), e.addClass("active"), s ? (e[0].offsetWidth, e.addClass("in")) : e.removeClass("fade"), e.parent(".dropdown-menu") && e.closest("li.dropdown").addClass("active"), o && o()
            }
            var a = n.find("> .active"),
                s = o && t.support.transition && a.hasClass("fade");
            s ? a.one(t.support.transition.end, i) : i(), a.removeClass("in")
        }
    };
    var n = t.fn.tab;
    t.fn.tab = function(n) {
        return this.each(function() {
            var o = t(this),
                i = o.data("tab");
            i || o.data("tab", i = new e(this)), "string" == typeof n && i[n]()
        })
    }, t.fn.tab.Constructor = e, t.fn.tab.noConflict = function() {
        return t.fn.tab = n, this
    }, t(document).on("click.tab.data-api", '[data-toggle="tab"], [data-toggle="pill"]', function(e) {
        e.preventDefault(), t(this).tab("show")
    })
}(window.jQuery), ! function(t) {
    "use strict";
    var e = function(e, n) {
        this.$element = t(e), this.options = t.extend({}, t.fn.typeahead.defaults, n), this.matcher = this.options.matcher || this.matcher, this.sorter = this.options.sorter || this.sorter, this.highlighter = this.options.highlighter || this.highlighter, this.updater = this.options.updater || this.updater, this.source = this.options.source, this.$menu = t(this.options.menu), this.shown = !1, this.listen()
    };
    e.prototype = {
        constructor: e,
        select: function() {
            var t = this.$menu.find(".active").attr("data-value");
            return this.$element.val(this.updater(t)).change(), this.hide()
        },
        updater: function(t) {
            return t
        },
        show: function() {
            var e = t.extend({}, this.$element.position(), {
                height: this.$element[0].offsetHeight
            });
            return this.$menu.insertAfter(this.$element).css({
                top: e.top + e.height,
                left: e.left
            }).show(), this.shown = !0, this
        },
        hide: function() {
            return this.$menu.hide(), this.shown = !1, this
        },
        lookup: function(e) {
            var n;
            return this.query = this.$element.val(), !this.query || this.query.length < this.options.minLength ? this.shown ? this.hide() : this : (n = t.isFunction(this.source) ? this.source(this.query, t.proxy(this.process, this)) : this.source, n ? this.process(n) : this)
        },
        process: function(e) {
            var n = this;
            return e = t.grep(e, function(t) {
                return n.matcher(t)
            }), e = this.sorter(e), e.length ? this.render(e.slice(0, this.options.items)).show() : this.shown ? this.hide() : this
        },
        matcher: function(t) {
            return ~t.toLowerCase().indexOf(this.query.toLowerCase())
        },
        sorter: function(t) {
            for (var e, n = [], o = [], i = []; e = t.shift();) e.toLowerCase().indexOf(this.query.toLowerCase()) ? ~e.indexOf(this.query) ? o.push(e) : i.push(e) : n.push(e);
            return n.concat(o, i)
        },
        highlighter: function(t) {
            var e = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
            return t.replace(new RegExp("(" + e + ")", "ig"), function(t, e) {
                return "<strong>" + e + "</strong>"
            })
        },
        render: function(e) {
            var n = this;
            return e = t(e).map(function(e, o) {
                return e = t(n.options.item).attr("data-value", o), e.find("a").html(n.highlighter(o)), e[0]
            }), e.first().addClass("active"), this.$menu.html(e), this
        },
        next: function(e) {
            var n = this.$menu.find(".active").removeClass("active"),
                o = n.next();
            o.length || (o = t(this.$menu.find("li")[0])), o.addClass("active")
        },
        prev: function(t) {
            var e = this.$menu.find(".active").removeClass("active"),
                n = e.prev();
            n.length || (n = this.$menu.find("li").last()), n.addClass("active")
        },
        listen: function() {
            this.$element.on("focus", t.proxy(this.focus, this)).on("blur", t.proxy(this.blur, this)).on("keypress", t.proxy(this.keypress, this)).on("keyup", t.proxy(this.keyup, this)), this.eventSupported("keydown") && this.$element.on("keydown", t.proxy(this.keydown, this)), this.$menu.on("click", t.proxy(this.click, this)).on("mouseenter", "li", t.proxy(this.mouseenter, this)).on("mouseleave", "li", t.proxy(this.mouseleave, this))
        },
        eventSupported: function(t) {
            var e = t in this.$element;
            return e || (this.$element.setAttribute(t, "return;"), e = "function" == typeof this.$element[t]), e
        },
        move: function(t) {
            if (this.shown) {
                switch (t.keyCode) {
                    case 9:
                    case 13:
                    case 27:
                        t.preventDefault();
                        break;
                    case 38:
                        t.preventDefault(), this.prev();
                        break;
                    case 40:
                        t.preventDefault(), this.next()
                }
                t.stopPropagation()
            }
        },
        keydown: function(e) {
            this.suppressKeyPressRepeat = ~t.inArray(e.keyCode, [40, 38, 9, 13, 27]), this.move(e)
        },
        keypress: function(t) {
            this.suppressKeyPressRepeat || this.move(t)
        },
        keyup: function(t) {
            switch (t.keyCode) {
                case 40:
                case 38:
                case 16:
                case 17:
                case 18:
                    break;
                case 9:
                case 13:
                    if (!this.shown) return;
                    this.select();
                    break;
                case 27:
                    if (!this.shown) return;
                    this.hide();
                    break;
                default:
                    this.lookup()
            }
            t.stopPropagation(), t.preventDefault()
        },
        focus: function(t) {
            this.focused = !0
        },
        blur: function(t) {
            this.focused = !1, !this.mousedover && this.shown && this.hide()
        },
        click: function(t) {
            t.stopPropagation(), t.preventDefault(), this.select(), this.$element.focus()
        },
        mouseenter: function(e) {
            this.mousedover = !0, this.$menu.find(".active").removeClass("active"), t(e.currentTarget).addClass("active")
        },
        mouseleave: function(t) {
            this.mousedover = !1, !this.focused && this.shown && this.hide()
        }
    };
    var n = t.fn.typeahead;
    t.fn.typeahead = function(n) {
        return this.each(function() {
            var o = t(this),
                i = o.data("typeahead"),
                a = "object" == typeof n && n;
            i || o.data("typeahead", i = new e(this, a)), "string" == typeof n && i[n]()
        })
    }, t.fn.typeahead.defaults = {
        source: [],
        items: 8,
        menu: '<ul class="typeahead dropdown-menu"></ul>',
        item: '<li><a href="#"></a></li>',
        minLength: 1
    }, t.fn.typeahead.Constructor = e, t.fn.typeahead.noConflict = function() {
        return t.fn.typeahead = n, this
    }, t(document).on("focus.typeahead.data-api", '[data-provide="typeahead"]', function(e) {
        var n = t(this);
        n.data("typeahead") || n.typeahead(n.data())
    })
}(window.jQuery), ! function(t) {
    "use strict";
    var e = function(e, n) {
        this.options = n, this.$element = t(e).delegate('[data-dismiss="lightbox"]', "click.dismiss.lightbox", t.proxy(this.hide, this)), this.options.remote && this.$element.find(".lightbox-body").load(this.options.remote)
    };
    e.prototype = t.extend({}, t.fn.modal.Constructor.prototype), e.prototype.constructor = e, e.prototype.enforceFocus = function() {
        var e = this;
        t(document).on("focusin.lightbox", function(t) {
            e.$element[0] === t.target || e.$element.has(t.target).length || e.$element.focus()
        })
    }, e.prototype.show = function() {
        var e = this,
            n = t.Event("show");
        this.$element.trigger(n), this.isShown || n.isDefaultPrevented() || (this.isShown = !0, this.escape(), this.preloadSize(function() {
            e.backdrop(function() {
                var n = t.support.transition && e.$element.hasClass("fade");
                e.$element.parent().length || e.$element.appendTo(document.body), e.$element.show(), n && e.$element[0].offsetWidth, e.$element.addClass("in").attr("aria-hidden", !1), e.enforceFocus(), n ? e.$element.one(t.support.transition.end, function() {
                    e.$element.focus().trigger("shown")
                }) : e.$element.focus().trigger("shown")
            })
        }))
    }, e.prototype.hide = function(e) {
        e && e.preventDefault();
        e = t.Event("hide"), this.$element.trigger(e), this.isShown && !e.isDefaultPrevented() && (this.isShown = !1, this.escape(), t(document).off("focusin.lightbox"), this.$element.removeClass("in").attr("aria-hidden", !0), t.support.transition && this.$element.hasClass("fade") ? this.hideWithTransition() : this.hideModal())
    }, e.prototype.escape = function() {
        var t = this;
        this.isShown && this.options.keyboard ? this.$element.on("keyup.dismiss.lightbox", function(e) {
            27 == e.which && t.hide()
        }) : this.isShown || this.$element.off("keyup.dismiss.lightbox")
    }, e.prototype.preloadSize = function(e) {
        var n = t.Callbacks();
        e && n.add(e);
        var o, i, a, s, r, l, c, u, d, h, f = this;
        o = t(window).height(), i = t(window).width(), a = parseInt(f.$element.find(".lightbox-content").css("padding-top"), 10), s = parseInt(f.$element.find(".lightbox-content").css("padding-bottom"), 10), r = parseInt(f.$element.find(".lightbox-content").css("padding-left"), 10), l = parseInt(f.$element.find(".lightbox-content").css("padding-right"), 10), c = f.$element.find(".lightbox-content").find("img:first"), u = new Image, u.onload = function() {
            u.width + r + l >= i && (d = u.width, h = u.height, u.width = i - r - l, u.height = h / d * u.width), u.height + a + s >= o && (d = u.width, h = u.height, u.height = o - a - s, u.width = d / h * u.height), f.$element.css({
                position: "fixed",
                width: u.width + r + l,
                height: u.height + a + s,
                top: o / 2 - (u.height + a + s) / 2,
                left: "50%",
                "margin-left": -1 * (u.width + r + l) / 2
            }), f.$element.find(".lightbox-content").css({
                width: u.width,
                height: u.height
            }), n.fire()
        }, u.src = c.attr("src")
    };
    var n = t.fn.lightbox;
    t.fn.lightbox = function(n) {
        return this.each(function() {
            var o = t(this),
                i = o.data("lightbox"),
                a = t.extend({}, t.fn.lightbox.defaults, o.data(), "object" == typeof n && n);
            i || o.data("lightbox", i = new e(this, a)), "string" == typeof n ? i[n]() : a.show && i.show()
        })
    }, t.fn.lightbox.defaults = {
        backdrop: !0,
        keyboard: !0,
        show: !0
    }, t.fn.lightbox.Constructor = e, t.fn.lightbox.noConflict = function() {
        return t.fn.lightbox = n, this
    }, t(document).on("click.lightbox.data-api", '[data-toggle="lightbox"]', function(e) {
        var n = t(this),
            o = n.attr("href"),
            i = t(n.attr("data-target") || o && o.replace(/.*(?=#[^\s]+$)/, "")),
            a = i.data("lightbox") ? "toggle" : t.extend({
                remote: !/#/.test(o) && o
            }, i.data(), n.data());
        e.preventDefault(), i.lightbox(a).one("hide", function() {
            n.focus()
        })
    })
}(window.jQuery),
function(t, e) {
    function n(t) {
        for (var e, n = t.split(/\s+/), o = [], i = 0; e = n[i]; i++) e = e[0].toUpperCase(), o.push(e);
        return o
    }

    function o(e) {
        return e.id && t('label[for="' + e.id + '"]').val() || e.name
    }

    function i(n, a, s) {
        return s || (s = 0), a.each(function() {
            var a, r, l = t(this),
                c = this,
                u = this.nodeName.toLowerCase();
            switch ("label" == u && l.find("input, textarea, select").length && (a = l.text(), l = l.children().first(), c = l.get(0), u = c.nodeName.toLowerCase()), u) {
                case "menu":
                    r = {
                        name: l.attr("label"),
                        items: {}
                    }, s = i(r.items, l.children(), s);
                    break;
                case "a":
                case "button":
                    r = {
                        name: l.text(),
                        disabled: !!l.attr("disabled"),
                        callback: function() {
                            return function() {
                                l.click()
                            }
                        }()
                    };
                    break;
                case "menuitem":
                case "command":
                    switch (l.attr("type")) {
                        case e:
                        case "command":
                        case "menuitem":
                            r = {
                                name: l.attr("label"),
                                disabled: !!l.attr("disabled"),
                                callback: function() {
                                    return function() {
                                        l.click()
                                    }
                                }()
                            };
                            break;
                        case "checkbox":
                            r = {
                                type: "checkbox",
                                disabled: !!l.attr("disabled"),
                                name: l.attr("label"),
                                selected: !!l.attr("checked")
                            };
                            break;
                        case "radio":
                            r = {
                                type: "radio",
                                disabled: !!l.attr("disabled"),
                                name: l.attr("label"),
                                radio: l.attr("radiogroup"),
                                value: l.attr("id"),
                                selected: !!l.attr("checked")
                            };
                            break;
                        default:
                            r = e
                    }
                    break;
                case "hr":
                    r = "-------";
                    break;
                case "input":
                    switch (l.attr("type")) {
                        case "text":
                            r = {
                                type: "text",
                                name: a || o(c),
                                disabled: !!l.attr("disabled"),
                                value: l.val()
                            };
                            break;
                        case "checkbox":
                            r = {
                                type: "checkbox",
                                name: a || o(c),
                                disabled: !!l.attr("disabled"),
                                selected: !!l.attr("checked")
                            };
                            break;
                        case "radio":
                            r = {
                                type: "radio",
                                name: a || o(c),
                                disabled: !!l.attr("disabled"),
                                radio: !!l.attr("name"),
                                value: l.val(),
                                selected: !!l.attr("checked")
                            };
                            break;
                        default:
                            r = e
                    }
                    break;
                case "select":
                    r = {
                        type: "select",
                        name: a || o(c),
                        disabled: !!l.attr("disabled"),
                        selected: l.val(),
                        options: {}
                    }, l.children().each(function() {
                        r.options[this.value] = t(this).text()
                    });
                    break;
                case "textarea":
                    r = {
                        type: "textarea",
                        name: a || o(c),
                        disabled: !!l.attr("disabled"),
                        value: l.val()
                    };
                    break;
                case "label":
                    break;
                default:
                    r = {
                        type: "html",
                        html: l.clone(!0)
                    }
            }
            r && (s++, n["key" + s] = r)
        }), s
    }
    if (t.support.htmlMenuitem = "HTMLMenuItemElement" in window, t.support.htmlCommand = "HTMLCommandElement" in window, t.support.eventSelectstart = "onselectstart" in document.documentElement, !t.ui || !t.ui.widget) {
        var a = t.cleanData;
        t.cleanData = function(e) {
            for (var n, o = 0; null != (n = e[o]); o++) try {
                t(n).triggerHandler("remove")
            } catch (i) {}
            a(e)
        }
    }
    var s = null,
        r = !1,
        l = t(window),
        c = 0,
        u = {},
        d = {},
        h = {},
        f = {
            selector: null,
            appendTo: null,
            trigger: "right",
            autoHide: !1,
            delay: 200,
            reposition: !0,
            determinePosition: function(e) {
                if (t.ui && t.ui.position) e.css("display", "block").position({
                    my: "center top",
                    at: "center bottom",
                    of: this,
                    offset: "0 5",
                    collision: "fit"
                }).css("display", "none");
                else {
                    var n = this.offset();
                    n.top += this.outerHeight(), n.left += this.outerWidth() / 2 - e.outerWidth() / 2, e.css(n)
                }
            },
            position: function(t, e, n) {
                var o;
                if (!e && !n) return void t.determinePosition.call(this, t.$menu);
                o = "maintain" === e && "maintain" === n ? t.$menu.position() : {
                    top: n,
                    left: e
                };
                var i = l.scrollTop() + l.height(),
                    a = l.scrollLeft() + l.width(),
                    s = t.$menu.height(),
                    r = t.$menu.width();
                o.top + s > i && (o.top -= s), o.left + r > a && (o.left -= r), t.$menu.css(o)
            },
            positionSubmenu: function(e) {
                if (t.ui && t.ui.position) e.css("display", "block").position({
                    my: "left top",
                    at: "right top",
                    of: this,
                    collision: "flipfit fit"
                }).css("display", "");
                else {
                    var n = {
                        top: 0,
                        left: this.outerWidth()
                    };
                    e.css(n)
                }
            },
            zIndex: 1,
            animation: {
                duration: 50,
                show: "slideDown",
                hide: "slideUp"
            },
            events: {
                show: t.noop,
                hide: t.noop
            },
            callback: null,
            items: {}
        },
        p = {
            timer: null,
            pageX: null,
            pageY: null
        },
        m = function(t) {
            for (var e = 0, n = t;;)
                if (e = Math.max(e, parseInt(n.css("z-index"), 10) || 0), n = n.parent(), !n || !n.length || "html body".indexOf(n.prop("nodeName").toLowerCase()) > -1) break;
            return e
        },
        g = {
            abortevent: function(t) {
                t.preventDefault(), t.stopImmediatePropagation()
            },
            contextmenu: function(e) {
                var n = t(this);
                if (e.preventDefault(), e.stopImmediatePropagation(), !("right" != e.data.trigger && e.originalEvent || n.hasClass("context-menu-active") || n.hasClass("context-menu-disabled"))) {
                    if (s = n, e.data.build) {
                        var o = e.data.build(s, e);
                        if (o === !1) return;
                        if (e.data = t.extend(!0, {}, f, e.data, o || {}), !e.data.items || t.isEmptyObject(e.data.items)) throw window.console && (console.error || console.log)("No items specified to show in contextMenu"), new Error("No Items specified");
                        e.data.$trigger = s, v.create(e.data)
                    }
                    v.show.call(n, e.data, e.pageX, e.pageY)
                }
            },
            click: function(e) {
                e.preventDefault(), e.stopImmediatePropagation(), t(this).trigger(t.Event("contextmenu", {
                    data: e.data,
                    pageX: e.pageX,
                    pageY: e.pageY
                }))
            },
            mousedown: function(e) {
                var n = t(this);
                s && s.length && !s.is(n) && s.data("contextMenu").$menu.trigger("contextmenu:hide"), 2 == e.button && (s = n.data("contextMenuActive", !0))
            },
            mouseup: function(e) {
                var n = t(this);
                n.data("contextMenuActive") && s && s.length && s.is(n) && !n.hasClass("context-menu-disabled") && (e.preventDefault(), e.stopImmediatePropagation(), s = n, n.trigger(t.Event("contextmenu", {
                    data: e.data,
                    pageX: e.pageX,
                    pageY: e.pageY
                }))), n.removeData("contextMenuActive")
            },
            mouseenter: function(e) {
                var n = t(this),
                    o = t(e.relatedTarget),
                    i = t(document);
                o.is(".context-menu-list") || o.closest(".context-menu-list").length || s && s.length || (p.pageX = e.pageX, p.pageY = e.pageY, p.data = e.data, i.on("mousemove.contextMenuShow", g.mousemove), p.timer = setTimeout(function() {
                    p.timer = null, i.off("mousemove.contextMenuShow"), s = n, n.trigger(t.Event("contextmenu", {
                        data: p.data,
                        pageX: p.pageX,
                        pageY: p.pageY
                    }))
                }, e.data.delay))
            },
            mousemove: function(t) {
                p.pageX = t.pageX, p.pageY = t.pageY
            },
            mouseleave: function(e) {
                var n = t(e.relatedTarget);
                if (!n.is(".context-menu-list") && !n.closest(".context-menu-list").length) {
                    try {
                        clearTimeout(p.timer)
                    } catch (e) {}
                    p.timer = null
                }
            },
            layerClick: function(e) {
                var n, o, i = t(this),
                    a = i.data("contextMenuRoot"),
                    s = e.button,
                    r = e.pageX,
                    c = e.pageY;
                e.preventDefault(), e.stopImmediatePropagation(), setTimeout(function() {
                    var i, u = "left" == a.trigger && 0 === s || "right" == a.trigger && 2 === s;
                    if (document.elementFromPoint && (a.$layer.hide(), n = document.elementFromPoint(r - l.scrollLeft(), c - l.scrollTop()), a.$layer.show()), a.reposition && u)
                        if (document.elementFromPoint) {
                            if (a.$trigger.is(n) || a.$trigger.has(n).length) return void a.position.call(a.$trigger, a, r, c)
                        } else if (o = a.$trigger.offset(), i = t(window), o.top += i.scrollTop(), o.top <= e.pageY && (o.left += i.scrollLeft(), o.left <= e.pageX && (o.bottom = o.top + a.$trigger.outerHeight(), o.bottom >= e.pageY && (o.right = o.left + a.$trigger.outerWidth(), o.right >= e.pageX)))) return void a.position.call(a.$trigger, a, r, c);
                    n && u && a.$trigger.one("contextmenu:hidden", function() {
                        t(n).contextMenu({
                            x: r,
                            y: c
                        })
                    }), a.$menu.trigger("contextmenu:hide")
                }, 50)
            },
            keyStop: function(t, e) {
                e.isInput || t.preventDefault(), t.stopPropagation()
            },
            key: function(t) {
                var e = s.data("contextMenu") || {};
                switch (t.keyCode) {
                    case 9:
                    case 38:
                        if (g.keyStop(t, e), e.isInput) {
                            if (9 == t.keyCode && t.shiftKey) return t.preventDefault(), e.$selected && e.$selected.find("input, textarea, select").blur(), void e.$menu.trigger("prevcommand");
                            if (38 == t.keyCode && "checkbox" == e.$selected.find("input, textarea, select").prop("type")) return void t.preventDefault()
                        } else if (9 != t.keyCode || t.shiftKey) return void e.$menu.trigger("prevcommand");
                    case 40:
                        if (g.keyStop(t, e), !e.isInput) return void e.$menu.trigger("nextcommand");
                        if (9 == t.keyCode) return t.preventDefault(), e.$selected && e.$selected.find("input, textarea, select").blur(), void e.$menu.trigger("nextcommand");
                        if (40 == t.keyCode && "checkbox" == e.$selected.find("input, textarea, select").prop("type")) return void t.preventDefault();
                        break;
                    case 37:
                        if (g.keyStop(t, e), e.isInput || !e.$selected || !e.$selected.length) break;
                        if (!e.$selected.parent().hasClass("context-menu-root")) {
                            var n = e.$selected.parent().parent();
                            return e.$selected.trigger("contextmenu:blur"), void(e.$selected = n)
                        }
                        break;
                    case 39:
                        if (g.keyStop(t, e), e.isInput || !e.$selected || !e.$selected.length) break;
                        var o = e.$selected.data("contextMenu") || {};
                        if (o.$menu && e.$selected.hasClass("context-menu-submenu")) return e.$selected = null, o.$selected = null, void o.$menu.trigger("nextcommand");
                        break;
                    case 35:
                    case 36:
                        return e.$selected && e.$selected.find("input, textarea, select").length ? void 0 : ((e.$selected && e.$selected.parent() || e.$menu).children(":not(.disabled, .not-selectable)")[36 == t.keyCode ? "first" : "last"]().trigger("contextmenu:focus"), void t.preventDefault());
                    case 13:
                        if (g.keyStop(t, e), e.isInput) {
                            if (e.$selected && !e.$selected.is("textarea, select")) return void t.preventDefault();
                            break
                        }
                        return void(e.$selected && e.$selected.trigger("mouseup"));
                    case 32:
                    case 33:
                    case 34:
                        return void g.keyStop(t, e);
                    case 27:
                        return g.keyStop(t, e), void e.$menu.trigger("contextmenu:hide");
                    default:
                        var i = String.fromCharCode(t.keyCode).toUpperCase();
                        if (e.accesskeys[i]) return void e.accesskeys[i].$node.trigger(e.accesskeys[i].$menu ? "contextmenu:focus" : "mouseup")
                }
                t.stopPropagation(), e.$selected && e.$selected.trigger(t)
            },
            prevItem: function(e) {
                e.stopPropagation();
                var n = t(this).data("contextMenu") || {};
                if (n.$selected) {
                    var o = n.$selected;
                    n = n.$selected.parent().data("contextMenu") || {}, n.$selected = o
                }
                for (var i = n.$menu.children(), a = n.$selected && n.$selected.prev().length ? n.$selected.prev() : i.last(), s = a; a.hasClass("disabled") || a.hasClass("not-selectable");)
                    if (a = a.prev().length ? a.prev() : i.last(), a.is(s)) return;
                n.$selected && g.itemMouseleave.call(n.$selected.get(0), e), g.itemMouseenter.call(a.get(0), e);
                var r = a.find("input, textarea, select");
                r.length && r.focus()
            },
            nextItem: function(e) {
                e.stopPropagation();
                var n = t(this).data("contextMenu") || {};
                if (n.$selected) {
                    var o = n.$selected;
                    n = n.$selected.parent().data("contextMenu") || {}, n.$selected = o
                }
                for (var i = n.$menu.children(), a = n.$selected && n.$selected.next().length ? n.$selected.next() : i.first(), s = a; a.hasClass("disabled") || a.hasClass("not-selectable");)
                    if (a = a.next().length ? a.next() : i.first(), a.is(s)) return;
                n.$selected && g.itemMouseleave.call(n.$selected.get(0), e), g.itemMouseenter.call(a.get(0), e);
                var r = a.find("input, textarea, select");
                r.length && r.focus()
            },
            focusInput: function(e) {
                var n = t(this).closest(".context-menu-item"),
                    o = n.data(),
                    i = o.contextMenu,
                    a = o.contextMenuRoot;
                a.$selected = i.$selected = n, a.isInput = i.isInput = !0
            },
            blurInput: function(e) {
                var n = t(this).closest(".context-menu-item"),
                    o = n.data(),
                    i = o.contextMenu,
                    a = o.contextMenuRoot;
                a.isInput = i.isInput = !1
            },
            menuMouseenter: function(e) {
                var n = t(this).data().contextMenuRoot;
                n.hovering = !0
            },
            menuMouseleave: function(e) {
                var n = t(this).data().contextMenuRoot;
                n.$layer && n.$layer.is(e.relatedTarget) && (n.hovering = !1)
            },
            itemMouseenter: function(e) {
                var n = t(this),
                    o = n.data(),
                    i = o.contextMenu,
                    a = o.contextMenuRoot;
                return a.hovering = !0, e && a.$layer && a.$layer.is(e.relatedTarget) && (e.preventDefault(), e.stopImmediatePropagation()), (i.$menu ? i : a).$menu.children(".hover").trigger("contextmenu:blur"), n.hasClass("disabled") || n.hasClass("not-selectable") ? void(i.$selected = null) : void n.trigger("contextmenu:focus")
            },
            itemMouseleave: function(e) {
                var n = t(this),
                    o = n.data(),
                    i = o.contextMenu,
                    a = o.contextMenuRoot;
                return a !== i && a.$layer && a.$layer.is(e.relatedTarget) ? (a.$selected && a.$selected.trigger("contextmenu:blur"), e.preventDefault(), e.stopImmediatePropagation(), void(a.$selected = i.$selected = i.$node)) : void n.trigger("contextmenu:blur")
            },
            itemClick: function(e) {
                var n, o = t(this),
                    i = o.data(),
                    a = i.contextMenu,
                    s = i.contextMenuRoot,
                    r = i.contextMenuKey;
                if (a.items[r] && !o.is(".disabled, .context-menu-submenu, .context-menu-separator, .not-selectable")) {
                    if (e.preventDefault(), e.stopImmediatePropagation(), t.isFunction(s.callbacks[r]) && Object.prototype.hasOwnProperty.call(s.callbacks, r)) n = s.callbacks[r];
                    else {
                        if (!t.isFunction(s.callback)) return;
                        n = s.callback
                    }
                    n.call(s.$trigger, r, s) !== !1 ? s.$menu.trigger("contextmenu:hide") : s.$menu.parent().length && v.update.call(s.$trigger, s)
                }
            },
            inputClick: function(t) {
                t.stopImmediatePropagation()
            },
            hideMenu: function(e, n) {
                var o = t(this).data("contextMenuRoot");
                v.hide.call(o.$trigger, o, n && n.force)
            },
            focusItem: function(e) {
                e.stopPropagation();
                var n = t(this),
                    o = n.data(),
                    i = o.contextMenu,
                    a = o.contextMenuRoot;
                n.addClass("hover").siblings(".hover").trigger("contextmenu:blur"), i.$selected = a.$selected = n, i.$node && a.positionSubmenu.call(i.$node, i.$menu)
            },
            blurItem: function(e) {
                e.stopPropagation();
                var n = t(this),
                    o = n.data(),
                    i = o.contextMenu;
                o.contextMenuRoot;
                n.removeClass("hover"), i.$selected = null
            }
        },
        v = {
            show: function(e, n, o) {
                var i = t(this),
                    a = {};
                return t("#context-menu-layer").trigger("mousedown"), e.$trigger = i, e.events.show.call(i, e) === !1 ? void(s = null) : (v.update.call(i, e), e.position.call(i, e, n, o), e.zIndex && (a.zIndex = m(i) + e.zIndex), v.layer.call(e.$menu, e, a.zIndex), e.$menu.find("ul").css("zIndex", a.zIndex + 1), e.$menu.css(a)[e.animation.show](e.animation.duration, function() {
                    i.trigger("contextmenu:visible")
                }), i.data("contextMenu", e).addClass("context-menu-active"), t(document).off("keydown.contextMenu").on("keydown.contextMenu", g.key), void(e.autoHide && t(document).on("mousemove.contextMenuAutoHide", function(t) {
                    var n = i.offset();
                    n.right = n.left + i.outerWidth(), n.bottom = n.top + i.outerHeight(), !e.$layer || e.hovering || t.pageX >= n.left && t.pageX <= n.right && t.pageY >= n.top && t.pageY <= n.bottom || e.$menu.trigger("contextmenu:hide")
                })))
            },
            hide: function(n, o) {
                var i = t(this);
                if (n || (n = i.data("contextMenu") || {}), o || !n.events || n.events.hide.call(i, n) !== !1) {
                    if (i.removeData("contextMenu").removeClass("context-menu-active"), n.$layer) {
                        setTimeout(function(t) {
                            return function() {
                                t.remove()
                            }
                        }(n.$layer), 10);
                        try {
                            delete n.$layer
                        } catch (a) {
                            n.$layer = null
                        }
                    }
                    s = null, n.$menu.find(".hover").trigger("contextmenu:blur"), n.$selected = null, t(document).off(".contextMenuAutoHide").off("keydown.contextMenu"), n.$menu && n.$menu[n.animation.hide](n.animation.duration, function() {
                        n.build && (n.$menu.remove(), t.each(n, function(t, o) {
                            switch (t) {
                                case "ns":
                                case "selector":
                                case "build":
                                case "trigger":
                                    return !0;
                                default:
                                    n[t] = e;
                                    try {
                                        delete n[t]
                                    } catch (i) {}
                                    return !0
                            }
                        })), setTimeout(function() {
                            i.trigger("contextmenu:hidden")
                        }, 10)
                    })
                }
            },
            create: function(o, i) {
                i === e && (i = o), o.$menu = t('<ul class="context-menu-list"></ul>').addClass(o.className || "").data({
                    contextMenu: o,
                    contextMenuRoot: i
                }), t.each(["callbacks", "commands", "inputs"], function(t, e) {
                    o[e] = {}, i[e] || (i[e] = {})
                }), i.accesskeys || (i.accesskeys = {}), t.each(o.items, function(e, a) {
                    var s = t('<li class="context-menu-item"></li>').addClass(a.className || ""),
                        r = null,
                        l = null;
                    if (s.on("click", t.noop), a.$node = s.data({
                            contextMenu: o,
                            contextMenuRoot: i,
                            contextMenuKey: e
                        }), a.accesskey)
                        for (var c, u = n(a.accesskey), d = 0; c = u[d]; d++)
                            if (!i.accesskeys[c]) {
                                i.accesskeys[c] = a, a._name = a.name.replace(new RegExp("(" + c + ")", "i"), '<span class="context-menu-accesskey">$1</span>');
                                break
                            } if ("string" == typeof a) s.addClass("context-menu-separator not-selectable");
                    else if (a.type && h[a.type]) h[a.type].call(s, a, o, i), t.each([o, i], function(n, o) {
                        o.commands[e] = a, t.isFunction(a.callback) && (o.callbacks[e] = a.callback)
                    });
                    else {
                        switch ("html" == a.type ? s.addClass("context-menu-html not-selectable") : a.type ? (r = t("<label></label>").appendTo(s), t("<span></span>").html(a._name || a.name).appendTo(r), s.addClass("context-menu-input"), o.hasTypes = !0, t.each([o, i], function(t, n) {
                            n.commands[e] = a, n.inputs[e] = a
                        })) : a.items && (a.type = "sub"), a.type) {
                            case "text":
                                l = t('<input type="text" value="1" name="" value="">').attr("name", "context-menu-input-" + e).val(a.value || "").appendTo(r);
                                break;
                            case "textarea":
                                l = t('<textarea name=""></textarea>').attr("name", "context-menu-input-" + e).val(a.value || "").appendTo(r), a.height && l.height(a.height);
                                break;
                            case "checkbox":
                                l = t('<input type="checkbox" value="1" name="" value="">').attr("name", "context-menu-input-" + e).val(a.value || "").prop("checked", !!a.selected).prependTo(r);
                                break;
                            case "radio":
                                l = t('<input type="radio" value="1" name="" value="">').attr("name", "context-menu-input-" + a.radio).val(a.value || "").prop("checked", !!a.selected).prependTo(r);
                                break;
                            case "select":
                                l = t('<select name="">').attr("name", "context-menu-input-" + e).appendTo(r), a.options && (t.each(a.options, function(e, n) {
                                    t("<option></option>").val(e).text(n).appendTo(l)
                                }), l.val(a.selected));
                                break;
                            case "sub":
                                t("<span></span>").html(a._name || a.name).appendTo(s), a.appendTo = a.$node, v.create(a, i), s.data("contextMenu", a).addClass("context-menu-submenu"), a.callback = null;
                                break;
                            case "html":
                                t(a.html).appendTo(s);
                                break;
                            default:
                                t.each([o, i], function(n, o) {
                                    o.commands[e] = a, t.isFunction(a.callback) && (o.callbacks[e] = a.callback)
                                }), t("<span></span>").html(a._name || a.name || "").appendTo(s)
                        }
                        a.type && "sub" != a.type && "html" != a.type && (l.on("focus", g.focusInput).on("blur", g.blurInput), a.events && l.on(a.events, o)), a.icon && s.addClass("icon icon-" + a.icon)
                    }
                    a.$input = l, a.$label = r, s.appendTo(o.$menu), !o.hasTypes && t.support.eventSelectstart && s.on("selectstart.disableTextSelect", g.abortevent)
                }), o.$node || o.$menu.css("display", "none").addClass("context-menu-root"), o.$menu.appendTo(o.appendTo || document.body)
            },
            resize: function(e, n) {
                e.css({
                    position: "absolute",
                    display: "block"
                }), e.data("width", Math.ceil(e.width()) + 1), e.css({
                    position: "static",
                    minWidth: "0px",
                    maxWidth: "100000px"
                }), e.find("> li > ul").each(function() {
                    v.resize(t(this), !0)
                }), n || e.find("ul").andSelf().css({
                    position: "",
                    display: "",
                    minWidth: "",
                    maxWidth: ""
                }).width(function() {
                    return t(this).data("width")
                })
            },
            update: function(n, o) {
                var i = this;
                o === e && (o = n, v.resize(n.$menu)), n.$menu.children().each(function() {
                    var e = t(this),
                        a = e.data("contextMenuKey"),
                        s = n.items[a],
                        r = t.isFunction(s.disabled) && s.disabled.call(i, a, o) || s.disabled === !0;
                    if (e[r ? "addClass" : "removeClass"]("disabled"), s.type) switch (e.find("input, select, textarea").prop("disabled", r), s.type) {
                        case "text":
                        case "textarea":
                            s.$input.val(s.value || "");
                            break;
                        case "checkbox":
                        case "radio":
                            s.$input.val(s.value || "").prop("checked", !!s.selected);
                            break;
                        case "select":
                            s.$input.val(s.selected || "")
                    }
                    s.$menu && v.update.call(i, s, o)
                })
            },
            layer: function(e, n) {
                var o = e.$layer = t('<div id="context-menu-layer" style="position:fixed; z-index:' + n + '; top:0; left:0; opacity: 0; filter: alpha(opacity=0); background-color: #000;"></div>').css({
                    height: l.height(),
                    width: l.width(),
                    display: "block"
                }).data("contextMenuRoot", e).insertBefore(this).on("contextmenu", g.abortevent).on("mousedown", g.layerClick);
                return t.support.fixedPosition || o.css({
                    position: "absolute",
                    height: t(document).height()
                }), o
            }
        };
    t.fn.contextMenu = function(n) {
        if (n === e) this.first().trigger("contextmenu");
        else if (n.x && n.y) this.first().trigger(t.Event("contextmenu", {
            pageX: n.x,
            pageY: n.y
        }));
        else if ("hide" === n) {
            var o = this.data("contextMenu").$menu;
            o && o.trigger("contextmenu:hide")
        } else "destroy" === n ? t.contextMenu("destroy", {
            context: this
        }) : t.isPlainObject(n) ? (n.context = this, t.contextMenu("create", n)) : n ? this.removeClass("context-menu-disabled") : n || this.addClass("context-menu-disabled");
        return this
    }, t.contextMenu = function(n, o) {
        "string" != typeof n && (o = n, n = "create"), "string" == typeof o ? o = {
            selector: o
        } : o === e && (o = {});
        var i = t.extend(!0, {}, f, o || {}),
            a = t(document),
            s = a,
            l = !1;
        switch (i.context && i.context.length ? (s = t(i.context).first(), i.context = s.get(0), l = i.context !== document) : i.context = document, n) {
            case "create":
                if (!i.selector) throw new Error("No selector specified");
                if (i.selector.match(/.context-menu-(list|item|input)($|\s)/)) throw new Error('Cannot bind to selector "' + i.selector + '" as it contains a reserved className');
                if (!i.build && (!i.items || t.isEmptyObject(i.items))) throw new Error("No Items specified");
                switch (c++, i.ns = ".contextMenu" + c, l || (u[i.selector] = i.ns), d[i.ns] = i, i.trigger || (i.trigger = "right"), r || (a.on({
                    "contextmenu:hide.contextMenu": g.hideMenu,
                    "prevcommand.contextMenu": g.prevItem,
                    "nextcommand.contextMenu": g.nextItem,
                    "contextmenu.contextMenu": g.abortevent,
                    "mouseenter.contextMenu": g.menuMouseenter,
                    "mouseleave.contextMenu": g.menuMouseleave
                }, ".context-menu-list").on("mouseup.contextMenu", ".context-menu-input", g.inputClick).on({
                    "mouseup.contextMenu": g.itemClick,
                    "contextmenu:focus.contextMenu": g.focusItem,
                    "contextmenu:blur.contextMenu": g.blurItem,
                    "contextmenu.contextMenu": g.abortevent,
                    "mouseenter.contextMenu": g.itemMouseenter,
                    "mouseleave.contextMenu": g.itemMouseleave
                }, ".context-menu-item"), r = !0), s.on("contextmenu" + i.ns, i.selector, i, g.contextmenu), l && s.on("remove" + i.ns, function() {
                    t(this).contextMenu("destroy")
                }), i.trigger) {
                    case "hover":
                        s.on("mouseenter" + i.ns, i.selector, i, g.mouseenter).on("mouseleave" + i.ns, i.selector, i, g.mouseleave);
                        break;
                    case "left":
                        s.on("click" + i.ns, i.selector, i, g.click)
                }
                i.build || v.create(i);
                break;
            case "destroy":
                var h;
                if (l) {
                    var p = i.context;
                    t.each(d, function(e, n) {
                        if (n.context !== p) return !0;
                        h = t(".context-menu-list").filter(":visible"), h.length && h.data().contextMenuRoot.$trigger.is(t(n.context).find(n.selector)) && h.trigger("contextmenu:hide", {
                            force: !0
                        });
                        try {
                            d[n.ns].$menu && d[n.ns].$menu.remove(), delete d[n.ns]
                        } catch (o) {
                            d[n.ns] = null
                        }
                        return t(n.context).off(n.ns), !0
                    })
                } else if (i.selector) {
                    if (u[i.selector]) {
                        h = t(".context-menu-list").filter(":visible"), h.length && h.data().contextMenuRoot.$trigger.is(i.selector) && h.trigger("contextmenu:hide", {
                            force: !0
                        });
                        try {
                            d[u[i.selector]].$menu && d[u[i.selector]].$menu.remove(), delete d[u[i.selector]]
                        } catch (m) {
                            d[u[i.selector]] = null
                        }
                        a.off(u[i.selector])
                    }
                } else a.off(".contextMenu .contextMenuAutoHide"), t.each(d, function(e, n) {
                    t(n.context).off(n.ns)
                }), u = {}, d = {}, c = 0, r = !1, t("#context-menu-layer, .context-menu-list").remove();
                break;
            case "html5":
                (!t.support.htmlCommand && !t.support.htmlMenuitem || "boolean" == typeof o && o) && t('menu[type="context"]').each(function() {
                    this.id && t.contextMenu({
                        selector: "[contextmenu=" + this.id + "]",
                        items: t.contextMenu.fromMenu(this)
                    })
                }).css("display", "none");
                break;
            default:
                throw new Error('Unknown operation "' + n + '"')
        }
        return this
    }, t.contextMenu.setInputValues = function(n, o) {
        o === e && (o = {}), t.each(n.inputs, function(t, e) {
            switch (e.type) {
                case "text":
                case "textarea":
                    e.value = o[t] || "";
                    break;
                case "checkbox":
                    e.selected = !!o[t];
                    break;
                case "radio":
                    e.selected = (o[e.radio] || "") == e.value;
                    break;
                case "select":
                    e.selected = o[t] || ""
            }
        })
    }, t.contextMenu.getInputValues = function(n, o) {
        return o === e && (o = {}), t.each(n.inputs, function(t, e) {
            switch (e.type) {
                case "text":
                case "textarea":
                case "select":
                    o[t] = e.$input.val();
                    break;
                case "checkbox":
                    o[t] = e.$input.prop("checked");
                    break;
                case "radio":
                    e.$input.prop("checked") && (o[e.radio] = e.value)
            }
        }), o
    }, t.contextMenu.fromMenu = function(e) {
        var n = t(e),
            o = {};
        return i(o, n.children()), o
    }, t.contextMenu.defaults = f, t.contextMenu.types = h, t.contextMenu.handle = g, t.contextMenu.op = v, t.contextMenu.menus = d
}(jQuery);
var _extends = Object.assign || function(t) {
        for (var e = 1; e < arguments.length; e++) {
            var n = arguments[e];
            for (var o in n) Object.prototype.hasOwnProperty.call(n, o) && (t[o] = n[o])
        }
        return t
    },
    _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
        return typeof t
    } : function(t) {
        return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
    };
! function(t, e) {
    "object" === ("undefined" == typeof exports ? "undefined" : _typeof(exports)) && "undefined" != typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define(e) : t.LazyLoad = e()
}(this, function() {
    "use strict";
    var t = {
            elements_selector: "img",
            container: document,
            threshold: 300,
            data_src: "src",
            data_srcset: "srcset",
            class_loading: "loading",
            class_loaded: "loaded",
            class_error: "error",
            callback_load: null,
            callback_error: null,
            callback_set: null,
            callback_enter: null
        },
        e = "data-",
        n = function(t, n) {
            return t.getAttribute(e + n)
        },
        o = function(t, n, o) {
            return t.setAttribute(e + n, o)
        },
        i = function(t) {
            return t.filter(function(t) {
                return !n(t, "was-processed")
            })
        },
        a = function(t, e) {
            var n, o = "LazyLoad::Initialized",
                i = new t(e);
            try {
                n = new CustomEvent(o, {
                    detail: {
                        instance: i
                    }
                })
            } catch (a) {
                n = document.createEvent("CustomEvent"), n.initCustomEvent(o, !1, !1, {
                    instance: i
                })
            }
            window.dispatchEvent(n)
        },
        s = function(t, e) {
            if (e.length)
                for (var n, o = 0; n = e[o]; o += 1) a(t, n);
            else a(t, e)
        },
        r = function(t, e) {
            var o = e.data_srcset,
                i = t.parentNode;
            if ("PICTURE" === i.tagName)
                for (var a, s = 0; a = i.children[s]; s += 1)
                    if ("SOURCE" === a.tagName) {
                        var r = n(a, o);
                        r && a.setAttribute("srcset", r)
                    }
        },
        l = function(t, e) {
            var o = e.data_src,
                i = e.data_srcset,
                a = t.tagName,
                s = n(t, o);
            if ("IMG" === a) {
                r(t, e);
                var l = n(t, i);
                return l && t.setAttribute("srcset", l), void(s && t.setAttribute("src", s))
            }
            return "IFRAME" === a ? void(s && t.setAttribute("src", s)) : void(s && (t.style.backgroundImage = 'url("' + s + '")'))
        },
        c = "classList" in document.createElement("p"),
        u = function(t, e) {
            return c ? void t.classList.add(e) : void(t.className += (t.className ? " " : "") + e)
        },
        d = function(t, e) {
            return c ? void t.classList.remove(e) : void(t.className = t.className.replace(new RegExp("(^|\\s+)" + e + "(\\s+|$)"), " ").replace(/^\s+/, "").replace(/\s+$/, ""))
        },
        h = function(t, e) {
            t && t(e)
        },
        f = "load",
        p = "error",
        m = function(t, e, n) {
            t.removeEventListener(f, e), t.removeEventListener(p, n)
        },
        g = function(t, e) {
            var n = function i(n) {
                    v(n, !0, e), m(t, i, o)
                },
                o = function a(o) {
                    v(o, !1, e), m(t, n, a)
                };
            t.addEventListener(f, n), t.addEventListener(p, o)
        },
        v = function(t, e, n) {
            var o = t.target;
            d(o, n.class_loading), u(o, e ? n.class_loaded : n.class_error), h(e ? n.callback_load : n.callback_error, o)
        },
        b = function(t, e) {
            h(e.callback_enter, t), ["IMG", "IFRAME"].indexOf(t.tagName) > -1 && (g(t, e), u(t, e.class_loading)), l(t, e), o(t, "was-processed", !0), h(e.callback_set, t)
        },
        y = function(e, n) {
            this._settings = _extends({}, t, e), this._setObserver(), this.update(n)
        };
    y.prototype = {
        _setObserver: function() {
            var t = this;
            if ("IntersectionObserver" in window) {
                var e = this._settings,
                    n = function(n) {
                        n.forEach(function(n) {
                            if (n.isIntersecting || n.intersectionRatio > 0) {
                                var o = n.target;
                                b(o, e), t._observer.unobserve(o)
                            }
                        }), t._elements = i(t._elements)
                    };
                this._observer = new IntersectionObserver(n, {
                    root: e.container === document ? null : e.container,
                    rootMargin: e.threshold + "px"
                })
            }
        },
        update: function(t) {
            var e = this,
                n = this._settings,
                o = t || n.container.querySelectorAll(n.elements_selector);
            return this._elements = i(Array.prototype.slice.call(o)), this._observer ? void this._elements.forEach(function(t) {
                e._observer.observe(t)
            }) : (this._elements.forEach(function(t) {
                b(t, n)
            }), void(this._elements = i(this._elements)))
        },
        destroy: function() {
            var t = this;
            this._observer && (i(this._elements).forEach(function(e) {
                t._observer.unobserve(e)
            }), this._observer = null), this._elements = null, this._settings = null
        }
    };
    var w = window.lazyLoadOptions;
    return w && s(y, w), y
}),
function(t) {
    "function" == typeof define && define.amd ? define(["jquery"], t) : "object" == typeof exports ? module.exports = t(require("jquery")) : t(jQuery)
}(function(t) {
    var e = t.event.dispatch || t.event.handle,
        n = t.event.special,
        o = "D" + +new Date,
        i = "D" + (+new Date + 1);
    n.scrollstart = {
        setup: function(i) {
            var a, s = t.extend({
                    latency: n.scrollstop.latency
                }, i),
                r = function(t) {
                    var n = this,
                        o = arguments;
                    a ? clearTimeout(a) : (t.type = "scrollstart", e.apply(n, o)), a = setTimeout(function() {
                        a = null
                    }, s.latency)
                };
            t(this).bind("scroll", r).data(o, r)
        },
        teardown: function() {
            t(this).unbind("scroll", t(this).data(o))
        }
    }, n.scrollstop = {
        latency: 250,
        setup: function(o) {
            var a, s = t.extend({
                    latency: n.scrollstop.latency
                }, o),
                r = function(t) {
                    var n = this,
                        o = arguments;
                    a && clearTimeout(a), a = setTimeout(function() {
                        a = null, t.type = "scrollstop", e.apply(n, o)
                    }, s.latency)
                };
            t(this).bind("scroll", r).data(i, r)
        },
        teardown: function() {
            t(this).unbind("scroll", t(this).data(i))
        }
    }
});
var bootbox = window.bootbox || function(t, e) {
    function n(t, e) {
        return "undefined" == typeof e && (e = o), "string" == typeof h[e][t] ? h[e][t] : e != i ? n(t, i) : t
    }
    var o = "en",
        i = "en",
        a = !0,
        s = "static",
        r = "javascript:;",
        l = "",
        c = {},
        u = {},
        d = {};
    d.setLocale = function(t) {
        for (var e in h)
            if (e == t) return void(o = t);
        throw new Error("Invalid locale: " + t)
    }, d.addLocale = function(t, e) {
        "undefined" == typeof h[t] && (h[t] = {});
        for (var n in e) h[t][n] = e[n]
    }, d.setIcons = function(t) {
        u = t, "object" == typeof u && null !== u || (u = {})
    }, d.setBtnClasses = function(t) {
        c = t, "object" == typeof c && null !== c || (c = {})
    }, d.alert = function() {
        var t = "",
            e = n("OK"),
            o = null;
        switch (arguments.length) {
            case 1:
                t = arguments[0];
                break;
            case 2:
                t = arguments[0], "function" == typeof arguments[1] ? o = arguments[1] : e = arguments[1];
                break;
            case 3:
                t = arguments[0], e = arguments[1], o = arguments[2];
                break;
            default:
                throw new Error("Incorrect number of arguments: expected 1-3")
        }
        return d.dialog(t, {
            label: e,
            icon: u.OK,
            "class": c.OK,
            callback: o
        }, {
            onEscape: o || !0
        })
    }, d.confirm = function() {
        var t = "",
            e = n("CANCEL"),
            o = n("CONFIRM"),
            i = null;
        switch (arguments.length) {
            case 1:
                t = arguments[0];
                break;
            case 2:
                t = arguments[0], "function" == typeof arguments[1] ? i = arguments[1] : e = arguments[1];
                break;
            case 3:
                t = arguments[0], e = arguments[1], "function" == typeof arguments[2] ? i = arguments[2] : o = arguments[2];
                break;
            case 4:
                t = arguments[0], e = arguments[1], o = arguments[2], i = arguments[3];
                break;
            default:
                throw new Error("Incorrect number of arguments: expected 1-4")
        }
        var a = function() {
                if ("function" == typeof i) return i(!1)
            },
            s = function() {
                if ("function" == typeof i) return i(!0)
            };
        return d.dialog(t, [{
            label: e,
            icon: u.CANCEL,
            "class": c.CANCEL,
            callback: a
        }, {
            label: o,
            icon: u.CONFIRM,
            "class": c.CONFIRM,
            callback: s
        }], {
            onEscape: a
        })
    }, d.prompt = function() {
        var t = "",
            o = n("CANCEL"),
            i = n("CONFIRM"),
            a = null,
            s = "";
        switch (arguments.length) {
            case 1:
                t = arguments[0];
                break;
            case 2:
                t = arguments[0], "function" == typeof arguments[1] ? a = arguments[1] : o = arguments[1];
                break;
            case 3:
                t = arguments[0], o = arguments[1], "function" == typeof arguments[2] ? a = arguments[2] : i = arguments[2];
                break;
            case 4:
                t = arguments[0], o = arguments[1], i = arguments[2], a = arguments[3];
                break;
            case 5:
                t = arguments[0], o = arguments[1], i = arguments[2], a = arguments[3], s = arguments[4];
                break;
            default:
                throw new Error("Incorrect number of arguments: expected 1-5")
        }
        var r = t,
            l = e("<form></form>");
        l.append("<input class='input-block-level' autocomplete=off type=text value='" + s + "' />");
        var h = function() {
                if ("function" == typeof a) return a(null)
            },
            f = function() {
                if ("function" == typeof a) return a(l.find("input[type=text]").val())
            },
            p = d.dialog(l, [{
                label: o,
                icon: u.CANCEL,
                "class": c.CANCEL,
                callback: h
            }, {
                label: i,
                icon: u.CONFIRM,
                "class": c.CONFIRM,
                callback: f
            }], {
                header: r,
                show: !1,
                onEscape: h
            });
        return p.on("shown", function() {
            l.find("input[type=text]").focus(), l.on("submit", function(t) {
                t.preventDefault(), p.find(".btn-primary").click()
            })
        }), p.modal("show"), p
    }, d.dialog = function(n, o, i) {
        function c(t) {
            var e = null;
            "function" == typeof i.onEscape && (e = i.onEscape()), e !== !1 && k.modal("hide")
        }
        var u = "",
            d = [];
        i || (i = {}), "undefined" == typeof o ? o = [] : "undefined" == typeof o.length && (o = [o]);
        for (var h = o.length; h--;) {
            var f = null,
                p = null,
                m = null,
                g = "",
                v = null;
            if ("undefined" == typeof o[h].label && "undefined" == typeof o[h]["class"] && "undefined" == typeof o[h].callback) {
                var b = 0,
                    y = null;
                for (var w in o[h])
                    if (y = w, ++b > 1) break;
                1 == b && "function" == typeof o[h][w] && (o[h].label = y, o[h].callback = o[h][w])
            }
            "function" == typeof o[h].callback && (v = o[h].callback), o[h]["class"] ? m = o[h]["class"] : h == o.length - 1 && o.length <= 2 && (m = "btn-primary"), o[h].link !== !0 && (m = "btn " + m), f = o[h].label ? o[h].label : "Option " + (h + 1), o[h].icon && (g = "<i class='" + o[h].icon + "'></i> "), p = o[h].href ? o[h].href : r, u = "<a data-handler='" + h + "' class='" + m + "' href='" + p + "'>" + g + f + "</a>" + u, d[h] = v
        }
        var x = ["<div class='bootbox modal' tabindex='-1' style='overflow:hidden;'>"];
        if (i.header) {
            var $ = "";
            ("undefined" == typeof i.headerCloseButton || i.headerCloseButton) && ($ = "<a href='" + r + "' class='close'>&times;</a>"), x.push("<div class='modal-header'>" + $ + "<h3>" + i.header + "</h3></div>")
        }
        x.push("<div class='modal-body'></div>"), u && x.push("<div class='modal-footer'>" + u + "</div>"), x.push("</div>");
        var k = e(x.join("\n")),
            C = "undefined" == typeof i.animate ? a : i.animate;
        C && k.addClass("fade");
        var T = "undefined" == typeof i.classes ? l : i.classes;
        return T && k.addClass(T), k.find(".modal-body").html(n), k.on("keyup.dismiss.modal", function(t) {
            27 === t.which && i.onEscape && c("escape")
        }), k.on("click", "a.close", function(t) {
            t.preventDefault(), c("close")
        }), k.on("shown", function() {
            k.find("a.btn-primary:first").focus()
        }), k.on("hidden", function(t) {
            t.target === this && k.remove()
        }), k.on("click", ".modal-footer a", function(t) {
            var n = e(this).data("handler"),
                i = d[n],
                a = null;
            "undefined" != typeof n && "undefined" != typeof o[n].href || (t.preventDefault(), "function" == typeof i && (a = i(t)), a !== !1 && k.modal("hide"))
        }), e("body").append(k), k.modal({
            backdrop: "undefined" == typeof i.backdrop ? s : i.backdrop,
            keyboard: !1,
            show: !1
        }), k.on("show", function(n) {
            e(t).off("focusin.modal")
        }), "undefined" != typeof i.show && i.show !== !0 || k.modal("show"), k
    }, d.modal = function() {
        var t, n, o, i = {
            onEscape: null,
            keyboard: !0,
            backdrop: s
        };
        switch (arguments.length) {
            case 1:
                t = arguments[0];
                break;
            case 2:
                t = arguments[0], "object" == typeof arguments[1] ? o = arguments[1] : n = arguments[1];
                break;
            case 3:
                t = arguments[0], n = arguments[1], o = arguments[2];
                break;
            default:
                throw new Error("Incorrect number of arguments: expected 1-3")
        }
        return i.header = n, o = "object" == typeof o ? e.extend(i, o) : i, d.dialog(t, [], o)
    }, d.hideAll = function() {
        e(".bootbox").modal("hide")
    }, d.animate = function(t) {
        a = t
    }, d.backdrop = function(t) {
        s = t
    }, d.classes = function(t) {
        l = t
    };
    var h = {
        br: {
            OK: "OK",
            CANCEL: "Cancelar",
            CONFIRM: "Sim"
        },
        da: {
            OK: "OK",
            CANCEL: "Annuller",
            CONFIRM: "Accepter"
        },
        de: {
            OK: "OK",
            CANCEL: "Abbrechen",
            CONFIRM: "Akzeptieren"
        },
        en: {
            OK: "OK",
            CANCEL: "Cancel",
            CONFIRM: "OK"
        },
        es: {
            OK: "OK",
            CANCEL: "Cancelar",
            CONFIRM: "Aceptar"
        },
        fr: {
            OK: "OK",
            CANCEL: "Annuler",
            CONFIRM: "D'accord"
        },
        it: {
            OK: "OK",
            CANCEL: "Annulla",
            CONFIRM: "Conferma"
        },
        nl: {
            OK: "OK",
            CANCEL: "Annuleren",
            CONFIRM: "Accepteren"
        },
        pl: {
            OK: "OK",
            CANCEL: "Anuluj",
            CONFIRM: "Potwierdź"
        },
        ru: {
            OK: "OK",
            CANCEL: "Отмена",
            CONFIRM: "Применить"
        },
        zh_CN: {
            OK: "OK",
            CANCEL: "取消",
            CONFIRM: "确认"
        },
        zh_TW: {
            OK: "OK",
            CANCEL: "取消",
            CONFIRM: "確認"
        }
    };
    return d
}(document, window.jQuery);
window.bootbox = bootbox,
    function(t) {
        "function" == typeof define && define.amd && define.amd.jQuery ? define(["jquery"], t) : t(jQuery)
    }(function(t) {
        "use strict";

        function e(e) {
            return !e || void 0 !== e.allowPageScroll || void 0 === e.swipe && void 0 === e.swipeStatus || (e.allowPageScroll = c), void 0 !== e.click && void 0 === e.tap && (e.tap = e.click), e || (e = {}), e = t.extend({}, t.fn.swipe.defaults, e), this.each(function() {
                var o = t(this),
                    i = o.data(E);
                i || (i = new n(this, e), o.data(E, i))
            })
        }

        function n(e, n) {
            function S(e) {
                if (!(ct() || t(e.target).closest(n.excludedElements, Yt).length > 0)) {
                    var o, i = e.originalEvent ? e.originalEvent : e,
                        a = C ? i.touches[0] : i;
                    return Xt = w, C ? qt = i.touches.length : e.preventDefault(), Pt = 0, Nt = null, zt = null, jt = 0, Rt = 0, Ht = 0, Ft = 1, Kt = 0, Qt = pt(), Wt = vt(), rt(), !C || qt === n.fingers || n.fingers === b || W() ? (dt(0, a), Ut = Mt(), 2 == qt && (dt(1, i.touches[1]), Rt = Ht = wt(Qt[0].start, Qt[1].start)), (n.swipeStatus || n.pinchStatus) && (o = P(i, Xt))) : o = !1, o === !1 ? (Xt = k, P(i, Xt), o) : (n.hold && (te = setTimeout(t.proxy(function() {
                        Yt.trigger("hold", [i.target]), n.hold && (o = n.hold.call(Yt, i, i.target))
                    }, this), n.longTapThreshold)), ut(!0), null)
                }
            }

            function O(t) {
                var e = t.originalEvent ? t.originalEvent : t;
                if (Xt !== $ && Xt !== k && !lt()) {
                    var o, i = C ? e.touches[0] : e,
                        a = ht(i);
                    if (Bt = Mt(), C && (qt = e.touches.length), n.hold && clearTimeout(te), Xt = x, 2 == qt && (0 == Rt ? (dt(1, e.touches[1]), Rt = Ht = wt(Qt[0].start, Qt[1].start)) : (ht(e.touches[1]), Ht = wt(Qt[0].end, Qt[1].end), zt = $t(Qt[0].end, Qt[1].end)), Ft = xt(Rt, Ht), Kt = Math.abs(Rt - Ht)), qt === n.fingers || n.fingers === b || !C || W()) {
                        if (Nt = Tt(a.start, a.end), K(t, Nt), Pt = kt(a.start, a.end), jt = yt(), mt(Nt, Pt), (n.swipeStatus || n.pinchStatus) && (o = P(e, Xt)), !n.triggerOnTouchEnd || n.triggerOnTouchLeave) {
                            var s = !0;
                            if (n.triggerOnTouchLeave) {
                                var r = Et(this);
                                s = St(a.end, r)
                            }!n.triggerOnTouchEnd && s ? Xt = D(x) : n.triggerOnTouchLeave && !s && (Xt = D($)), Xt != k && Xt != $ || P(e, Xt)
                        }
                    } else Xt = k, P(e, Xt);
                    o === !1 && (Xt = k, P(e, Xt))
                }
            }

            function L(t) {
                var e = t.originalEvent;
                return C && e.touches.length > 0 ? (st(), !0) : (lt() && (qt = Gt), Bt = Mt(), jt = yt(), R() || !j() ? (Xt = k, P(e, Xt)) : n.triggerOnTouchEnd || 0 == n.triggerOnTouchEnd && Xt === x ? (t.preventDefault(), Xt = $, P(e, Xt)) : !n.triggerOnTouchEnd && V() ? (Xt = $, N(e, Xt, f)) : Xt === x && (Xt = k, P(e, Xt)), ut(!1), null)
            }

            function _() {
                qt = 0, Bt = 0, Ut = 0, Rt = 0, Ht = 0, Ft = 1, rt(), ut(!1)
            }

            function I(t) {
                var e = t.originalEvent;
                n.triggerOnTouchLeave && (Xt = D($), P(e, Xt))
            }

            function A() {
                Yt.unbind(Lt, S), Yt.unbind(Dt, _), Yt.unbind(_t, O), Yt.unbind(It, L), At && Yt.unbind(At, I), ut(!1)
            }

            function D(t) {
                var e = t,
                    o = F(),
                    i = j(),
                    a = R();
                return !o || a ? e = k : !i || t != x || n.triggerOnTouchEnd && !n.triggerOnTouchLeave ? !i && t == $ && n.triggerOnTouchLeave && (e = k) : e = $, e
            }

            function P(t, e) {
                var n = void 0;
                return Q() || q() || Y() || W() ? ((Q() || q()) && (n = N(t, e, d)), (Y() || W()) && n !== !1 && (n = N(t, e, h))) : it() && n !== !1 ? n = N(t, e, p) : at() && n !== !1 ? n = N(t, e, m) : ot() && n !== !1 && (n = N(t, e, f)), e === k && _(t), e === $ && (C ? 0 == t.touches.length && _(t) : _(t)), n
            }

            function N(e, c, u) {
                var g = void 0;
                if (u == d) {
                    if (Yt.trigger("swipeStatus", [c, Nt || null, Pt || 0, jt || 0, qt, Qt]), n.swipeStatus && (g = n.swipeStatus.call(Yt, e, c, Nt || null, Pt || 0, jt || 0, qt, Qt), g === !1)) return !1;
                    if (c == $ && X()) {
                        if (Yt.trigger("swipe", [Nt, Pt, jt, qt, Qt]), n.swipe && (g = n.swipe.call(Yt, e, Nt, Pt, jt, qt, Qt), g === !1)) return !1;
                        switch (Nt) {
                            case o:
                                Yt.trigger("swipeLeft", [Nt, Pt, jt, qt, Qt]), n.swipeLeft && (g = n.swipeLeft.call(Yt, e, Nt, Pt, jt, qt, Qt));
                                break;
                            case i:
                                Yt.trigger("swipeRight", [Nt, Pt, jt, qt, Qt]), n.swipeRight && (g = n.swipeRight.call(Yt, e, Nt, Pt, jt, qt, Qt));
                                break;
                            case a:
                                Yt.trigger("swipeUp", [Nt, Pt, jt, qt, Qt]), n.swipeUp && (g = n.swipeUp.call(Yt, e, Nt, Pt, jt, qt, Qt));
                                break;
                            case s:
                                Yt.trigger("swipeDown", [Nt, Pt, jt, qt, Qt]), n.swipeDown && (g = n.swipeDown.call(Yt, e, Nt, Pt, jt, qt, Qt))
                        }
                    }
                }
                if (u == h) {
                    if (Yt.trigger("pinchStatus", [c, zt || null, Kt || 0, jt || 0, qt, Ft, Qt]), n.pinchStatus && (g = n.pinchStatus.call(Yt, e, c, zt || null, Kt || 0, jt || 0, qt, Ft, Qt), g === !1)) return !1;
                    if (c == $ && z()) switch (zt) {
                        case r:
                            Yt.trigger("pinchIn", [zt || null, Kt || 0, jt || 0, qt, Ft, Qt]), n.pinchIn && (g = n.pinchIn.call(Yt, e, zt || null, Kt || 0, jt || 0, qt, Ft, Qt));
                            break;
                        case l:
                            Yt.trigger("pinchOut", [zt || null, Kt || 0, jt || 0, qt, Ft, Qt]), n.pinchOut && (g = n.pinchOut.call(Yt, e, zt || null, Kt || 0, jt || 0, qt, Ft, Qt))
                    }
                }
                return u == f ? c !== k && c !== $ || (clearTimeout(Jt), clearTimeout(te), G() && !tt() ? (Zt = Mt(), Jt = setTimeout(t.proxy(function() {
                    Zt = null, Yt.trigger("tap", [e.target]), n.tap && (g = n.tap.call(Yt, e, e.target))
                }, this), n.doubleTapThreshold)) : (Zt = null, Yt.trigger("tap", [e.target]), n.tap && (g = n.tap.call(Yt, e, e.target)))) : u == p ? c !== k && c !== $ || (clearTimeout(Jt), Zt = null, Yt.trigger("doubletap", [e.target]), n.doubleTap && (g = n.doubleTap.call(Yt, e, e.target))) : u == m && (c !== k && c !== $ || (clearTimeout(Jt), Zt = null, Yt.trigger("longtap", [e.target]), n.longTap && (g = n.longTap.call(Yt, e, e.target)))), g
            }

            function j() {
                var t = !0;
                return null !== n.threshold && (t = Pt >= n.threshold), t
            }

            function R() {
                var t = !1;
                return null !== n.cancelThreshold && null !== Nt && (t = gt(Nt) - Pt >= n.cancelThreshold), t
            }

            function H() {
                return null === n.pinchThreshold || Kt >= n.pinchThreshold
            }

            function F() {
                var t;
                return t = !n.maxTimeThreshold || !(jt >= n.maxTimeThreshold)
            }

            function K(t, e) {
                if (n.preventDefaultEvents !== !1)
                    if (n.allowPageScroll === c) t.preventDefault();
                    else {
                        var r = n.allowPageScroll === u;
                        switch (e) {
                            case o:
                                (n.swipeLeft && r || !r && n.allowPageScroll != g) && t.preventDefault();
                                break;
                            case i:
                                (n.swipeRight && r || !r && n.allowPageScroll != g) && t.preventDefault();
                                break;
                            case a:
                                (n.swipeUp && r || !r && n.allowPageScroll != v) && t.preventDefault();
                                break;
                            case s:
                                (n.swipeDown && r || !r && n.allowPageScroll != v) && t.preventDefault()
                        }
                    }
            }

            function z() {
                var t = U(),
                    e = B(),
                    n = H();
                return t && e && n
            }

            function W() {
                return !!(n.pinchStatus || n.pinchIn || n.pinchOut)
            }

            function Y() {
                return !(!z() || !W())
            }

            function X() {
                var t = F(),
                    e = j(),
                    n = U(),
                    o = B(),
                    i = R(),
                    a = !i && o && n && e && t;
                return a
            }

            function q() {
                return !!(n.swipe || n.swipeStatus || n.swipeLeft || n.swipeRight || n.swipeUp || n.swipeDown)
            }

            function Q() {
                return !(!X() || !q())
            }

            function U() {
                return qt === n.fingers || n.fingers === b || !C
            }

            function B() {
                return 0 !== Qt[0].end.x
            }

            function V() {
                return !!n.tap
            }

            function G() {
                return !!n.doubleTap
            }

            function Z() {
                return !!n.longTap
            }

            function J() {
                if (null == Zt) return !1;
                var t = Mt();
                return G() && t - Zt <= n.doubleTapThreshold
            }

            function tt() {
                return J()
            }

            function et() {
                return (1 === qt || !C) && (isNaN(Pt) || Pt < n.threshold)
            }

            function nt() {
                return jt > n.longTapThreshold && Pt < y
            }

            function ot() {
                return !(!et() || !V())
            }

            function it() {
                return !(!J() || !G())
            }

            function at() {
                return !(!nt() || !Z())
            }

            function st() {
                Vt = Mt(), Gt = event.touches.length + 1
            }

            function rt() {
                Vt = 0, Gt = 0
            }

            function lt() {
                var t = !1;
                if (Vt) {
                    var e = Mt() - Vt;
                    e <= n.fingerReleaseThreshold && (t = !0)
                }
                return t
            }

            function ct() {
                return !(Yt.data(E + "_intouch") !== !0)
            }

            function ut(t) {
                t === !0 ? (Yt.bind(_t, O), Yt.bind(It, L), At && Yt.bind(At, I)) : (Yt.unbind(_t, O, !1), Yt.unbind(It, L, !1), At && Yt.unbind(At, I, !1)), Yt.data(E + "_intouch", t === !0)
            }

            function dt(t, e) {
                var n = void 0 !== e.identifier ? e.identifier : 0;
                return Qt[t].identifier = n, Qt[t].start.x = Qt[t].end.x = e.pageX || e.clientX, Qt[t].start.y = Qt[t].end.y = e.pageY || e.clientY, Qt[t]
            }

            function ht(t) {
                var e = void 0 !== t.identifier ? t.identifier : 0,
                    n = ft(e);
                return n.end.x = t.pageX || t.clientX, n.end.y = t.pageY || t.clientY, n
            }

            function ft(t) {
                for (var e = 0; e < Qt.length; e++)
                    if (Qt[e].identifier == t) return Qt[e]
            }

            function pt() {
                for (var t = [], e = 0; e <= 5; e++) t.push({
                    start: {
                        x: 0,
                        y: 0
                    },
                    end: {
                        x: 0,
                        y: 0
                    },
                    identifier: 0
                });
                return t
            }

            function mt(t, e) {
                e = Math.max(e, gt(t)), Wt[t].distance = e
            }

            function gt(t) {
                if (Wt[t]) return Wt[t].distance
            }

            function vt() {
                var t = {};
                return t[o] = bt(o), t[i] = bt(i), t[a] = bt(a), t[s] = bt(s), t
            }

            function bt(t) {
                return {
                    direction: t,
                    distance: 0
                }
            }

            function yt() {
                return Bt - Ut
            }

            function wt(t, e) {
                var n = Math.abs(t.x - e.x),
                    o = Math.abs(t.y - e.y);
                return Math.round(Math.sqrt(n * n + o * o))
            }

            function xt(t, e) {
                var n = e / t * 1;
                return n.toFixed(2)
            }

            function $t() {
                return Ft < 1 ? l : r
            }

            function kt(t, e) {
                return Math.round(Math.sqrt(Math.pow(e.x - t.x, 2) + Math.pow(e.y - t.y, 2)))
            }

            function Ct(t, e) {
                var n = t.x - e.x,
                    o = e.y - t.y,
                    i = Math.atan2(o, n),
                    a = Math.round(180 * i / Math.PI);
                return a < 0 && (a = 360 - Math.abs(a)), a
            }

            function Tt(t, e) {
                var n = Ct(t, e);
                return n <= 45 && n >= 0 ? o : n <= 360 && n >= 315 ? o : n >= 135 && n <= 225 ? i : n > 45 && n < 135 ? s : a
            }

            function Mt() {
                var t = new Date;
                return t.getTime()
            }

            function Et(e) {
                e = t(e);
                var n = e.offset(),
                    o = {
                        left: n.left,
                        right: n.left + e.outerWidth(),
                        top: n.top,
                        bottom: n.top + e.outerHeight()
                    };
                return o
            }

            function St(t, e) {
                return t.x > e.left && t.x < e.right && t.y > e.top && t.y < e.bottom
            }
            var Ot = C || M || !n.fallbackToMouseEvents,
                Lt = Ot ? M ? T ? "MSPointerDown" : "pointerdown" : "touchstart" : "mousedown",
                _t = Ot ? M ? T ? "MSPointerMove" : "pointermove" : "touchmove" : "mousemove",
                It = Ot ? M ? T ? "MSPointerUp" : "pointerup" : "touchend" : "mouseup",
                At = Ot ? null : "mouseleave",
                Dt = M ? T ? "MSPointerCancel" : "pointercancel" : "touchcancel",
                Pt = 0,
                Nt = null,
                jt = 0,
                Rt = 0,
                Ht = 0,
                Ft = 1,
                Kt = 0,
                zt = 0,
                Wt = null,
                Yt = t(e),
                Xt = "start",
                qt = 0,
                Qt = null,
                Ut = 0,
                Bt = 0,
                Vt = 0,
                Gt = 0,
                Zt = 0,
                Jt = null,
                te = null;
            try {
                Yt.bind(Lt, S), Yt.bind(Dt, _)
            } catch (ee) {
                t.error("events not supported " + Lt + "," + Dt + " on jQuery.swipe")
            }
            this.enable = function() {
                return Yt.bind(Lt, S), Yt.bind(Dt, _), Yt
            }, this.disable = function() {
                return A(), Yt
            }, this.destroy = function() {
                A(), Yt.data(E, null), Yt = null
            }, this.option = function(e, o) {
                if (void 0 !== n[e]) {
                    if (void 0 === o) return n[e];
                    n[e] = o
                } else t.error("Option " + e + " does not exist on jQuery.swipe.options");
                return null
            }
        }
        var o = "left",
            i = "right",
            a = "up",
            s = "down",
            r = "in",
            l = "out",
            c = "none",
            u = "auto",
            d = "swipe",
            h = "pinch",
            f = "tap",
            p = "doubletap",
            m = "longtap",
            g = "horizontal",
            v = "vertical",
            b = "all",
            y = 10,
            w = "start",
            x = "move",
            $ = "end",
            k = "cancel",
            C = "ontouchstart" in window,
            T = window.navigator.msPointerEnabled && !window.navigator.pointerEnabled,
            M = window.navigator.pointerEnabled || window.navigator.msPointerEnabled,
            E = "TouchSwipe",
            S = {
                fingers: 1,
                threshold: 75,
                cancelThreshold: null,
                pinchThreshold: 20,
                maxTimeThreshold: null,
                fingerReleaseThreshold: 250,
                longTapThreshold: 500,
                doubleTapThreshold: 200,
                swipe: null,
                swipeLeft: null,
                swipeRight: null,
                swipeUp: null,
                swipeDown: null,
                swipeStatus: null,
                pinchIn: null,
                pinchOut: null,
                pinchStatus: null,
                click: null,
                tap: null,
                doubleTap: null,
                longTap: null,
                hold: null,
                triggerOnTouchEnd: !0,
                triggerOnTouchLeave: !1,
                allowPageScroll: "auto",
                fallbackToMouseEvents: !0,
                excludedElements: "label, button, input, select, textarea, a, .noSwipe",
                preventDefaultEvents: !0
            };
        t.fn.swipe = function(n) {
            var o = t(this),
                i = o.data(E);
            if (i && "string" == typeof n) {
                if (i[n]) return i[n].apply(this, Array.prototype.slice.call(arguments, 1));
                t.error("Method " + n + " does not exist on jQuery.swipe")
            } else if (!(i || "object" != typeof n && n)) return e.apply(this, arguments);
            return o
        }, t.fn.swipe.defaults = S, t.fn.swipe.phases = {
            PHASE_START: w,
            PHASE_MOVE: x,
            PHASE_END: $,
            PHASE_CANCEL: k
        }, t.fn.swipe.directions = {
            LEFT: o,
            RIGHT: i,
            UP: a,
            DOWN: s,
            IN: r,
            OUT: l
        }, t.fn.swipe.pageScroll = {
            NONE: c,
            HORIZONTAL: g,
            VERTICAL: v,
            AUTO: u
        }, t.fn.swipe.fingers = {
            ONE: 1,
            TWO: 2,
            THREE: 3,
            ALL: b
        }
    }), ! function(t) {
        "use strict";

        function e(t) {
            return function(e) {
                if (e && this === e.target) return t.apply(this, arguments)
            }
        }
        var n = function(t, e) {
            this.init(t, e)
        };
        n.prototype = {
            constructor: n,
            init: function(e, n) {
                if (this.$element = t(e), this.options = t.extend({}, t.fn.modalmanager.defaults, this.$element.data(), "object" == typeof n && n), this.stack = [], this.backdropCount = 0, this.options.resize) {
                    var o, i = this;
                    t(window).on("resize.modal", function() {
                        o && clearTimeout(o), o = setTimeout(function() {
                            for (var t = 0; t < i.stack.length; t++) i.stack[t].isShown && i.stack[t].layout()
                        }, 10)
                    })
                }
            },
            createModal: function(e, n) {
                t(e).modal(t.extend({
                    manager: this
                }, n))
            },
            appendModal: function(n) {
                this.stack.push(n);
                var o = this;
                n.$element.on("show.modalmanager", e(function(e) {
                    var i = function() {
                        n.isShown = !0;
                        var e = t.support.transition && n.$element.hasClass("fade");
                        o.$element.toggleClass("modal-open", o.hasOpenModal()).toggleClass("page-overflow", t(window).height() < o.$element.height()), n.$parent = n.$element.parent(), n.$container = o.createContainer(n), n.$element.appendTo(n.$container), o.backdrop(n, function() {
                            n.$element.show(), e && n.$element[0].offsetWidth, n.layout(), n.$element.addClass("in").attr("aria-hidden", !1);
                            var i = function() {
                                o.setFocus(), n.$element.trigger("shown")
                            };
                            e ? n.$element.one(t.support.transition.end, i) : i()
                        })
                    };
                    n.options.replace ? o.replace(i) : i()
                })), n.$element.on("hidden.modalmanager", e(function(e) {
                    if (o.backdrop(n), n.$element.parent().length)
                        if (n.$backdrop) {
                            var i = t.support.transition && n.$element.hasClass("fade");
                            i && n.$element[0].offsetWidth, t.support.transition && n.$element.hasClass("fade") ? n.$backdrop.one(t.support.transition.end, function() {
                                n.destroy()
                            }) : n.destroy()
                        } else n.destroy();
                    else o.destroyModal(n)
                })), n.$element.on("destroyed.modalmanager", e(function(t) {
                    o.destroyModal(n)
                }))
            },
            getOpenModals: function() {
                for (var t = [], e = 0; e < this.stack.length; e++) this.stack[e].isShown && t.push(this.stack[e]);
                return t
            },
            hasOpenModal: function() {
                return this.getOpenModals().length > 0
            },
            setFocus: function() {
                for (var t, e = 0; e < this.stack.length; e++) this.stack[e].isShown && (t = this.stack[e]);
                t && t.focus()
            },
            destroyModal: function(t) {
                t.$element.off(".modalmanager"), t.$backdrop && this.removeBackdrop(t), this.stack.splice(this.getIndexOfModal(t), 1);
                var e = this.hasOpenModal();
                this.$element.toggleClass("modal-open", e), e || this.$element.removeClass("page-overflow"), this.removeContainer(t), this.setFocus()
            },
            getModalAt: function(t) {
                return this.stack[t]
            },
            getIndexOfModal: function(t) {
                for (var e = 0; e < this.stack.length; e++)
                    if (t === this.stack[e]) return e
            },
            replace: function(n) {
                for (var o, i = 0; i < this.stack.length; i++) this.stack[i].isShown && (o = this.stack[i]);
                o ? (this.$backdropHandle = o.$backdrop, o.$backdrop = null, n && o.$element.one("hidden", e(t.proxy(n, this))), o.hide()) : n && n()
            },
            removeBackdrop: function(t) {
                t.$backdrop.remove(), t.$backdrop = null
            },
            createBackdrop: function(e, n) {
                var o;
                return this.$backdropHandle ? (o = this.$backdropHandle, o.off(".modalmanager"), this.$backdropHandle = null, this.isLoading && this.removeSpinner()) : o = t(n).addClass(e).appendTo(this.$element), o
            },
            removeContainer: function(t) {
                t.$container.remove(), t.$container = null
            },
            createContainer: function(n) {
                var i;
                return i = t('<div class="modal-scrollable">').css("z-index", o("modal", this.getOpenModals().length)).appendTo(this.$element), n && "static" != n.options.backdrop ? i.on("click.modal", e(function(t) {
                    n.hide()
                })) : n && i.on("click.modal", e(function(t) {
                    n.attention()
                })), i
            },
            backdrop: function(e, n) {
                var i = e.$element.hasClass("fade") ? "fade" : "",
                    a = e.options.backdrop && this.backdropCount < this.options.backdropLimit;
                if (e.isShown && a) {
                    var s = t.support.transition && i && !this.$backdropHandle;
                    e.$backdrop = this.createBackdrop(i, e.options.backdropTemplate), e.$backdrop.css("z-index", o("backdrop", this.getOpenModals().length)), s && e.$backdrop[0].offsetWidth, e.$backdrop.addClass("in"), this.backdropCount += 1, s ? e.$backdrop.one(t.support.transition.end, n) : n()
                } else if (!e.isShown && e.$backdrop) {
                    e.$backdrop.removeClass("in"), this.backdropCount -= 1;
                    var r = this;
                    t.support.transition && e.$element.hasClass("fade") ? e.$backdrop.one(t.support.transition.end, function() {
                        r.removeBackdrop(e)
                    }) : r.removeBackdrop(e)
                } else n && n()
            },
            removeSpinner: function() {
                this.$spinner && this.$spinner.remove(), this.$spinner = null, this.isLoading = !1
            },
            removeLoading: function() {
                this.$backdropHandle && this.$backdropHandle.remove(), this.$backdropHandle = null, this.removeSpinner()
            },
            loading: function(e) {
                if (e = e || function() {}, this.$element.toggleClass("modal-open", !this.isLoading || this.hasOpenModal()).toggleClass("page-overflow", t(window).height() < this.$element.height()), this.isLoading)
                    if (this.isLoading && this.$backdropHandle) {
                        this.$backdropHandle.removeClass("in");
                        var n = this;
                        t.support.transition ? this.$backdropHandle.one(t.support.transition.end, function() {
                            n.removeLoading()
                        }) : n.removeLoading()
                    } else e && e(this.isLoading);
                else {
                    this.$backdropHandle = this.createBackdrop("fade", this.options.backdropTemplate), this.$backdropHandle[0].offsetWidth;
                    var i = this.getOpenModals();
                    this.$backdropHandle.css("z-index", o("backdrop", i.length + 1)).addClass("in");
                    var a = t(this.options.spinner).css("z-index", o("modal", i.length + 1)).appendTo(this.$element).addClass("in");
                    this.$spinner = t(this.createContainer()).append(a).on("click.modalmanager", t.proxy(this.loading, this)), this.isLoading = !0, t.support.transition ? this.$backdropHandle.one(t.support.transition.end, e) : e()
                }
            }
        };
        var o = function() {
            var e, n = {};
            return function(o, i) {
                if ("undefined" == typeof e) {
                    var a = t('<div class="modal hide" />').appendTo("body"),
                        s = t('<div class="modal-backdrop hide" />').appendTo("body");
                    n.modal = +a.css("z-index"), n.backdrop = +s.css("z-index"), e = n.modal - n.backdrop, a.remove(), s.remove(), s = a = null
                }
                return n[o] + e * i
            }
        }();
        t.fn.modalmanager = function(e, o) {
            return this.each(function() {
                var i = t(this),
                    a = i.data("modalmanager");
                a || i.data("modalmanager", a = new n(this, e)), "string" == typeof e && a[e].apply(a, [].concat(o))
            })
        }, t.fn.modalmanager.defaults = {
            backdropLimit: 999,
            resize: !0,
            spinner: '<div class="loading-spinner fade" style="width: 200px; margin-left: -100px;"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div>',
            backdropTemplate: '<div class="modal-backdrop" />'
        }, t.fn.modalmanager.Constructor = n, t(function() {
            t(document).off("show.bs.modal").off("hidden.bs.modal")
        })
    }(jQuery), ! function(t) {
        "use strict";
        var e = function(t, e) {
            this.init(t, e)
        };
        e.prototype = {
            constructor: e,
            init: function(e, n) {
                var o = this;
                this.options = n, this.$element = t(e).delegate('[data-dismiss="modal"]', "click.dismiss.modal", t.proxy(this.hide, this)), this.options.remote && this.$element.find(".modal-body").load(this.options.remote, function() {
                    var e = t.Event("loaded");
                    o.$element.trigger(e)
                });
                var i = "function" == typeof this.options.manager ? this.options.manager.call(this) : this.options.manager;
                i = i.appendModal ? i : t(i).modalmanager().data("modalmanager"), i.appendModal(this)
            },
            toggle: function() {
                return this[this.isShown ? "hide" : "show"]()
            },
            show: function() {
                var e = t.Event("show");
                this.isShown || (this.$element.trigger(e), e.isDefaultPrevented() || (this.escape(), this.tab(), this.options.loading && this.loading()))
            },
            hide: function(e) {
                e && e.preventDefault(), e = t.Event("hide"), this.$element.trigger(e), this.isShown && !e.isDefaultPrevented() && (this.isShown = !1, this.escape(), this.tab(), this.isLoading && this.loading(), t(document).off("focusin.modal"), this.$element.removeClass("in").removeClass("animated").removeClass(this.options.attentionAnimation).removeClass("modal-overflow").attr("aria-hidden", !0), t.support.transition && this.$element.hasClass("fade") ? this.hideWithTransition() : this.hideModal())
            },
            layout: function() {
                var e = this.options.height ? "height" : "max-height",
                    n = this.options.height || this.options.maxHeight;
                if (this.options.width) {
                    this.$element.css("width", this.options.width);
                    var o = this;
                    this.$element.css("margin-left", function() {
                        return /%/gi.test(o.options.width) ? -(parseInt(o.options.width) / 2) + "%" : -(t(this).width() / 2) + "px"
                    })
                } else this.$element.css("width", ""), this.$element.css("margin-left", "");
                this.$element.find(".modal-body").css("overflow", "").css(e, ""), n && this.$element.find(".modal-body").css("overflow", "auto").css(e, n);
                var i = t(window).height() - 10 < this.$element.height();
                i || this.options.modalOverflow ? this.$element.css("margin-top", 0).addClass("modal-overflow") : this.$element.css("margin-top", 0 - this.$element.height() / 2).removeClass("modal-overflow")
            },
            tab: function() {
                var e = this;
                this.isShown && this.options.consumeTab ? this.$element.on("keydown.tabindex.modal", "[data-tabindex]", function(n) {
                    if (n.keyCode && 9 == n.keyCode) {
                        var o = t(this),
                            i = t(this);
                        e.$element.find("[data-tabindex]:enabled:not([readonly])").each(function(e) {
                            o = e.shiftKey ? o.data("tabindex") > t(this).data("tabindex") ? o = t(this) : i = t(this) : o.data("tabindex") < t(this).data("tabindex") ? o = t(this) : i = t(this)
                        }), o[0] !== t(this)[0] ? o.focus() : i.focus(), n.preventDefault()
                    }
                }) : this.isShown || this.$element.off("keydown.tabindex.modal")
            },
            escape: function() {
                var t = this;
                this.isShown && this.options.keyboard ? (this.$element.attr("tabindex") || this.$element.attr("tabindex", -1), this.$element.on("keyup.dismiss.modal", function(e) {
                    27 == e.which && t.hide()
                })) : this.isShown || this.$element.off("keyup.dismiss.modal")
            },
            hideWithTransition: function() {
                var e = this,
                    n = setTimeout(function() {
                        e.$element.off(t.support.transition.end), e.hideModal()
                    }, 500);
                this.$element.one(t.support.transition.end, function() {
                    clearTimeout(n), e.hideModal()
                })
            },
            hideModal: function() {
                var t = this.options.height ? "height" : "max-height",
                    e = this.options.height || this.options.maxHeight;
                e && this.$element.find(".modal-body").css("overflow", "").css(t, ""), this.$element.hide().trigger("hidden")
            },
            removeLoading: function() {
                this.$loading.remove(), this.$loading = null, this.isLoading = !1
            },
            loading: function(e) {
                e = e || function() {};
                var n = this.$element.hasClass("fade") ? "fade" : "";
                if (this.isLoading)
                    if (this.isLoading && this.$loading) {
                        this.$loading.removeClass("in");
                        var o = this;
                        t.support.transition && this.$element.hasClass("fade") ? this.$loading.one(t.support.transition.end, function() {
                            o.removeLoading()
                        }) : o.removeLoading()
                    } else e && e(this.isLoading);
                else {
                    var i = t.support.transition && n;
                    this.$loading = t('<div class="loading-mask ' + n + '">').append(this.options.spinner).appendTo(this.$element), i && this.$loading[0].offsetWidth, this.$loading.addClass("in"), this.isLoading = !0, i ? this.$loading.one(t.support.transition.end, e) : e()
                }
            },
            focus: function() {
                var t = this.$element.find(this.options.focusOn);
                t = t.length ? t : this.$element, t.focus()
            },
            attention: function() {
                if (this.options.attentionAnimation) {
                    this.$element.removeClass("animated").removeClass(this.options.attentionAnimation);
                    var t = this;
                    setTimeout(function() {
                        t.$element.addClass("animated").addClass(t.options.attentionAnimation)
                    }, 0)
                }
                this.focus()
            },
            destroy: function() {
                var e = t.Event("destroy");
                this.$element.trigger(e), e.isDefaultPrevented() || (this.$element.off(".modal").removeData("modal").removeClass("in").attr("aria-hidden", !0), this.$parent !== this.$element.parent() ? this.$element.appendTo(this.$parent) : this.$parent.length || (this.$element.remove(), this.$element = null), this.$element.trigger("destroyed"))
            }
        }, t.fn.modal = function(n, o) {
            return this.each(function() {
                var i = t(this),
                    a = i.data("modal"),
                    s = t.extend({}, t.fn.modal.defaults, i.data(), "object" == typeof n && n);
                a || i.data("modal", a = new e(this, s)), "string" == typeof n ? a[n].apply(a, [].concat(o)) : s.show && a.show()
            })
        }, t.fn.modal.defaults = {
            keyboard: !0,
            backdrop: !0,
            loading: !1,
            show: !0,
            width: null,
            height: null,
            maxHeight: null,
            modalOverflow: !1,
            consumeTab: !0,
            focusOn: null,
            replace: !1,
            resize: !1,
            attentionAnimation: "shake",
            manager: "body",
            spinner: '<div class="loading-spinner" style="width: 200px; margin-left: -100px;"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div>',
            backdropTemplate: '<div class="modal-backdrop" />'
        }, t.fn.modal.Constructor = e, t(function() {
            t(document).off("click.modal").on("click.modal.data-api", '[data-toggle="modal"]', function(e) {
                var n = t(this),
                    o = n.attr("href"),
                    i = t(n.attr("data-target") || o && o.replace(/.*(?=#[^\s]+$)/, "")),
                    a = i.data("modal") ? "toggle" : t.extend({
                        remote: !/#/.test(o) && o
                    }, i.data(), n.data());
                e.preventDefault(), i.modal(a).one("hide", function() {
                    n.focus()
                })
            })
        })
    }(window.jQuery),
    function(t) {
        if ("object" == typeof exports && "undefined" != typeof module) module.exports = t();
        else if ("function" == typeof define && define.amd) define([], t);
        else {
            var e;
            e = "undefined" != typeof window ? window : "undefined" != typeof global ? global : "undefined" != typeof self ? self : this, e.Clipboard = t()
        }
    }(function() {
        var t;
        return function e(t, n, o) {
            function i(s, r) {
                if (!n[s]) {
                    if (!t[s]) {
                        var l = "function" == typeof require && require;
                        if (!r && l) return l(s, !0);
                        if (a) return a(s, !0);
                        var c = new Error("Cannot find module '" + s + "'");
                        throw c.code = "MODULE_NOT_FOUND", c
                    }
                    var u = n[s] = {
                        exports: {}
                    };
                    t[s][0].call(u.exports, function(e) {
                        var n = t[s][1][e];
                        return i(n ? n : e)
                    }, u, u.exports, e, t, n, o)
                }
                return n[s].exports
            }
            for (var a = "function" == typeof require && require, s = 0; s < o.length; s++) i(o[s]);
            return i
        }({
            1: [function(t, e, n) {
                function o(t, e) {
                    for (; t && t.nodeType !== i;) {
                        if ("function" == typeof t.matches && t.matches(e)) return t;
                        t = t.parentNode
                    }
                }
                var i = 9;
                if ("undefined" != typeof Element && !Element.prototype.matches) {
                    var a = Element.prototype;
                    a.matches = a.matchesSelector || a.mozMatchesSelector || a.msMatchesSelector || a.oMatchesSelector || a.webkitMatchesSelector
                }
                e.exports = o
            }, {}],
            2: [function(t, e, n) {
                function o(t, e, n, o, a) {
                    var s = i.apply(this, arguments);
                    return t.addEventListener(n, s, a), {
                        destroy: function() {
                            t.removeEventListener(n, s, a)
                        }
                    }
                }

                function i(t, e, n, o) {
                    return function(n) {
                        n.delegateTarget = a(n.target, e), n.delegateTarget && o.call(t, n)
                    }
                }
                var a = t("./closest");
                e.exports = o
            }, {
                "./closest": 1
            }],
            3: [function(t, e, n) {
                n.node = function(t) {
                    return void 0 !== t && t instanceof HTMLElement && 1 === t.nodeType
                }, n.nodeList = function(t) {
                    var e = Object.prototype.toString.call(t);
                    return void 0 !== t && ("[object NodeList]" === e || "[object HTMLCollection]" === e) && "length" in t && (0 === t.length || n.node(t[0]))
                }, n.string = function(t) {
                    return "string" == typeof t || t instanceof String
                }, n.fn = function(t) {
                    var e = Object.prototype.toString.call(t);
                    return "[object Function]" === e
                }
            }, {}],
            4: [function(t, e, n) {
                function o(t, e, n) {
                    if (!t && !e && !n) throw new Error("Missing required arguments");
                    if (!r.string(e)) throw new TypeError("Second argument must be a String");
                    if (!r.fn(n)) throw new TypeError("Third argument must be a Function");
                    if (r.node(t)) return i(t, e, n);
                    if (r.nodeList(t)) return a(t, e, n);
                    if (r.string(t)) return s(t, e, n);
                    throw new TypeError("First argument must be a String, HTMLElement, HTMLCollection, or NodeList")
                }

                function i(t, e, n) {
                    return t.addEventListener(e, n), {
                        destroy: function() {
                            t.removeEventListener(e, n)
                        }
                    }
                }

                function a(t, e, n) {
                    return Array.prototype.forEach.call(t, function(t) {
                        t.addEventListener(e, n)
                    }), {
                        destroy: function() {
                            Array.prototype.forEach.call(t, function(t) {
                                t.removeEventListener(e, n)
                            })
                        }
                    }
                }

                function s(t, e, n) {
                    return l(document.body, t, e, n)
                }
                var r = t("./is"),
                    l = t("delegate");
                e.exports = o
            }, {
                "./is": 3,
                delegate: 2
            }],
            5: [function(t, e, n) {
                function o(t) {
                    var e;
                    if ("SELECT" === t.nodeName) t.focus(), e = t.value;
                    else if ("INPUT" === t.nodeName || "TEXTAREA" === t.nodeName) {
                        var n = t.hasAttribute("readonly");
                        n || t.setAttribute("readonly", ""), t.select(), t.setSelectionRange(0, t.value.length), n || t.removeAttribute("readonly"), e = t.value
                    } else {
                        t.hasAttribute("contenteditable") && t.focus();
                        var o = window.getSelection(),
                            i = document.createRange();
                        i.selectNodeContents(t), o.removeAllRanges(), o.addRange(i), e = o.toString()
                    }
                    return e
                }
                e.exports = o
            }, {}],
            6: [function(t, e, n) {
                function o() {}
                o.prototype = {
                    on: function(t, e, n) {
                        var o = this.e || (this.e = {});
                        return (o[t] || (o[t] = [])).push({
                            fn: e,
                            ctx: n
                        }), this
                    },
                    once: function(t, e, n) {
                        function o() {
                            i.off(t, o), e.apply(n, arguments)
                        }
                        var i = this;
                        return o._ = e, this.on(t, o, n)
                    },
                    emit: function(t) {
                        var e = [].slice.call(arguments, 1),
                            n = ((this.e || (this.e = {}))[t] || []).slice(),
                            o = 0,
                            i = n.length;
                        for (o; o < i; o++) n[o].fn.apply(n[o].ctx, e);
                        return this
                    },
                    off: function(t, e) {
                        var n = this.e || (this.e = {}),
                            o = n[t],
                            i = [];
                        if (o && e)
                            for (var a = 0, s = o.length; a < s; a++) o[a].fn !== e && o[a].fn._ !== e && i.push(o[a]);
                        return i.length ? n[t] = i : delete n[t], this
                    }
                }, e.exports = o
            }, {}],
            7: [function(e, n, o) {
                ! function(i, a) {
                    if ("function" == typeof t && t.amd) t(["module", "select"], a);
                    else if ("undefined" != typeof o) a(n, e("select"));
                    else {
                        var s = {
                            exports: {}
                        };
                        a(s, i.select), i.clipboardAction = s.exports
                    }
                }(this, function(t, e) {
                    "use strict";

                    function n(t) {
                        return t && t.__esModule ? t : {
                            "default": t
                        }
                    }

                    function o(t, e) {
                        if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
                    }
                    var i = n(e),
                        a = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
                            return typeof t
                        } : function(t) {
                            return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
                        },
                        s = function() {
                            function t(t, e) {
                                for (var n = 0; n < e.length; n++) {
                                    var o = e[n];
                                    o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(t, o.key, o)
                                }
                            }
                            return function(e, n, o) {
                                return n && t(e.prototype, n), o && t(e, o), e
                            }
                        }(),
                        r = function() {
                            function t(e) {
                                o(this, t), this.resolveOptions(e), this.initSelection()
                            }
                            return s(t, [{
                                key: "resolveOptions",
                                value: function() {
                                    var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
                                    this.action = t.action, this.container = t.container, this.emitter = t.emitter, this.target = t.target, this.text = t.text, this.trigger = t.trigger, this.selectedText = ""
                                }
                            }, {
                                key: "initSelection",
                                value: function() {
                                    this.text ? this.selectFake() : this.target && this.selectTarget()
                                }
                            }, {
                                key: "selectFake",
                                value: function() {
                                    var t = this,
                                        e = "rtl" == document.documentElement.getAttribute("dir");
                                    this.removeFake(), this.fakeHandlerCallback = function() {
                                        return t.removeFake()
                                    }, this.fakeHandler = this.container.addEventListener("click", this.fakeHandlerCallback) || !0, this.fakeElem = document.createElement("textarea"), this.fakeElem.style.fontSize = "12pt", this.fakeElem.style.border = "0", this.fakeElem.style.padding = "0", this.fakeElem.style.margin = "0", this.fakeElem.style.position = "absolute", this.fakeElem.style[e ? "right" : "left"] = "-9999px";
                                    var n = window.pageYOffset || document.documentElement.scrollTop;
                                    this.fakeElem.style.top = n + "px", this.fakeElem.setAttribute("readonly", ""), this.fakeElem.value = this.text, this.container.appendChild(this.fakeElem), this.selectedText = (0, i["default"])(this.fakeElem), this.copyText()
                                }
                            }, {
                                key: "removeFake",
                                value: function() {
                                    this.fakeHandler && (this.container.removeEventListener("click", this.fakeHandlerCallback), this.fakeHandler = null, this.fakeHandlerCallback = null), this.fakeElem && (this.container.removeChild(this.fakeElem), this.fakeElem = null)
                                }
                            }, {
                                key: "selectTarget",
                                value: function() {
                                    this.selectedText = (0, i["default"])(this.target), this.copyText()
                                }
                            }, {
                                key: "copyText",
                                value: function() {
                                    var t = void 0;
                                    try {
                                        t = document.execCommand(this.action)
                                    } catch (e) {
                                        t = !1
                                    }
                                    this.handleResult(t)
                                }
                            }, {
                                key: "handleResult",
                                value: function(t) {
                                    this.emitter.emit(t ? "success" : "error", {
                                        action: this.action,
                                        text: this.selectedText,
                                        trigger: this.trigger,
                                        clearSelection: this.clearSelection.bind(this)
                                    })
                                }
                            }, {
                                key: "clearSelection",
                                value: function() {
                                    this.trigger && this.trigger.focus(), window.getSelection().removeAllRanges()
                                }
                            }, {
                                key: "destroy",
                                value: function() {
                                    this.removeFake()
                                }
                            }, {
                                key: "action",
                                set: function() {
                                    var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "copy";
                                    if (this._action = t, "copy" !== this._action && "cut" !== this._action) throw new Error('Invalid "action" value, use either "copy" or "cut"')
                                },
                                get: function() {
                                    return this._action
                                }
                            }, {
                                key: "target",
                                set: function(t) {
                                    if (void 0 !== t) {
                                        if (!t || "object" !== ("undefined" == typeof t ? "undefined" : a(t)) || 1 !== t.nodeType) throw new Error('Invalid "target" value, use a valid Element');
                                        if ("copy" === this.action && t.hasAttribute("disabled")) throw new Error('Invalid "target" attribute. Please use "readonly" instead of "disabled" attribute');
                                        if ("cut" === this.action && (t.hasAttribute("readonly") || t.hasAttribute("disabled"))) throw new Error('Invalid "target" attribute. You can\'t cut text from elements with "readonly" or "disabled" attributes');
                                        this._target = t
                                    }
                                },
                                get: function() {
                                    return this._target
                                }
                            }]), t
                        }();
                    t.exports = r
                })
            }, {
                select: 5
            }],
            8: [function(e, n, o) {
                ! function(i, a) {
                    if ("function" == typeof t && t.amd) t(["module", "./clipboard-action", "tiny-emitter", "good-listener"], a);
                    else if ("undefined" != typeof o) a(n, e("./clipboard-action"), e("tiny-emitter"), e("good-listener"));
                    else {
                        var s = {
                            exports: {}
                        };
                        a(s, i.clipboardAction, i.tinyEmitter, i.goodListener), i.clipboard = s.exports
                    }
                }(this, function(t, e, n, o) {
                    "use strict";

                    function i(t) {
                        return t && t.__esModule ? t : {
                            "default": t
                        }
                    }

                    function a(t, e) {
                        if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
                    }

                    function s(t, e) {
                        if (!t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                        return !e || "object" != typeof e && "function" != typeof e ? t : e
                    }

                    function r(t, e) {
                        if ("function" != typeof e && null !== e) throw new TypeError("Super expression must either be null or a function, not " + typeof e);
                        t.prototype = Object.create(e && e.prototype, {
                            constructor: {
                                value: t,
                                enumerable: !1,
                                writable: !0,
                                configurable: !0
                            }
                        }), e && (Object.setPrototypeOf ? Object.setPrototypeOf(t, e) : t.__proto__ = e)
                    }

                    function l(t, e) {
                        var n = "data-clipboard-" + t;
                        if (e.hasAttribute(n)) return e.getAttribute(n)
                    }
                    var c = i(e),
                        u = i(n),
                        d = i(o),
                        h = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
                            return typeof t
                        } : function(t) {
                            return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
                        },
                        f = function() {
                            function t(t, e) {
                                for (var n = 0; n < e.length; n++) {
                                    var o = e[n];
                                    o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(t, o.key, o)
                                }
                            }
                            return function(e, n, o) {
                                return n && t(e.prototype, n), o && t(e, o), e
                            }
                        }(),
                        p = function(t) {
                            function e(t, n) {
                                a(this, e);
                                var o = s(this, (e.__proto__ || Object.getPrototypeOf(e)).call(this));
                                return o.resolveOptions(n), o.listenClick(t), o
                            }
                            return r(e, t), f(e, [{
                                key: "resolveOptions",
                                value: function() {
                                    var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
                                    this.action = "function" == typeof t.action ? t.action : this.defaultAction, this.target = "function" == typeof t.target ? t.target : this.defaultTarget, this.text = "function" == typeof t.text ? t.text : this.defaultText, this.container = "object" === h(t.container) ? t.container : document.body
                                }
                            }, {
                                key: "listenClick",
                                value: function(t) {
                                    var e = this;
                                    this.listener = (0, d["default"])(t, "click", function(t) {
                                        return e.onClick(t)
                                    })
                                }
                            }, {
                                key: "onClick",
                                value: function(t) {
                                    var e = t.delegateTarget || t.currentTarget;
                                    this.clipboardAction && (this.clipboardAction = null), this.clipboardAction = new c["default"]({
                                        action: this.action(e),
                                        target: this.target(e),
                                        text: this.text(e),
                                        container: this.container,
                                        trigger: e,
                                        emitter: this
                                    })
                                }
                            }, {
                                key: "defaultAction",
                                value: function(t) {
                                    return l("action", t)
                                }
                            }, {
                                key: "defaultTarget",
                                value: function(t) {
                                    var e = l("target", t);
                                    if (e) return document.querySelector(e)
                                }
                            }, {
                                key: "defaultText",
                                value: function(t) {
                                    return l("text", t)
                                }
                            }, {
                                key: "destroy",
                                value: function() {
                                    this.listener.destroy(), this.clipboardAction && (this.clipboardAction.destroy(), this.clipboardAction = null)
                                }
                            }], [{
                                key: "isSupported",
                                value: function() {
                                    var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : ["copy", "cut"],
                                        e = "string" == typeof t ? [t] : t,
                                        n = !!document.queryCommandSupported;
                                    return e.forEach(function(t) {
                                        n = n && !!document.queryCommandSupported(t)
                                    }), n
                                }
                            }]), e
                        }(u["default"]);
                    t.exports = p
                })
            }, {
                "./clipboard-action": 7,
                "good-listener": 4,
                "tiny-emitter": 6
            }]
        }, {}, [8])(8)
    }),
    function(t) {
        function e(t, e) {
            if (!(t.originalEvent.touches.length > 1)) {
                t.preventDefault();
                var n = t.originalEvent.changedTouches[0],
                    o = document.createEvent("MouseEvents");
                o.initMouseEvent(e, !0, !0, window, 1, n.screenX, n.screenY, n.clientX, n.clientY, !1, !1, !1, !1, 0, null), t.target.dispatchEvent(o)
            }
        }
        if (t.support.touch = "ontouchend" in document, t.support.touch) {
            var n, o = t.ui.mouse.prototype,
                i = o._mouseInit,
                a = o._mouseDestroy;
            o._touchStart = function(t) {
                var o = this;
                !n && o._mouseCapture(t.originalEvent.changedTouches[0]) && (n = !0, o._touchMoved = !1, e(t, "mouseover"), e(t, "mousemove"), e(t, "mousedown"))
            }, o._touchMove = function(t) {
                n && (this._touchMoved = !0, e(t, "mousemove"))
            }, o._touchEnd = function(t) {
                n && (e(t, "mouseup"), e(t, "mouseout"), this._touchMoved || e(t, "click"), n = !1)
            }, o._mouseInit = function() {
                var e = this;
                e.element.bind({
                    touchstart: t.proxy(e, "_touchStart"),
                    touchmove: t.proxy(e, "_touchMove"),
                    touchend: t.proxy(e, "_touchEnd")
                }), i.call(e)
            }, o._mouseDestroy = function() {
                var e = this;
                e.element.unbind({
                    touchstart: t.proxy(e, "_touchStart"),
                    touchmove: t.proxy(e, "_touchMove"),
                    touchend: t.proxy(e, "_touchEnd")
                }), a.call(e)
            }
        }
    }(jQuery);