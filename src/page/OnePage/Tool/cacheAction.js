export function clearCache(ajax, key, callback = null) {
    ajax({
        url: 'tool/cache',
        method: 'POST',
        isGetData: true,
        data: {
            action: 'clear',
            key: key
        },
        success: (result) => {
            if (callback) {
                callback(result);
            }
        }
    });
}