NotificationQueue = function(options) {
    var cfg = $.extend({
        max_shown: 5,

        url_pull_new:    '', pull_timeout: 20, // seconds
        message_timeout: 180, // seconds

        msg_position: 'bottom-left', animation_speed: 200,

        img_path: '/images/gritter', img_format: 'svg',

        body_length: 120 // reasonable default
    }, options);

    // added, danger, error, important, info, message, question, refresh, search, success.
    var showImg = function(name) {
        return cfg.img_path + '/' + name + '.' + cfg.img_format
    };

    var messages = [];

    var pullMessages = function() {
        $.ajax({
            url: cfg.url_pull_new, dataType: 'json'
        }).done(function(response) {
            if (response['success'] === 1 && response['messages'] !== '') {
                messages = $.merge(messages, response['messages']);
                showNext();
            }
        }).fail(function(a, b, c) {
            //#FIXME: reporting
        })
    };

    var showOne = function(msg) {
        var new_notification = {
            title:  msg.title,
            text:   msg.text.length > cfg.body_length ? msg.text.substr(0, cfg.body_length) + '...' : msg.text,
            image:  showImg(msg.icon),
            time:   cfg.message_timeout * 1000,
            sticky: false
        };

        if (msg.action) {
            new_notification.text += ' <a href="' + msg['action'] + '" target="_blank">' + msg['action_text'] + '</a>'
        }

        $.gritter.add($.extend(new_notification, {after_close: showNext}));
    };

    var showNext = function() {
        var curr_shown = $('.gritter-item-wrapper').length;
        var to_show = Math.min(messages.length, cfg.max_shown - curr_shown);

        if (to_show > 0) {
            for (var i = 0; i < to_show; i++) {
                showOne(messages.shift())
            }
        }
    };

    // init

    $.extend($.gritter.options, {
        position: cfg.msg_position, fade_in_speed: cfg.animation_speed, fade_out_speed: cfg.animation_speed
    });

    pullMessages();

    // visibility.js -- timer triggers only if site tab is visible
    Visibility.every(cfg.pull_timeout * 1000, pullMessages);
};