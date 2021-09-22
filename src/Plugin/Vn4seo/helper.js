export function convertMSTime(time) {

    if (time < 1000) {
        return time.toFixed(0) + ' ms';
    }
    return (time / 1000).toFixed(1) + ' s';
};

export function scoreLabel(score) {
    if (score === null) {
        return 'notapplicable';
    }

    if (!score) {
        return 'slow';
    }
    if (score <= 0.49) {
        return 'slow';
    }

    if (score <= 0.89) {
        return 'average';
    }

    return 'fast';
}

export function formatBytes(bytes, decimals = 1) {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

export function numberToThousoun(value) {
    // Nine Zeroes for Billions
    return Math.abs(Number(value)) >= 1.0e+9
        ? ((Math.abs(Number(value)) / 1.0e+9).toFixed(2) * 1) + "B"
        // Six Zeroes for Millions 
        : Math.abs(Number(value)) >= 1.0e+6
            ? ((Math.abs(Number(value)) / 1.0e+6).toFixed(2) * 1) + "M"
            // Three Zeroes for Thousands
            : Math.abs(Number(value)) >= 1.0e+3
                ? ((Math.abs(Number(value)) / 1.0e+3).toFixed(1) * 1) + "K"
                : Math.abs(Number(value));
}

export function getValueType(value, type) {
    switch (type) {
        case 'thumbnail':
            return '<img src="' + value + '" />';
        case 'url':
            return '<a href="' + value + '" rel="noreferrer" target="_blank">...' + value.substring(value.length - 30, value.length) + '</a>';
        case 'bytes':
            return formatBytes(value);
        case 'timespanMs':
            return convertMSTime(value);
        case 'text':
        case 'numeric':
            return value;
        case 'code':
            if (value) {
                return '<code>' + (value.replaceAll('<', '&lt;')) + '</code>';
            }
            return '';
        case 'link':
            if (value.type === 'link') {
                return '<a class="link" href="' + value.url + '" rel="noreferrer" target="_blank">' + value.text + '</a>';
            }
            return 'LINK';
        case 'source-location':
            if (value.type === 'source-location') {
                return '<a href="' + value.url + '" rel="noreferrer" target="_blank">...' + value.url.substring(value.url.length - 30, value.url.length) + '</a>';
            }
            if (value.type === 'code') {
                return value.value;
            }
            return 'SOURCE-LOCATION';
        case 'ms':
            return (value ? (new Intl.NumberFormat().format(value.toFixed(0))) : 0) + ' ms';
        case 'node':
            return value.nodeLabel + '<br /><code>' + (value.snippet.replaceAll('<', '&lt;')) + '</code>';
        default:
            return '<span style="color:red;">' + type + '</span>';
    }
}

export function findLinkMessage(str) {
    let result = str.match(/\[([^)]+)\]\(([^)]+)\)/g);
    if (result) {
        for (let i = 0; i < result.length; i++) {
            let label = result[i].substring(1, result[i].search(']'));
            let link = result[i].substring(result[i].search(/\(/) + 1, result[i].length - 1);
            str = str.replace(result[i], '<a target="_blank" style="white-space: nowrap;" rel="noreferrer" href="' + link + '">' + label + '</a>');
        }
    }
    return findCode(str);
}

export function findCode(str) {
    let result = str.match(/`([^`]+)`/g);

    if (result) {
        for (let i = 0; i < result.length; i++) {
            str = str.replace(result[i], '<code>' + result[i].substring(1, result[i].length - 1).replaceAll('<', '&lt;') + '</code>');
        }
    }
    return str;
}

