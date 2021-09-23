export function makeid(length, group = 'all') {

    if (!window.ids) {
        window.ids = {};
    }

    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    if (window.ids[group + '_' + result]) {
        return makeid(length, group);
    }
    window.ids[group + '_' + result] = group;
    return group + '_' + result;
}

export function randomColor() {
    return '#' + Math.floor(Math.random() * 16777215).toString(16);
}

export function copyArray(array) {

    if (!array) return [];

    try {
        return JSON.parse(JSON.stringify(array));
    } catch (error) {
        alert(array);
        return [];
    }
}

export function toCamelCase(str) {
    return str.replaceAll('_', '-').replace(/\b(\w)/g, function (match, capture) {
        return capture.toUpperCase();
    }).replace(/[^a-zA-Z0-9/ ]/g, '');
}

export function unCamelCase(str) {
    return str.replace(/([A-Z])/g, ' $1')
        .replace(/^./, function (str) { return str.toUpperCase(); });
}

export function addScript(src, id, callback) {

    if (!document.getElementById(id)) {
        const script = document.createElement("script");
        script.id = id;
        script.src = src;
        script.async = true;

        script.onload = () => {
            callback();
        };

        document.body.appendChild(script);
    } else {
        callback();
    }
}

export function convertListToTree(list) {

    var map = {}, node, roots = [], i;

    for (i = 0; i < list.length; i += 1) {
        map[list[i].id] = i; // initialize the map
        list[i].children = []; // initialize the children
        if (list[i].expanded === undefined) {
            list[i].expanded = true;
        }
    }

    for (i = 0; i < list.length; i += 1) {
        node = list[i];
        if (node.parent !== "0" && list[map[node.parent]]) {
            // if you have dangling branches check that map[node.parentId] exists
            list[map[node.parent]].children.push(node);
        } else {
            roots.push(node);
        }
    }
    return roots;
}

export function copyTextToClipboard(text) {
    let textArea = document.createElement("textarea");

    //
    // *** This styling is an extra step which is likely not required. ***
    //
    // Why is it here? To ensure:
    // 1. the element is able to have focus and selection.
    // 2. if the element was to flash render it has minimal visual impact.
    // 3. less flakyness with selection and copying which **might** occur if
    //    the textarea element is not visible.
    //
    // The likelihood is the element won't even render, not even a
    // flash, so some of these are just precautions. However in
    // Internet Explorer the element is visible whilst the popup
    // box asking the user for permission for the web page to
    // copy to the clipboard.
    //

    // Place in the top-left corner of screen regardless of scroll position.
    textArea.style.position = 'fixed';
    textArea.style.top = 0;
    textArea.style.left = 0;

    // Ensure it has a small width and height. Setting to 1px / 1em
    // doesn't work as this gives a negative w/h on some browsers.
    textArea.style.width = '2em';
    textArea.style.height = '2em';

    // We don't need padding, reducing the size if it does flash render.
    textArea.style.padding = 0;

    // Clean up any borders.
    textArea.style.border = 'none';
    textArea.style.outline = 'none';
    textArea.style.boxShadow = 'none';

    // Avoid flash of the white box if rendered for any reason.
    textArea.style.background = 'transparent';


    textArea.value = text;

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    textArea.setSelectionRange(0, 99999);

    try {
        let successful = document.execCommand('copy');
        let msg = successful ? 'successful' : 'unsuccessful';
        console.log('Copying text command was ' + msg);
    } catch (err) {
        console.log('Oops, unable to copy');
    }

    document.body.removeChild(textArea);
}

export function dateFormat(date) {
    if (date instanceof Date) {
        return date.getFullYear() + '-' + (('0' + (date.getMonth() + 1)).slice(-2)) + '-' + (('0' + date.getDate()).slice(-2));
    }
    return date;
}

export function dateTimeFormat(date) {
    if (date instanceof Date) {
        return date.getFullYear() + '-' + (('0' + (date.getMonth() + 1)).slice(-2)) + '-' + (('0' + date.getDate()).slice(-2)) + ' ' + (('0' + date.getHours()).slice(-2)) + ':' + (('0' + date.getMinutes()).slice(-2)) + ':' + (('0' + date.getSeconds()).slice(-2));
    }
    return date;
}


export function imagePlugin(plugin, img) {
    return '/plugins/' + plugin + '/img/' + img;
}

export function imageCMS(img) {
    return '/img/' + img;
}

export function humanFileSize(bytes, si = false, dp = 1) {
    const thresh = si ? 1000 : 1024;

    if (Math.abs(bytes) < thresh) {
        return bytes + ' B';
    }

    const units = si
        ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
        : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
    let u = -1;
    const r = 10 ** dp;

    do {
        bytes /= thresh;
        ++u;
    } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);


    return bytes.toFixed(dp) + ' ' + units[u];
}