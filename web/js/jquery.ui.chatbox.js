/*
 * Copyright 2010, Wen Pu (dexterpu at gmail dot com)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * Check out http://www.cs.illinois.edu/homes/wenpu1/chatbox.html for document
 *
 * Depends on jquery.ui.core, jquery.ui.widiget, jquery.ui.effect
 *
 * Also uses some styles for jquery.ui.dialog
 *
 */

// TODO: implement destroy()
(function($) {
    $.widget("ui.chatbox", {
        options: {
            id: null, //id for the DOM element
            title: null, // title of the chatbox
            user: null, // can be anything associated with this chatbox
            hidden: false,
            offset: 0, // relative to right edge of the browser window
            width: 300, // width of the chatbox
            messageSentBase: function(id, user, msg) {
                // override this
                this.boxManager.addMsgBase(id, user.first_name, msg);
            },
            messageSent: function(id, user, msg) {
                // override this
                this.boxManager.addMsg(id, user.first_name, msg);
            },
            boxClosed: function(id) {
                // supprime le DIV id_box
                $("#" + id + '_box').remove();
                //
                // on récupère la position de l'id dans le tableau
                var pos = $.inArray(id, boxTab);
                // supprime un element de tab correspond à l'id
                boxTab = $.grep(boxTab, function(value) {
                    return value != id;
                });

                // animation vers la droite des div se trouvant à gauche de celui supprimé
                var mg = 0;
                for (i = pos; i < boxTab.length; i++) {
                    mg = i * (300 + $espaceEntreBox) + $margeDroiteDesBox;
                    $("#" + boxTab[i] + '_box').animate({right: mg + 'px'});
                }


            }, // called when the close icon is clicked
            boxManager: {
                // thanks to the widget factory facility
                // similar to http://alexsexton.com/?p=51
                init: function(elem) {
                    this.elem = elem;
                },
                addMsg: function(id, peer, msg) {
                    var self = this;
                    var box = self.elem.uiChatboxLog;
                    var e = document.createElement('div');
                    box.append(e);
                    $(e).hide();

                    var systemMessage = false;

                    if (peer) {
                        var peerName = document.createElement("b");
                        $(peerName).text(peer + ": ");
                        e.appendChild(peerName);
                    } else {
                        systemMessage = true;
                    }

                    var msgElement = document.createElement(
                            systemMessage ? "i" : "span");
                    $(msgElement).text(msg);
                    e.appendChild(msgElement);
                    $(e).addClass("ui-chatbox-msg");
                    $(e).css("maxWidth", $(box).width());
                    $(e).fadeIn();
                    self._scrollToBottom();

                    if (!self.elem.uiChatboxTitlebar.hasClass("ui-state-focus")
                            && !self.highlightLock) {
                        self.highlightLock = true;
                        self.highlightBox();
                    }
                    //ligne prend pour valeur l'émetteur, le récepteur et le message
                    var ligne = peer + '--' + id + '--' + msg;

                },
                //--------------------------------------------------
                // Fonction ajoute message (enregistrement en base)
                //--------------------------------------------------
                addMsgBase: function(id, peer, msg) {
                    var self = this;
                    var box = self.elem.uiChatboxLog;
                    var e = document.createElement('div');
                    box.append(e);
                    $(e).hide();

                    var systemMessage = false;

                    if (peer) {
                        var peerName = document.createElement("b");
                        $(peerName).text(peer + ": ");
                        e.appendChild(peerName);
                    } else {
                        systemMessage = true;
                    }

                    var msgElement = document.createElement(
                            systemMessage ? "i" : "span");
                    $(msgElement).text(msg);
                    e.appendChild(msgElement);
                    $(e).addClass("ui-chatbox-msg");
                    $(e).css("maxWidth", $(box).width());
                    $(e).fadeIn();
                    self._scrollToBottom();

                    if (!self.elem.uiChatboxTitlebar.hasClass("ui-state-focus")
                            && !self.highlightLock) {
                        self.highlightLock = true;
                        self.highlightBox();
                    }
                    //ligne prend pour valeur l'émetteur, le récepteur et le message
                    var ligne = peer + '--' + id + '--' + msg;

                    // Je passe au Controller addMessageBase de ChatBundle l'émetteur, le récepteur et le message
                    $.ajax({
                        type: "POST",
                        url: Routing.generate('ws_chat_addMessageBase'),
                        data: {emetteur: peer, recepteur: id, message: msg},
                        cache: false
                    });

                },
                //--------------------------
                highlightBox: function() {
                    var self = this;
                    self.elem.uiChatboxTitlebar.effect("highlight", {}, 300);
                    self.elem.uiChatbox.effect("bounce", {times: 3}, 300, function() {
                        self.highlightLock = false;
                        self._scrollToBottom();
                    });
                },
                toggleBox: function() {
                    this.elem.uiChatbox.toggle();
                },
                _scrollToBottom: function() {
                    var box = this.elem.uiChatboxLog;
                    box.scrollTop(box.get(0).scrollHeight);
                }
            }
        },
        toggleContent: function(event) {
            this.uiChatboxContent.toggle();
            if (this.uiChatboxContent.is(":visible")) {
                this.uiChatboxInputBox.focus();
            }
        },
        widget: function() {
            return this.uiChatbox;
        },
        _create: function() {
            var self = this,
                    options = self.options,
                    title = options.title || "No Title",
                    // chatbox
                    uiChatbox = (self.uiChatbox = $('<div class="chatbox"></div>'))
                    //.appendTo(document.body)
                    // chaque création de Box est contenu dans le DIV "#chat_div"
                    .appendTo("#chat_div")
                    // le DIV qui est créé pour la box a pour id l'utilisateur
                    .attr('id', options.id + '_box')
                    .addClass('ui-widget ' +
                    'ui-corner-top ' +
                    'ui-chatbox'
                    )
                    .attr('outline', 0)
                    .focusin(function() {
                // ui-state-highlight is not really helpful here
                //self.uiChatbox.removeClass('ui-state-highlight');
                self.uiChatboxTitlebar.addClass('ui-state-focus');
            })
                    .focusout(function() {
                self.uiChatboxTitlebar.removeClass('ui-state-focus');
            }),
                    // titlebar
                    uiChatboxTitlebar = (self.uiChatboxTitlebar = $('<div></div>'))
                    .addClass('ui-widget-header ' +
                    'ui-corner-top ' +
                    'ui-chatbox-titlebar ' +
                    'ui-dialog-header' // take advantage of dialog header style
                    )
                    .click(function(event) {
                self.toggleContent(event);
            })
                    .appendTo(uiChatbox),
                    uiChatboxTitle = (self.uiChatboxTitle = $('<span></span>'))
                    .html(title)
                    .appendTo(uiChatboxTitlebar),
                    uiChatboxTitlebarClose = (self.uiChatboxTitlebarClose = $('<a href="#"></a>'))
                    .addClass('ui-corner-all ' +
                    'ui-chatbox-icon '
                    )
                    .attr('role', 'button')
                    .hover(function() {
                uiChatboxTitlebarClose.addClass('ui-state-hover');
            },
                    function() {
                        uiChatboxTitlebarClose.removeClass('ui-state-hover');
                    })
                    .click(function(event) {
                uiChatbox.hide();
                self.options.boxClosed(self.options.id);
                return false;
            })
                    .appendTo(uiChatboxTitlebar),
                    uiChatboxTitlebarCloseText = $('<span></span>')
                    .addClass('ui-icon ' +
                    'ui-icon-closethick')
                    .text('close')
                    .appendTo(uiChatboxTitlebarClose),
                    uiChatboxTitlebarMinimize = (self.uiChatboxTitlebarMinimize = $('<a href="#"></a>'))
                    .addClass('ui-corner-all ' +
                    'ui-chatbox-icon'
                    )
                    .attr('role', 'button')
                    .hover(function() {
                uiChatboxTitlebarMinimize.addClass('ui-state-hover');
            },
                    function() {
                        uiChatboxTitlebarMinimize.removeClass('ui-state-hover');
                    })
                    .click(function(event) {
                self.toggleContent(event);
                return false;
            })
                    .appendTo(uiChatboxTitlebar),
                    uiChatboxTitlebarMinimizeText = $('<span></span>')
                    .addClass('ui-icon ' +
                    'ui-icon-minusthick')
                    .text('minimize')
                    .appendTo(uiChatboxTitlebarMinimize),
                    // content
                    uiChatboxContent = (self.uiChatboxContent = $('<div></div>'))
                    .addClass('ui-widget-content ' +
                    'ui-chatbox-content '
                    )
                    .appendTo(uiChatbox),
                    uiChatboxLog = (self.uiChatboxLog = self.element)
                    .addClass('ui-widget-content ' +
                    'ui-chatbox-log'
                    )
                    .appendTo(uiChatboxContent),
                    uiChatboxInput = (self.uiChatboxInput = $('<div></div>'))
                    .addClass('ui-widget-content ' +
                    'ui-chatbox-input'
                    )
                    .click(function(event) {
                // anything?
            })
                    .appendTo(uiChatboxContent),
                    uiChatboxInputBox = (self.uiChatboxInputBox = $('<textarea></textarea>'))
                    .addClass('ui-widget-content ' +
                    'ui-chatbox-input-box ' +
                    'ui-corner-all'
                    )
                    .appendTo(uiChatboxInput)
                    .keydown(function(event) {
                if (event.keyCode && event.keyCode == $.ui.keyCode.ENTER) {
                    msg = $.trim($(this).val());
                    if (msg.length > 0) {
                        self.options.messageSent(self.options.id, self.options.user, msg);
                    }
                    $(this).val('');
                    return false;
                }
            })
                    .focusin(function() {
                uiChatboxInputBox.addClass('ui-chatbox-input-focus');
                var box = $(this).parent().prev();
                box.scrollTop(box.get(0).scrollHeight);
            })
                    .focusout(function() {
                uiChatboxInputBox.removeClass('ui-chatbox-input-focus');
            });

            // disable selection
            uiChatboxTitlebar.find('*').add(uiChatboxTitlebar).disableSelection();

            // switch focus to input box when whatever clicked
            uiChatboxContent.children().click(function() {
                // click on any children, set focus on input box
                self.uiChatboxInputBox.focus();
            });

            self._setWidth(self.options.width);
            self._position(self.options.offset);

            self.options.boxManager.init(self);

            if (!self.options.hidden) {
                uiChatbox.show();
            }
        },
        _setOption: function(option, value) {
            if (value != null) {
                switch (option) {
                    case "hidden":
                        if (value)
                            this.uiChatbox.hide();
                        else
                            this.uiChatbox.show();
                        break;
                    case "offset":
                        this._position(value);
                        break;
                    case "width":
                        this._setWidth(value);
                        break;
                }
            }
            $.Widget.prototype._setOption.apply(this, arguments);
        },
        _setWidth: function(width) {
            this.uiChatboxTitlebar.width((width + 2) + "px");
            this.uiChatboxLog.width(width + "px");
            this.uiChatboxInput.css("maxWidth", width + "px");
            // padding:2, boarder:2, margin:5
            this.uiChatboxInputBox.css("width", (width - 18) + "px");
        },
        _position: function(offset) {
            this.uiChatbox.css("right", offset);
        }
    });
}(jQuery));
