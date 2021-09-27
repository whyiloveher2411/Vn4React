import * as settings from '../actions/settings'

let settingsInitial = {};

try {
    settingsInitial = JSON.parse(sessionStorage.getItem('settings')) || {};
} catch (error) {

}

let uri = window.location.pathname.substring(1);

if ( uri !== 'install' && !Object.keys(settingsInitial).length) {

    const urlPrefix = process.env.REACT_APP_BASE_URL + 'api/admin/';

    fetch(urlPrefix + 'settings/all', {
        method: 'POST',
    }).then(async (response) => {

        if (!response.ok) throw Error(response.statusText);
        let result = await response.json();

        if (result.message) {
            alert(result.message.content);
        }

        sessionStorage.setItem("settings", JSON.stringify(result));

    }).catch(function (error) {
        // alert(error.toString());
    });

}

const settingsReducer = (state = settingsInitial, action) => {

    switch (action.type) {

        case settings.UPDATE:

            Object.keys(action.payload).forEach(key => {
                state[key] = action.payload[key];
            });

            sessionStorage.setItem("settings", JSON.stringify(state));
            return state;

        case settings.CLEAR:

            sessionStorage.setItem("settings", '{}');
            return {};

        default:
            return state;
            break;
    }
}

export default settingsReducer;