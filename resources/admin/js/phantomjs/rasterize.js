/**
 * Usage: rasterize.js URL filename [paperwidth*paperheight|paperformat] [zoom]
 * paper (pdf output) examples: "5in*7.5in", "10cm*20cm", "A4", "Letter"
 * image (png/jpg output) examples: "1920px" entire page, window width 1920px
 * "800px*600px" window, clipped to 800x600
 */
var page = require('webpage').create(), system = require('system'), output, size, pageWidth, pageHeight;

if (system.args.length < 3 || system.args.length > 5) {
    phantom.exit(1);
} else {

    address = system.args[1];
    output = system.args[2];
    page.viewportSize = {width: 1366, height: 768};

    if (system.args.length > 3 && system.args[2].substr(-4) === ".pdf") {
        size = system.args[3].split('*');
        page.paperSize = size.length === 2 ? {width: size[0], height: size[1], margin: '0px'} : {
            format: system.args[3], orientation: 'portrait', margin: '1cm'
        };
    } else if (system.args.length > 3 && system.args[3].substr(-2) === "px") {
        size = system.args[3].split('*');
        if (size.length === 2) {
            pageWidth = parseInt(size[0], 10);
            pageHeight = parseInt(size[1], 10);
            page.viewportSize = {width: pageWidth, height: pageHeight};
            page.clipRect = {top: 0, left: 0, width: pageWidth, height: pageHeight};
        } else {
            pageWidth  = parseInt(system.args[3], 10);
            pageHeight = parseInt(pageWidth * 3 / 4, 10); // it's as good an assumption as any
            page.viewportSize = {width: pageWidth, height: pageHeight};
        }
    }
    if (system.args.length > 4) {
        page.zoomFactor = system.args[4];
    }

    page.settings.resourceTimeout = 15000;

    page.open(address, function(status) {
        if (status !== 'success') {
            console.log('Unable to load the address!');
            phantom.exit();
        } else {
            try {
                window.setTimeout(function() {
                    page.evaluate(function () {
                        var style = document.createElement('style'),
                            text = document.createTextNode('body {background: #fff}');
                        style.setAttribute('type', 'text/css');
                        style.appendChild(text);
                        document.head.insertBefore(style, document.head.firstChild);
                    });
                    page.render(output, {format: 'jpg', quality: 60});
                    phantom.exit();
                }, 10000);
            } catch (e) {
            }
        }
    });
}

