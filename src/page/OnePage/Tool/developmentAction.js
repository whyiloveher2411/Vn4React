export function deployAsset(ajax, data = null, callback = null) {
    ajax({
        url: 'tool/development-asset',
        method: 'POST',
        data: data,
        success: (result) => {
            if (callback) {
                callback(result);
            }
        }
    });
}

export function refreshView(ajax, data = null, callback = null) {
    ajax({
        url: 'tool/development-refresh-view',
        method: 'POST',
        data: data,
        success: (result) => {
            if (callback) {
                callback(result);
            }
        }
    });
}

export function compileCodeDI(ajax, data = null, callback = null) {
    ajax({
        url: 'tool/compile-di',
        method: 'POST',
        data: data,
        success: (result) => {
            if (callback) {
                callback(result);
            }
        }
    });
}

export function checkLanguage(ajax, data = null, callback = null) {
    ajax({
        url: 'tool/check-language',
        method: 'POST',
        data: data,
        success: (result) => {
            if (callback) {
                callback(result);
            }
        }
    });
}

