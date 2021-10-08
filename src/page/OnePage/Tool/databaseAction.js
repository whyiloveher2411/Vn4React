export function checkDatabase(ajax, data = null, callback = null) {
    ajax({
        url: 'tool/database-check',
        method: 'POST',
        data: data,
        success: (result) => {
            if (callback) {
                callback(result);
            }
        }
    });
}

export function backupDatabase(ajax, data = null, callback = null) {
    ajax({
        url: 'tool/database-backup',
        method: 'POST',
        data: data,
        success: (result) => {
            if (callback) {
                callback(result);
            }
        }
    });
}