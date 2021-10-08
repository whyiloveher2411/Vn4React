export function minifyHTML(ajax, data, callback = null) {
    ajax({
        url: 'tool/optimize-minify-html',
        method: 'POST',
        data: data,
        success: (result) => {
            if (callback) {
                callback(result);
            }
        }
    });
}