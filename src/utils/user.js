import { useSelector } from "react-redux";
import { array_flip } from './helper';

// export function checkPermission(permission) {

//     // console.log((new Error()).stack);

//     if (!window.__userLogin) {
//         try {
//             window.__userLogin = JSON.parse(localStorage.getItem('user')) || null;

//             if (window.__userLogin.permission && !Array.isArray(window.__userLogin.permission)) {
//                 window.__userLogin.permissions = array_flip(window.__userLogin.permission.split(", "));
//             }

//         } catch (error) {
//             return false;
//             // window.__userLogin.permission = {};
//         }
//     }

//     if (!window.__userLogin) return false;

//     if (window.__userLogin.role === 'Super Admin') return true;

//     if (!window.__userLogin.permission) return false;

//     if (typeof permission === 'string' && window.__userLogin.permissions[permission]) {
//         return true;
//     }

//     for (let index = 0; index < permission.length; index++) {
//         if (!window.__userLogin.permissions[permission[index]]) {
//             return false;
//         }
//     }

//     return true;

// }

export function getAccessToken() {

    if (localStorage.getItem('access_token')) {
        return localStorage.getItem('access_token');
    }

    return null;
}

export function clearAccessToken() {
    localStorage.removeItem('access_token');
}

export function setAccessToken(access_token) {
    localStorage.setItem('access_token', access_token);
}


export function checkPermissionUser(user, permission) {

    if (!user) return false;

    if (user.role === 'Super Admin') return true;

    if (!user.permission) return false;

    let permissions = user.permission;

    if (permissions && !Array.isArray(permissions)) {
        permissions = array_flip(permissions.split(", "));
    }

    if (typeof permission === 'string' && permissions[permission]) {
        return true;
    }

    for (let index = 0; index < permission.length; index++) {
        if (!permissions[permission[index]]) {
            return false;
        }
    }

    return true;

}

export function usePermission() {

    const user = useSelector(state => state.user);

    let result = {};

    if (user) {

        for (let i = 0; i < arguments.length; i++) {
            if (result[arguments[i]] === undefined) {
                result[arguments[i]] = checkPermissionUser(user, arguments[i]);
            }
        }

    } else {

        for (let i = 0; i < arguments.length; i++) {
            if (result[arguments[i]] === undefined) {
                result[arguments[i]] = true;
            }
        }

    }
    return result;
}