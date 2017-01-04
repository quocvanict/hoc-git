(function () {
    function l(a, b) {
        var c = a.split("."),
                f = h;
        c[0] in f || !f.execScript || f.execScript("var " + c[0]);
        for (var e; c.length && (e = c.shift()); ) {
            c.length || void 0 === b ? f = f[e] ? f[e] : f[e] = {} : f[e] = b;
        }
    }

    function p(a) {
        a = jQuery.extend({
            url: new String,
            type: "GET",
            processData: !0,
            crossDomain: !1,
            data: {},
            dataType: "json"
        }, a);
        return jQuery.ajax(a);
    }

    function m(a, b, c) {
        if (!a) {
            throw Error();
        }
        if (2 < arguments.length) {
            var f = Array.prototype.slice.call(arguments, 2);
            return function () {
                var e = Array.prototype.slice.call(arguments);
                Array.prototype.unshift.apply(e, f);
                return a.apply(b, e);
            };
        }
        return function () {
            return a.apply(b, arguments);
        };
    }

    function k(a, b, c) {
        a = jQuery(document.createElement(a));
        b && a.attr(b);
        c && a.addClass(c);
        return a;
    }

    function p(a) {
        a = jQuery.extend({
            url: new String,
            type: "GET",
            processData: !0,
            crossDomain: !1,
            data: {},
            dataType: "json"
        }, a);
        return jQuery.ajax(a);
    }

    function q() {
        jQuery.validator.addMethod("myRule", function (a, b, c) {
            if (this.optional(b)) {
                return "dependency-mismatch";
            }
            var f = this.previousValue(b),
                    e, g;
            this.settings.messages[b.name] || (this.settings.messages[b.name] = {});
            this.settings.messages[b.name].myRule = f.message;
            c = "string" === typeof c && {
                url: c
            } || c;
            if (f.old === a) {
                return f.valid || (f.originalMessage = f.message, c = {}, c[b.name] = f.message, this.invalid[b.name] = !0, this.showErrors(c)), f.valid;
            }
            f.old = a;
            e = this;
            this.startRequest(b);
            g = {};
            g[b.name] = a;
            jQuery.ajax(jQuery.extend(!0, {
                mode: "abort",
                port: "validate" + b.name,
                dataType: "json",
                data: g,
                context: e.currentForm,
                success: function (g) {
                    var c = 1 == g.status,
                            d;
                    e.settings.messages[b.name].myRule = f.originalMessage;
                    c ? (d = e.formSubmitted, e.prepareElement(b), e.formSubmitted = d, e.successList.push(b), delete e.invalid[b.name], e.showErrors()) : (d = {}, g = g.message || e.defaultMessage(b, "myRule"), d[b.name] = f.message = jQuery.isFunction(g) ? g(a) : g, e.invalid[b.name] = !0, e.showErrors(d));
                    f.valid = c;
                    e.stopRequest(b, c);
                }
            }, c));
            return "pending";
        }, "");
        jQuery.validator.setDefaults({
            highlight: function (a) {
                jQuery(a).closest(".form-group").addClass("has-error");
            },
            unhighlight: function (a) {
                jQuery(a).closest(".form-group").removeClass("has-error");
            },
            errorElement: "span",
            errorClass: "help-block",
            errorPlacement: function (a, b) {
                a.insertAfter(b.parent());
            },
            focusCleanup: !0,
            focusInvalid: !1,
            onkeyup: !1
        });
    }
    var h = h || window;
    (function () {
        var a, b = Array.prototype,
                c = {
                    filter: function (a, e) {
                        var b = this.length,
                                c = [],
                                d = 0,
                                n;
                        if ("function" == typeof a) {
                            for (; d < b; ) {
                                d in this && (n = this[d], a.call(e, n, d, this) && (c[c.length] = n)), ++d;
                            }
                        }
                        return c;
                    },
                    every: function (a, e) {
                        var b = this.length,
                                c = 0;
                        if ("function" == typeof a) {
                            for (; c < b; ) {
                                if (c in this && !a.call(e, this[c], c, this)) {
                                    return !1;
                                }
                                ++c;
                            }
                            return !0;
                        }
                        return null;
                    },
                    forEach: function (a, e) {
                        var b = this.length,
                                c = 0;
                        if ("function" == typeof a) {
                            for (; c < b; ) {
                                c in this && a.call(e, this[c], c, this), ++c;
                            }
                        }
                        return this;
                    },
                    indexOf: function (a, e) {
                        e = e || 0;
                        for (var b = this.length; e < b; ) {
                            if (this[e] === a) {
                                return e;
                            }
                            ++e;
                        }
                        return -1;
                    },
                    lastIndexOf: function (a, e) {
                        var b = this.length;
                        e = e || b - 1;
                        for (isNaN(e) || e >= b ? e = b - 1 : 0 > e && (e += b); -1 < e; ) {
                            if (this[e] === a) {
                                return e;
                            }
                            --e;
                        }
                        return -1;
                    },
                    map: function (a, e) {
                        var b = this.length,
                                c = Array(this.length),
                                d = 0;
                        if ("function" == typeof a) {
                            for (; d < b; ) {
                                d in this && (c[d] = a.call(e, this[d], d, this)), ++d;
                            }
                            return c;
                        }
                    },
                    some: function (a, e) {
                        var b = 0,
                                c = this.length;
                        if ("function" == typeof a) {
                            for (; b < c; ) {
                                if (b in this && a.call(e, this[b], b, this)) {
                                    return !0;
                                }
                                ++b;
                            }
                            return !1;
                        }
                    }
                };
        for (a in c) {
            b[a] || (b[a] = c[a]);
        }
        return !0;
    })();
    var d;
    d = function (a, b) {
        function c() {}
        c.prototype = b.prototype;
        a.prototype = new c;
        a.prototype.constructor = a;
        a.superclass = b;
        a.superproto = b.prototype;
    };
    Function.prototype.bind || (Function.prototype.bind = function (a) {
        function b() {
            return e.apply(this instanceof c && a ? this : a, d.concat(Array.prototype.slice.call(arguments)));
        }

        function c() {}
        if ("function" != typeof this) {
            throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
        }
        var d = Array.prototype.slice.call(arguments, 1),
                e = this;
        c.prototype = this.prototype;
        b.prototype = new c;
        return b;
    });
    var r = function () {
        var a = 0;
        return function () {
            return a++;
        };
    }();
    d = function (a, b, c, d) {
        this.id = "n" + r();
        this.dlclass = "modal-dialog";
        this.duration = 150;
        this.buttons = c || {};
        this.closeButton = !0;
        this.modal = void 0;
        this.title = a || "Title";
        this.overlay = void 0;
        this.content = b || void 0;
        this.title_parent = null;
        this.buttons_parent = void 0;
        this.loading = d || !1;
        this.w = this.p = this.A = void 0;
        this.renderCallback = null;
    }.prototype;
    d.setLoading = function (a) {
        this.loading = a;
        return this;
    };
    d.setDialogClass = function (a) {
        this.dlclass = a;
        return this;
    };
    d.setDuration = function (a) {
        this.duration = a;
        return this;
    };
    d.showCloseButton = function (a) {
        this.closeButton = a;
        return this;
    };
    d.setContent = function (a) {
        this.content = a;
        return this;
    };
    d.setTitle = function (a) {
        this.title = a;
        return this;
    };
    d.setButtons = function (a) {
        this.buttons = a;
        return this;
    };
    d.getButtons = function (a) {
        return void 0 == a ? this.buttons : this.buttons[a];
    };
    d.afterRender = function (a) {
        this.renderCallback = a;
        return this;
    };
    d.close = function (a) {
        var b = this;
        b.modal.animate({
            opacity: 0
        }, b.duration, function () {
            b.modal.remove();
        });
        b.overlay.animate({
            opacity: 0
        }, b.duration, function () {
            b.overlay.remove();
        });
        jQuery(h).off("resize.dialog");
        a && a.call(this);
    };
    d.build = function () {
        var a = this;
        this.modal = k("div", null, this.dlclass);
        this.overlay = k("div", {}, this.dlclass + "-bg").css({
            width: jQuery(h).width() + "px",
            height: jQuery(h).height() + "px",
            opacity: 0
        }).animate({
            opacity: .75
        }, this.duration);
        this.title_parent = k("div", null, this.dlclass + "-title " + this.dlclass + "-title-draggable");
        this.title_text = k("div", {}, this.dlclass + "-title-text");
        this.dialog_content = k("div", {}, this.dlclass + "-content");
        if (this.title_text.html(this.title), this.dialog_content.html(this.content), this.closeButton && (this.closeButton = k("div", null, this.dlclass + "-title-close"), this.closeButton.bind("click", function () {
            a.close();
        }), this.closeButton.appendTo(this.title_parent)), Object.keys(this.buttons).length) {
            this.buttons_parent = k("div", {}, this.dlclass + "-buttons");
            var b = 0;
            for (b in this.buttons) {
                (function (b, d, e) {
                    var g = k("button", {
                        name: e,
                        "data-loading-text": "Please wait"
                    }, b.className || "btn btn-success btn-sm");
                    "function" == typeof b.init && b.init(g, e);
                    b.callback && g.one("click", function (e) {
                        b.callback.call(this, a);
                    });
                    b.label && g.text(b.label);
                    "cancel" == e && g.one("click", function () {
                        a.close();
                    });
                    g.appendTo(d);
                })(this.buttons[b], this.buttons_parent, b);
            }
            this.buttons_parent.appendTo(this.modal);
        }
    };
    d.render = function () {
        this.build();
        this.dialog_content.prependTo(this.modal);
        this.title_text.appendTo(this.title_parent);
        this.title_parent.prependTo(this.modal);
        this.overlay.appendTo(document.body);
        this.modal.appendTo(document.body).css({
            opacity: 0
        }).animate({
            opacity: 1
        }, this.duration, function () {});
        this.M();
        console.log(this.dialog_content.height());
        this.dialog_content.css({
            height: this.dialog_content.height() + "px"
        });
        this.loading = !0;
        this.renderCallback && this.renderCallback.call(this);
        jQuery(h).on("resize.dialog", function () {
            this.M();
        }.bind(this));
        return this;
    };
    d.M = function () {
        this.overlay.css({
            width: jQuery(h).width() + "px",
            height: jQuery(h).height() + "px"
        });
        this.modal.css({
            top: (jQuery(h).height() - this.modal.outerHeight()) / 2 + jQuery(h).scrollTop() + "px",
            left: (jQuery(h).width() - this.modal.outerWidth()) / 2 + jQuery(h).scrollLeft() + "px"
        });
        this.dialog_content.css({
            height: this.dialog_content.height() + "px"
        });
    };
    d = function () {
        this.uri = void 0;
        this.method = "POST";
        this.data = {};
        this.crossDomain = !1;
        this.dataType = "html";
        this.handler = this.beforeSend = this.errorHandler = this.finallyHandler = void 0;
    }.prototype;
    d.setUri = function (a) {
        this.uri = a;
        return this;
    };
    d.setMethod = function (a) {
        this.method = a;
        return this;
    };
    d.setData = function (a) {
        this.data = a;
        return this;
    };
    d.setHandler = function (a) {
        this.handler = a;
        return this;
    };
    d.setBeforeSend = function (a) {
        this.beforeSend = a;
        return this;
    };
    d.setErrorHandler = function (a) {
        this.errorHandler = a;
        return this;
    };
    d.setFinallyHandler = function (a) {
        this.finallyHandler = a;
        return this;
    };
    d.send = function () {
        jQuery.ajax({
            url: this.uri,
            type: this.method,
            processData: !0,
            crossDomain: this.crossDomain,
            beforeSend: function () {
                this.beforeSend && this.beforeSend.call(this);
            }.bind(this),
            data: this.data,
            dataType: this.dataType,
            success: function (a, b, c) {
                this.handler && this.handler.call(this, JSON.parse(a));
            }.bind(this),
            error: function () {
                this.errorHandler && this.errorHandler.call(this, arguments);
            }.bind(this),
            complete: function () {
                this.finallyHandler && this.finallyHandler.call(this, arguments);
            }.bind(this)
        });
    };
    d = function (a, b, c) {
        this.element = jQuery(a);
        this.cb = b;
        this.waiting = !1;
        this.setOptions(c);
        return this.init();
    }.prototype;
    d.setOptions = function (a) {
        this.scrollTimer = null;
        this.data = this.element.data("myInfiniteScroll");
        this.userOptions = "function" == typeof a ? {
            callback: a
        } : a;
        this.options = jQuery.extend({}, {
            debug: !1,
            autoTrigger: !0,
            autoTriggerUntil: !1,
            callback: !1,
            autoLoadContent: !1,
            delay: 200,
            toBottom: 50,
            nextRequest: !0
        }, this.userOptions, this.data || {});
        this.isWindow = "visible" == this.element.css("overflow-y");
        this.jQueryqp = jQuery(h);
        this.jQuerybody = jQuery(document.body);
        this.jQueryscroll = this.isWindow ? this.jQueryqp : this.element;
        this.element.data("myInfiniteScroll", jQuery.extend({}, this.data, {
            initialized: !0,
            waiting: this.waiting,
            nextRequest: this.options.nextRequest
        }));
        return this;
    };
    d.setNextRequest = function (a) {
        this.options.nextRequest = a;
        return this;
    };
    d.next = function () {
        this.waiting = !1;
        return this;
    };
    d.setCb = function (a) {
        this.cb = a;
        return this;
    };
    d.destroy = function () {
        this.jQueryscroll.unbind(".myInfiniteScroll").removeData("myInfiniteScroll");
        this.setNextRequest(!1);
        return this;
    };
    d.observe = function () {
        var a = this;
        this.scrollTimer && clearTimeout(this.scrollTimer);
        this.scrollTimer = setTimeout(function () {
            a.element.data("myInfiniteScroll");
            a.scrollTimer = null;
            if (!a.waiting && a.options.nextRequest && a.element.scrollTop() + a.element.innerHeight() + a.options.toBottom >= a.element.prop("scrollHeight")) {
                return a.load();
            }
        }, a.options.delay);
    };
    d.load = function () {
        var a = this.element.data("myInfiniteScroll"),
                b = this;
        b.options.onState && b.options.onState.call(b);
        if (!b.options.autoLoadContent) {
            return b.waiting = !0, b.cb && (b.cb.call(this), a.nextRequest = b.options.nextRequest, b.checkNextHref()), this;
        }
        jQuery.ajax({
            type: "GET",
            url: a.nextRequest,
            success: function (c) {
                b.element.each(function () {
                    a.waiting = !1;
                    a.nextRequest = b.options.nextRequest;
                    b.checkNextHref();
                    b.options.callback && b.options.callback.call(this, c);
                });
            },
            error: function () {
                return b.destroy();
            }
        });
        return this;
    };
    d.checkNextHref = function (a) {
        if (a = a || this.options.nextRequest) {
            return this.setBindings(), this;
        }
        this.destroy();
        return !1;
    };
    d.init = function () {
        this.preloadImage();
        this.setBindings();
        jQuery.extend(this.element.myInfiniteScroll, {
            destroy: this.destroy
        });
        return this;
    };
    d.preloadImage = function () {
        console.log("preloadImage");
        return this;
    };
    d.setBindings = function () {
        var a = this;
        this.options.nextRequest && (this.options.autoTrigger && (!1 === this.options.autoTriggerUntil || 0 < this.options.autoTriggerUntil) ? (this.jQuerybody.height() <= this.jQueryqp.height() && this.observe(), this.jQueryscroll.unbind(".myInfiniteScroll").bind("scroll.myInfiniteScroll", function () {
            return a.observe();
        }), 0 < this.options.autoTriggerUntil && this.options.autoTriggerUntil--) : (this.element.find(this.options.nextSelector).first(), this.jQueryscroll.unbind(".myInfiniteScroll"), this.jQuerynext.bind("click.myInfiniteScroll", function () {
            a.load();
            return !1;
        })));
    };
    (function () {
        function a() {}

        function b() {}

        function c() {}

        function d() {}
        function z() {}
        function p() {}
        function tr() {}
        function can() {}
        function claim() {}
        function app_log(){}
        a.prototype.init = function () {};
        a.prototype.index = function () {
            this.datePicker();
            jQuery(".search-button").on("click", m(this.search, this));
            jQuery(document.body).on("click", ".massaction-checkbox, .checkall", m(this.deleteAll, this));
            this.massaction();
            return this;
        };
        a.prototype.massaction = function () {
            jQuery(document.body).on("click", "#delete_all", m(this.massactionApply, this));
        };
        a.prototype.massactionApply = function (a) {
            var r = confirm("Are you sure delete campaign ?");
            if (r == true) {
                a.preventDefault();
                a = jQuery(a.currentTarget);
                for (var b = jQuery(".massaction-checkbox:checked"), c = 0, d, f = []; d = b[c++]; ) {
                    d = jQuery(d), f.push(d.attr("data-value"));
                }
                f = f.join(",");
                console.log(f);
                b = k("input", {
                    type: "hidden",
                    name: "ids",
                    value: f
                });
                a = k("form", {
                    method: "POST",
                    action: a.attr("href")
                });
                b.appendTo(a);
                a.appendTo(document.body).submit();
            }

        };
        a.prototype.edit = function () {
            return this.form().datePicker().uploader1('filelist', 'pickfiles', 'uploadfiles', 'upload_id').uploader1('filelist1', 'pickfiles1', 'uploadfiles1', 'upload_id1');
        };
        a.prototype.search = function (a) {
            a.preventDefault();
            var b = {};
            jQuery(".search-fields").map(function (a, c) {
                c = jQuery(c);
                b[c.attr("data-field")] = c.val();
            });
            b = jQuery.param(b);
            window.location.href = "/campaign/index?" + b;
        };
        a.prototype.form = function () {
            jQuery(".validation-required").validate({
                rules: {
                    pr_text: "required",
                    discount_type: "required",
                    discount_value: "required",
                    campaign_banner: "required",
                    start_datetime: "required",
                    end_datetime: "required"
                }
            });
            return this;
        };
        a.prototype.datePicker = function () {
//            jQuery(".datetimepicker").datetimepicker({
//                format: "YYYY-MM-DD HH:mm"
//            });
            jQuery(".datetimepicker").datetimepicker({
                format: "YYYY-MM-DD HH:mm",
                showClear: !0,
                showClose: !0,
                tooltips: {
                    today: "Go to today",
                    clear: "Clear selection",
                    close: "Close the picker",
                    selectMonth: "Select Month",
                    prevMonth: "Previous Month",
                    nextMonth: "Next Month",
                    selectYear: "Select Year",
                    prevYear: "Previous Year",
                    nextYear: "Next Year",
                    selectDecade: "Select Decade",
                    prevDecade: "Previous Decade",
                    nextDecade: "Next Decade",
                    prevCentury: "Previous Century",
                    nextCentury: "Next Century"
                }
            });
            jQuery(".datetimepicker").find("input").on("keydown", function () {
                console.log("run");
                return !1;
            });
            return this;
        };
        a.prototype.deleteAll = function () {

            $(document).on('click', '.checkall', function () {
                if (0 < jQuery(".massaction-checkbox:checked").length && !jQuery(".checkall:checked").length) {
                    $('input:checkbox').prop('checked', false);
                    jQuery("#delete_all").addClass("hidden")
                }
            });
            (0 < jQuery(".massaction-checkbox:checked").length || 0 < jQuery(".checkall:checked").length) ? jQuery("#delete_all").removeClass("hidden") : jQuery("#delete_all").addClass("hidden");
        };
        a.prototype.uploader1 = function (filelist, select, upload, upload_id) {
            var a = new plupload.Uploader({
                multi_selection: !1,
                runtimes: "html5,flash,silverlight,html4",
                browse_button: select,
                container: document.getElementById("container"),
                url: "/user/upload",
                flash_swf_url: "assets/js/plupload/Moxie.swf",
                silverlight_xap_url: "assets/js/plupload/Moxie.xap",
                init: {
                    PostInit: function () {
                        document.getElementById(filelist).innerHTML = "";
                        document.getElementById(upload).onclick = function () {
                            a.start();
                            return !1;
                        };
                    },
                    FilesAdded: function (a, b) {

                        var e = !0;
                        jQuery.each(b, function (b, d) {
                            var c, f = d.name;
                            c = ["png", "jpg", "bmp", "jpeg"];
                            c instanceof String && (c = [c]);
                            0 < f.length ? (f = f.substr(f.lastIndexOf(".") + 1).toLowerCase(), c = -1 !== c.indexOf(f) ? !0 : !1) : c = !1;
                            c || (e = !1, a.removeFile(d));
                        });
                        if (!e && 1 >= b.length) {
                            return a.splice(), a.refresh(), jQuery("#upload-error").html("File is not allowed."), !1;
                        }
                        plupload.each(b, function (a) {
                            jQuery(document.getElementById(filelist)).append('<div id="' + a.id + '">' + a.name + " (" + plupload.formatSize(a.size) + ") <b></b></div>");
                        });
                        jQuery("#upload-error").html(null);
                    },
                    UploadProgress: function (a, b) {
                        document.getElementById(b.id).getElementsByTagName("b")[0].innerHTML = "<span>" + b.percent + "%</span>";
                    },
                    Error: function (a, b) {
                        document.getElementById("console").innerHTML += "\nError #" + b.code + ": " + b.message;
                    },
                    FileUploaded: function (a, b, e) {

                        a = JSON.parse(e.response);
                        a.file && jQuery("#" + upload_id).attr("value", a.file);
                    }
                }
            });
            a.init();
            return this;
        };
        a.prototype.uploader = function () {
            var a = new plupload.Uploader({
                multi_selection: !1,
                runtimes: "html5,flash,silverlight,html4",
                browse_button: "pickfiles",
                container: document.getElementById("container"),
                url: "/banner/upload",
                flash_swf_url: "assets/js/plupload/Moxie.swf",
                silverlight_xap_url: "assets/js/plupload/Moxie.xap",
                init: {
                    PostInit: function () {
                        document.getElementById("filelist").innerHTML = "";
                        document.getElementById("uploadfiles").onclick = function () {
                            a.start();
                            return !1;
                        };
                    },
                    FilesAdded: function (a, b) {
                        var e = !0;
                        jQuery.each(b, function (b, d) {
                            var c, f = d.name;
                            c = ["png", "jpg", "bmp", "jpeg"];
                            c instanceof String && (c = [c]);
                            0 < f.length ? (f = f.substr(f.lastIndexOf(".") + 1).toLowerCase(), c = -1 !== c.indexOf(f) ? !0 : !1) : c = !1;
                            c || (e = !1, a.removeFile(d));
                        });
                        if (!e && 1 >= b.length) {
                            return a.splice(), a.refresh(), jQuery("#upload-error").html("File is not allowed."), !1;
                        }
                        plupload.each(b, function (a) {
                            jQuery(document.getElementById("filelist")).append('<div id="' + a.id + '">' + a.name + " (" + plupload.formatSize(a.size) + ") <b></b></div>");
                        });
                        jQuery("#upload-error").html(null);
                    },
                    UploadProgress: function (a, b) {
                        document.getElementById(b.id).getElementsByTagName("b")[0].innerHTML = "<span>" + b.percent + "%</span>";
                    },
                    Error: function (a, b) {
                        document.getElementById("console").innerHTML += "\nError #" + b.code + ": " + b.message;
                    },
                    FileUploaded: function (a, b, e) {
                        a = JSON.parse(e.response);
                        a.file && jQuery("#upload_id").attr("value", a.file);
                    }
                }
            });
            a.init();
            return this;
        };
        b.prototype.edit = function () {
            var a = {
                email: {
                    required: !0,
                    myRule: {
                        url: "/home/inputValidator?source=admin",
                        type: "post",
                        data: {
                            email: function () {
                                return jQuery("#email").val();
                            },
                            id: jQuery("#bz").attr("data-id")
                        }
                    }
                },
                name: "required"
            };
            jQuery("#bz").attr("data-id") || (a.password = {
                required: !0,
                minlength: 6
            });
            jQuery(".validation-required").validate({
                rules: a
            });
            return this;
        };
        c.prototype.massactionApply = function (a) {
            var check = confirm("Are you sure delete user?");
            if (check) {
                a.preventDefault();
                a = jQuery(a.currentTarget);
                for (var b = jQuery(".massaction-checkbox:checked"), c = 0, d, f = []; d = b[c++]; ) {
                    d = jQuery(d), f.push(d.attr("data-value"));
                }
                f = f.join(",");
                console.log(f);
                b = k("input", {
                    type: "hidden",
                    name: "ids",
                    value: f
                });
                a = k("form", {
                    method: "POST",
                    action: a.attr("href")
                });
                b.appendTo(a);
                a.appendTo(document.body).submit();
            } else {
                return false;
            }

        };
        c.prototype.massaction = function () {
            jQuery(document.body).on("click", "#delete_all", m(this.massactionApply, this));
        };
        c.prototype.deleteAll = function () {
            $(document).on('click', '.checkall', function () {
                if (0 < jQuery(".massaction-checkbox:checked").length && !jQuery(".checkall:checked").length) {
                    $('input:checkbox').prop('checked', false);
                    jQuery("#delete_all").addClass("hidden")
                }
            });
            (0 < jQuery(".massaction-checkbox:checked").length || 0 < jQuery(".checkall:checked").length) ? jQuery("#delete_all").removeClass("hidden") : jQuery("#delete_all").addClass("hidden");

        };
        c.prototype.index = function () {
            jQuery(".search-button").on("click", m(this.search, this));
            jQuery(".search-input").on("keypress", function (a) {
                13 == a.which && this.search(a);
            }.bind(this));
            jQuery(".change-password").on("click", m(this.changePassword, this));
            jQuery(document.body).on("click", ".massaction-checkbox", m(this.deleteAll, this));
            jQuery(document.body).on("click", ".checkall", m(this.deleteAll, this));
            this.massaction();
            return this;
        };
        c.prototype.search = function (a) {
            a.preventDefault();
            var b = {};
            jQuery(".search-fields").map(function (a, c) {
                c = jQuery(c);
                b[c.attr("data-field")] = c.val();
            });
            b = jQuery.param(b);
            window.location.href = "/user?" + b;
        };
        c.prototype.changePassword = function (a) {
            a.preventDefault();
            a = jQuery(a.currentTarget);
            a = a.attr("data-id");
            var b;
            b = '<form class="form-horizontal change-password-form" role="form"><div class="form-group">         <label class="col-lg-4 control-label">Enter new password</label>         <div class="col-lg-7">           <div class="form-row-input">             <input type="text" class="form-control change-password-form-password" name="password" />           </div>         </div>       </div></form>';
            BootstrapDialog.show({
                title: "Change password",
                message: b,
                onshow: function (a) {},
                onshown: function (a) {
                    var b = a.getButton("save").disable();
                    jQuery(".change-password-form-password").on("keyup", function () {
                        jQuery(this).val() ? b.enable() : b.disable();
                    });
                },
                buttons: [{
                        id: "save",
                        label: "Save",
                        cssClass: "btn btn-success",
                        action: function (b) {
                            var c = jQuery(".change-password-form-password").val();
                            if (c) {
                                return p({
                                    url: "/user/newpassword",
                                    method: "post",
                                    data: {
                                        np: c,
                                        id: a
                                    }
                                }).done(function () {
                                    b.close();
                                }), this;
                            }
                            b.close();
                        }
                    }]
            });
        };
        c.prototype.edit = function () {
            var a = jQuery("input[name=email]"),
                    b = jQuery("#bz").attr("data-id"),
                    c = jQuery("input[name=phone_number]");

            jQuery(".validation-required").validate({
                rules: {
                    email: {
                        required: !0,
                        myRule: {
                            url: "/home/inputValidator?source=user.email",
                            type: "post",
                            data: {
                                email: function () {
                                    return a.val();
                                },
                                id: b
                            }
                        }
                    },
                    phone_number: {
                        required: !0,
                        myRule: {
                            url: "/home/inputValidator?source=user.phone",
                            type: "post",
                            data: {
                                phone_number: function () {
                                    return c.val();
                                },
                                id: b
                            }
                        }
                    }
                }
            });
            return this.uploader('filelist1', 'pickfiles1', 'uploadfiles1', 'driver_license').uploader('filelist', 'pickfiles', 'uploadfiles', 'avatar').uploader('filelist2', 'pickfiles2', 'uploadfiles2', 'identify');
        };

        c.prototype.uploader = function (filelist, select, upload, upload_id) {
            var a = new plupload.Uploader({
                multi_selection: !1,
                runtimes: "html5,flash,silverlight,html4",
                browse_button: select,
                container: document.getElementById("container"),
                url: "/user/upload",
                flash_swf_url: "assets/js/plupload/Moxie.swf",
                silverlight_xap_url: "assets/js/plupload/Moxie.xap",
                init: {
                    PostInit: function () {
                        document.getElementById(filelist).innerHTML = "";
                        document.getElementById(upload).onclick = function () {
                            a.start();
                            return !1;
                        };
                    },
                    FilesAdded: function (a, b) {

                        var e = !0;
                        jQuery.each(b, function (b, d) {
                            var c, f = d.name;
                            c = ["png", "jpg", "bmp", "jpeg"];
                            c instanceof String && (c = [c]);
                            0 < f.length ? (f = f.substr(f.lastIndexOf(".") + 1).toLowerCase(), c = -1 !== c.indexOf(f) ? !0 : !1) : c = !1;
                            c || (e = !1, a.removeFile(d));
                        });
                        if (!e && 1 >= b.length) {
                            return a.splice(), a.refresh(), jQuery("#upload-error").html("File is not allowed."), !1;
                        }
                        plupload.each(b, function (a) {
                            jQuery(document.getElementById(filelist)).append('<div id="' + a.id + '">' + a.name + " (" + plupload.formatSize(a.size) + ") <b></b></div>");
                        });
                        jQuery("#upload-error").html(null);
                    },
                    UploadProgress: function (a, b) {
                        document.getElementById(b.id).getElementsByTagName("b")[0].innerHTML = "<span>" + b.percent + "%</span>";
                    },
                    Error: function (a, b) {
                        document.getElementById("console").innerHTML += "\nError #" + b.code + ": " + b.message;
                    },
                    FileUploaded: function (a, b, e) {

                        a = JSON.parse(e.response);
                        a.file && jQuery("#" + upload_id).attr("value", a.file);
                    }
                }
            });
            a.init();
            return this;
        };
        c.prototype.review = function () {

            jQuery(".search-button").on("click", m(this.search_review, this));
            jQuery(".datetimepicker").datetimepicker({
                format: "YYYY-MM-DD HH:mm",
                showClear: !0,
                showClose: !0,
                tooltips: {
                    today: "Go to today",
                    clear: "Clear selection",
                    close: "Close the picker",
                    selectMonth: "Select Month",
                    prevMonth: "Previous Month",
                    nextMonth: "Next Month",
                    selectYear: "Select Year",
                    prevYear: "Previous Year",
                    nextYear: "Next Year",
                    selectDecade: "Select Decade",
                    prevDecade: "Previous Decade",
                    nextDecade: "Next Decade",
                    prevCentury: "Previous Century",
                    nextCentury: "Next Century"
                }
            });

            jQuery(".datetimepicker").find("input").on("keydown", function () {
                console.log("run");
                return !1;
            });
            jQuery(document.body).on("click", ".massaction-checkbox", m(this.deleteAll, this));
            jQuery(document.body).on("click", ".checkall", m(this.deleteAll, this));
            this.massaction();
            return this;
        };
        c.prototype.search_review = function (a) {
            a.preventDefault();
            var b = {};
            jQuery(".search-fields").map(function (a, c) {
                c = jQuery(c);
                b[c.attr("data-field")] = c.val();
            });
            b = jQuery.param(b);
            window.location.href = "/user/review?" + b;
        };
        d.prototype.massactionApply = function (a) {
            var check = confirm("Are you sure delete this trip?");
            if (check) {
                a.preventDefault();
                a = jQuery(a.currentTarget);
                for (var b = jQuery(".massaction-checkbox:checked"), c = 0, d, f = []; d = b[c++]; ) {
                    d = jQuery(d), f.push(d.attr("data-value"));
                }
                f = f.join(",");
                console.log(f);
                b = k("input", {
                    type: "hidden",
                    name: "ids",
                    value: f
                });
                a = k("form", {
                    method: "POST",
                    action: a.attr("href")
                });
                b.appendTo(a);
                a.appendTo(document.body).submit();
            } else {
                return false;
            }
        };
        d.prototype.massaction = function () {
            jQuery(document.body).on("click", "#delete_all", m(this.massactionApply, this));
        };
        d.prototype.deleteAll = function () {
            $(document).on('click', '.checkall', function () {
                if (0 < jQuery(".massaction-checkbox:checked").length && !jQuery(".checkall:checked").length) {
                    $('input:checkbox').prop('checked', false);
                    jQuery("#delete_all").addClass("hidden")
                }
            });
            (0 < jQuery(".massaction-checkbox:checked").length || 0 < jQuery(".checkall:checked").length) ? jQuery("#delete_all").removeClass("hidden") : jQuery("#delete_all").addClass("hidden");
        };
        d.prototype.index = function () {

            jQuery(".search-button").on("click", m(this.search, this));
            jQuery(".datetimepicker").datetimepicker({
                format: "YYYY-MM-DD HH:mm",
                showClear: !0,
                showClose: !0,
                tooltips: {
                    today: "Go to today",
                    clear: "Clear selection",
                    close: "Close the picker",
                    selectMonth: "Select Month",
                    prevMonth: "Previous Month",
                    nextMonth: "Next Month",
                    selectYear: "Select Year",
                    prevYear: "Previous Year",
                    nextYear: "Next Year",
                    selectDecade: "Select Decade",
                    prevDecade: "Previous Decade",
                    nextDecade: "Next Decade",
                    prevCentury: "Previous Century",
                    nextCentury: "Next Century"
                }
            });

            jQuery(".datetimepicker").find("input").on("keydown", function () {
                console.log("run");
                return !1;
            });
            jQuery(document.body).on("click", ".massaction-checkbox", m(this.deleteAll, this));
            jQuery(document.body).on("click", ".checkall", m(this.deleteAll, this));
            this.massaction();
            return this;
        };
        d.prototype.search = function (a) {
            a.preventDefault();
            var b = {};
            jQuery(".search-fields").map(function (a, c) {
                c = jQuery(c);
                b[c.attr("data-field")] = c.val();
            });
            b = jQuery.param(b);
            window.location.href = "/trip?" + b;
        };
        z.prototype.index = function () {
            jQuery(".search-button").on("click", m(this.search, this));
            jQuery(".datetimepicker").datetimepicker({
                format: "YYYY-MM-DD HH:mm",
                showClear: !0,
                showClose: !0,
                tooltips: {
                    today: "Go to today",
                    clear: "Clear selection",
                    close: "Close the picker",
                    selectMonth: "Select Month",
                    prevMonth: "Previous Month",
                    nextMonth: "Next Month",
                    selectYear: "Select Year",
                    prevYear: "Previous Year",
                    nextYear: "Next Year",
                    selectDecade: "Select Decade",
                    prevDecade: "Previous Decade",
                    nextDecade: "Next Decade",
                    prevCentury: "Previous Century",
                    nextCentury: "Next Century"
                }
            });
            jQuery(".datetimepicker").find("input").on("keydown", function () {
                console.log("run");
                return !1;
            });
        };
        z.prototype.search = function (a) {
            a.preventDefault();
            var b = {};
            jQuery(".search-fields").map(function (a, c) {
                c = jQuery(c);
                b[c.attr("data-field")] = c.val();
            });
            b = jQuery.param(b);
            window.location.href = "/trip/relate_trip?" + b;
        };
        l("l", function () {
            q();
            var a = jQuery("#bz");
            a.length && eval(a.attr("script"));
        });
        p.prototype.search = function (a) {
            a.preventDefault();
            var b = {};
            jQuery(".search-fields").map(function (a, c) {
                c = jQuery(c);
                b[c.attr("data-field")] = c.val();
            });
            b = jQuery.param(b);
            window.location.href = "/coupon/index?" + b;
        };

        p.prototype.init = function () {};
        p.prototype.index = function () {
            jQuery(".search-button").on("click", m(this.search, this));
            jQuery(document.body).on("click", ".massaction-checkbox, .checkall", m(this.deleteAll, this));
            this.massaction();
            return this;
        };
        p.prototype.massaction = function () {
            jQuery(document.body).on("click", "#delete_all", m(this.massactionApply, this));
        };
        p.prototype.massactionApply = function (a) {
            a.preventDefault();
            a = jQuery(a.currentTarget);
            for (var b = jQuery(".massaction-checkbox:checked"), c = 0, d, f = []; d = b[c++]; ) {
                d = jQuery(d), f.push(d.attr("data-value"));
            }
            f = f.join(",");
            console.log(f);
            b = k("input", {
                type: "hidden",
                name: "ids",
                value: f
            });
            a = k("form", {
                method: "POST",
                action: a.attr("href")
            });
            b.appendTo(a);
            a.appendTo(document.body).submit();
        };
        p.prototype.edit = function () {
            return this.form().datePicker().uploader();
        };
        p.prototype.form = function () {
            jQuery(".validation-required").validate({
                rules: {
                    pr_text: "required",
                    discount_type: "required",
                    discount_value: "required",
                    campaign_banner: "required",
                    start_datetime: "required",
                    end_datetime: "required"
                }
            });
            return this;
        };
        p.prototype.datePicker = function () {
//            jQuery(".datetimepicker").datetimepicker({
//                format: "YYYY-MM-DD HH:mm"
//            });
            jQuery(".datetimepicker").datetimepicker({
                format: "YYYY-MM-DD HH:mm",
                showClear: !0,
                showClose: !0,
                tooltips: {
                    today: "Go to today",
                    clear: "Clear selection",
                    close: "Close the picker",
                    selectMonth: "Select Month",
                    prevMonth: "Previous Month",
                    nextMonth: "Next Month",
                    selectYear: "Select Year",
                    prevYear: "Previous Year",
                    nextYear: "Next Year",
                    selectDecade: "Select Decade",
                    prevDecade: "Previous Decade",
                    nextDecade: "Next Decade",
                    prevCentury: "Previous Century",
                    nextCentury: "Next Century"
                }
            });
            jQuery(".datetimepicker").find("input").on("keydown", function () {
                console.log("run");
                return !1;
            });
            return this;
        };
        p.prototype.deleteAll = function () {

            $(document).on('click', '.checkall', function () {
                if (0 < jQuery(".massaction-checkbox:checked").length && !jQuery(".checkall:checked").length) {
                    $('input:checkbox').prop('checked', false);
                    jQuery("#delete_all").addClass("hidden")
                }
//                $('input:checkbox').prop('checked', false);
//                $('.massaction-checkbox').prop('checked', this.checked);
            });
            (0 < jQuery(".massaction-checkbox:checked").length || 0 < jQuery(".checkall:checked").length) ? jQuery("#delete_all").removeClass("hidden") : jQuery("#delete_all").addClass("hidden");
        };
        p.prototype.uploader = function () {
            var a = new plupload.Uploader({
                multi_selection: !1,
                runtimes: "html5,flash,silverlight,html4",
                browse_button: "pickfiles",
                container: document.getElementById("container"),
                url: "/banner/upload",
                flash_swf_url: "assets/js/plupload/Moxie.swf",
                silverlight_xap_url: "assets/js/plupload/Moxie.xap",
                init: {
                    PostInit: function () {
                        document.getElementById("filelist").innerHTML = "";
                        document.getElementById("uploadfiles").onclick = function () {
                            a.start();
                            return !1;
                        };
                    },
                    FilesAdded: function (a, b) {
                        var e = !0;
                        jQuery.each(b, function (b, d) {
                            var c, f = d.name;
                            c = ["png", "jpg", "bmp", "jpeg"];
                            c instanceof String && (c = [c]);
                            0 < f.length ? (f = f.substr(f.lastIndexOf(".") + 1).toLowerCase(), c = -1 !== c.indexOf(f) ? !0 : !1) : c = !1;
                            c || (e = !1, a.removeFile(d));
                        });
                        if (!e && 1 >= b.length) {
                            return a.splice(), a.refresh(), jQuery("#upload-error").html("File is not allowed."), !1;
                        }
                        plupload.each(b, function (a) {
                            jQuery(document.getElementById("filelist")).append('<div id="' + a.id + '">' + a.name + " (" + plupload.formatSize(a.size) + ") <b></b></div>");
                        });
                        jQuery("#upload-error").html(null);
                    },
                    UploadProgress: function (a, b) {
                        document.getElementById(b.id).getElementsByTagName("b")[0].innerHTML = "<span>" + b.percent + "%</span>";
                    },
                    Error: function (a, b) {
                        document.getElementById("console").innerHTML += "\nError #" + b.code + ": " + b.message;
                    },
                    FileUploaded: function (a, b, e) {
                        a = JSON.parse(e.response);
                        a.file && jQuery("#upload_id").attr("value", a.file);
                    }
                }
            });
            a.init();
            return this;
        };
        tr.prototype.init = function () {};
        tr.prototype.index = function () {
            jQuery(".datetimepicker").datetimepicker({
                format: "YYYY-MM",
                showClear: !0,
                showClose: !0,
                tooltips: {
                    today: "Go to today",
                    clear: "Clear selection",
                    close: "Close the picker",
                    selectMonth: "Select Month",
                    prevMonth: "Previous Month",
                    nextMonth: "Next Month",
                    selectYear: "Select Year",
                    prevYear: "Previous Year",
                    nextYear: "Next Year",
                    selectDecade: "Select Decade",
                    prevDecade: "Previous Decade",
                    nextDecade: "Next Decade",
                    prevCentury: "Previous Century",
                    nextCentury: "Next Century"
                }
            });

            jQuery(".datetimepicker").find("input").on("keydown", function () {
                console.log("run");
                return !1;
            });
            jQuery(document.body).on("click", ".massaction-checkbox, .checkall", m(this.deleteAll, this));
            this.massaction();
            return this;
        };
        tr.prototype.detail = function () {
            return this.form().datePicker();
        };
        tr.prototype.form = function () {
            jQuery(".validation-required").validate({
                rules: {
                    pr_text: "required",
                    discount_type: "required",
                    discount_value: "required",
                    campaign_banner: "required",
                    start_datetime: "required",
                    end_datetime: "required"
                }
            });
            return this;
        };
        tr.prototype.datePicker = function () {
            jQuery(".datetimepicker").datetimepicker({
                format: "YYYY-MM",
                showClear: !0,
                showClose: !0,
                tooltips: {
                    today: "Go to today",
                    clear: "Clear selection",
                    close: "Close the picker",
                    selectMonth: "Select Month",
                    prevMonth: "Previous Month",
                    nextMonth: "Next Month",
                    selectYear: "Select Year",
                    prevYear: "Previous Year",
                    nextYear: "Next Year",
                    selectDecade: "Select Decade",
                    prevDecade: "Previous Decade",
                    nextDecade: "Next Decade",
                    prevCentury: "Previous Century",
                    nextCentury: "Next Century"
                }
            });
            jQuery(".datetimepicker").find("input").on("keydown", function () {
                console.log("run");
                return !1;
            });
            return this;
        };
        tr.prototype.massactionApply = function (a) {
            var check = confirm("Are you sure payment?");
            if (check) {
                a.preventDefault();
                a = jQuery(a.currentTarget);
                for (var b = jQuery(".massaction-checkbox:checked"), c = 0, d, f = []; d = b[c++]; ) {
                    d = jQuery(d), f.push(d.attr("data-value"));
                }
                f = f.join(",");
                console.log(f);
                b = k("input", {
                    type: "hidden",
                    name: "ids",
                    value: f
                });
                a = k("form", {
                    method: "POST",
                    action: a.attr("href")
                });
//                b.appendTo(a);
//                a.appendTo(document.body).submit();
                $.ajax({
                    url: '/transaction/',
                    method: "POST",
                    data: {ids: f, date: '<?php echo $date ?>'}
                }).done(function (msg) {
                    alert(msg);
                });
            } else {
                return false;
            }
        };
        tr.prototype.massaction = function () {
            jQuery(document.body).on("click", "#delete_all", m(this.massactionApply, this));
        };
        tr.prototype.deleteAll = function () {
            $(document).on('click', '.checkall', function () {
                if (0 < jQuery(".massaction-checkbox:checked").length && !jQuery(".checkall:checked").length) {
                    $('input:checkbox').prop('checked', false);
                    jQuery("#delete_all").addClass("hidden")
                }
            });
            (0 < jQuery(".massaction-checkbox:checked").length || 0 < jQuery(".checkall:checked").length) ? jQuery("#delete_all").removeClass("hidden") : jQuery("#delete_all").addClass("hidden");
        };
        can.prototype.init = function () {};
        can.prototype.index = function () {
            jQuery(".search-button").on("click", m(this.search, this));
            jQuery(".datetimepicker").datetimepicker({
                format: "YYYY-MM-DD",
                showClear: !0,
                showClose: !0,
                tooltips: {
                    today: "Go to today",
                    clear: "Clear selection",
                    close: "Close the picker",
                    selectMonth: "Select Month",
                    prevMonth: "Previous Month",
                    nextMonth: "Next Month",
                    selectYear: "Select Year",
                    prevYear: "Previous Year",
                    nextYear: "Next Year",
                    selectDecade: "Select Decade",
                    prevDecade: "Previous Decade",
                    nextDecade: "Next Decade",
                    prevCentury: "Previous Century",
                    nextCentury: "Next Century"
                }
            });

            jQuery(".datetimepicker").find("input").on("keydown", function () {
                console.log("run");
                return !1;
            });
            return this;
        };
        can.prototype.search = function (a) {
            a.preventDefault();
            var b = {};
            jQuery(".search-fields").map(function (a, c) {
                c = jQuery(c);
                b[c.attr("data-field")] = c.val();
            });
            b = jQuery.param(b);
            window.location.href = "/cancel?" + b;
        };
        claim.prototype.init = function () {};
        claim.prototype.index = function () {
            jQuery(".search-button").on("click", m(this.search, this));
            jQuery(".datetimepicker").datetimepicker({
                format: "YYYY-MM-DD",
                showClear: !0,
                showClose: !0,
                tooltips: {
                    today: "Go to today",
                    clear: "Clear selection",
                    close: "Close the picker",
                    selectMonth: "Select Month",
                    prevMonth: "Previous Month",
                    nextMonth: "Next Month",
                    selectYear: "Select Year",
                    prevYear: "Previous Year",
                    nextYear: "Next Year",
                    selectDecade: "Select Decade",
                    prevDecade: "Previous Decade",
                    nextDecade: "Next Decade",
                    prevCentury: "Previous Century",
                    nextCentury: "Next Century"
                }
            });

            jQuery(".datetimepicker").find("input").on("keydown", function () {
                console.log("run");
                return !1;
            });
            return this;
        };
        claim.prototype.search = function (a) {
            a.preventDefault();
            var b = {};
            jQuery(".search-fields").map(function (a, c) {
                c = jQuery(c);
                b[c.attr("data-field")] = c.val();
            });
            b = jQuery.param(b);
            window.location.href = "/claim?" + b;
        };
        
        app_log.prototype.init = function () {};
        app_log.prototype.index = function () {
            jQuery(".search-button").on("click", m(this.search, this));
            jQuery(".datetimepicker").datetimepicker({
                format: "YYYY-MM-DD",
                showClear: !0,
                showClose: !0,
                tooltips: {
                    today: "Go to today",
                    clear: "Clear selection",
                    close: "Close the picker",
                    selectMonth: "Select Month",
                    prevMonth: "Previous Month",
                    nextMonth: "Next Month",
                    selectYear: "Select Year",
                    prevYear: "Previous Year",
                    nextYear: "Next Year",
                    selectDecade: "Select Decade",
                    prevDecade: "Previous Decade",
                    nextDecade: "Next Decade",
                    prevCentury: "Previous Century",
                    nextCentury: "Next Century"
                }
            });

            jQuery(".datetimepicker").find("input").on("keydown", function () {
                console.log("run");
                return !1;
            });
            return this;
        };
        app_log.prototype.search = function (a) {
            a.preventDefault();
            var b = {};
            jQuery(".search-fields").map(function (a, c) {
                c = jQuery(c);
                b[c.attr("data-field")] = c.val();
            });
            b = jQuery.param(b);
            window.location.href = "/log?" + b;
        };
        l("campaign", new a);
        l("admin", new b);
        l("user", new c);
        l("trip", new d);
        l("relate_trip", new z);
        l("coupon", new p);
        l("transaction", new tr);
        l("can123", new can);
        l("claim123", new claim);
        l("log",new app_log);
    })();
})();

$(document).on('click', '.checkall', function () {
    if (0 < jQuery(".checkall:checked").length) {
        $('.massaction-checkbox').prop('checked', this.checked);
    }
});

