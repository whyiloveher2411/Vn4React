const urlPrefixDefault = process.env.REACT_APP_BASE_URL + 'api/admin/';

async function ajax(params) {

    let { url, urlPrefix = null, headers = {
        'Content-Type': 'application/json',
    }, method = 'POST', data = null, loading = true } = params;

    let paramForFetch = {
        headers: headers,
        method: method,
    };

    if (data) {
        paramForFetch['body'] = JSON.stringify(data);
    }

    const respon = await fetch((urlPrefix ?? urlPrefixDefault) + url, paramForFetch)
        .then(async (response) => {
            return await response.json();
        }).catch(function (error) {
            return error;
        }).finally(() => {
            return params;
        });

    return respon;

}

export default ajax;
