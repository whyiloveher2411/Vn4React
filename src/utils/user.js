export function checkPermission(permission) {

    // console.log((new Error()).stack);

    if (!window.__userLogin) {
        try {
            window.__userLogin = JSON.parse(localStorage.getItem('user')) || null;
            if (window.__userLogin.permission) {
                window.__userLogin.permissions = array_flip(window.__userLogin.permission.split(", "));
            }
        } catch (error) {
            return false;
        }
    }

    if (!window.__userLogin) return false;

    if (window.__userLogin.role === 'Super Admin') return true;

    if( !window.__userLogin.permission ) return false;

    if (typeof permission === 'string' && window.__userLogin.permissions[permission]) {
        return true;
    }

    for (let index = 0; index < permission.length; index++) {
        if (!window.__userLogin.permissions[permission[index]]) {
            return false;
        }
    }

    return true;

}

function array_flip(trans) {

    if (!trans) return {};

    var key, tmp_ar = {};

    for (key in trans) {
        if (trans.hasOwnProperty(key)) {
            tmp_ar[trans[key]] = key;
        }
    }

    return tmp_ar;
}
