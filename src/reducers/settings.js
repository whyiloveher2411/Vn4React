import * as settings from '../actions/settings'

let settingsInitial = {};

try {
    settingsInitial = JSON.parse(sessionStorage.getItem('settings'));
    if (!settingsInitial) settingsInitial = {};
} catch (error) {
    settingsInitial = {};
}

let uri = window.location.pathname.substring(1);

if (uri !== 'install' && !Object.keys(settingsInitial).length) {

    const urlPrefix = process.env.REACT_APP_BASE_URL + 'api/admin/';

    fetch(urlPrefix + 'settings/all', {
        method: 'POST',
    }).then(async (response) => {

        if (!response.ok) throw Error(response.statusText);
        let result = await response.json();

        if (result.message) {
            alert(result.message.content);
        }
        sessionStorage.setItem('settings', JSON.stringify(result));

    }).catch(function () {
        // alert(error.toString());
    });

}

const settingsReducer = (state = settingsInitial, action) => {

    switch (action.type) {

        case settings.UPDATE:

            let newState = {};

            try {
                newState = JSON.parse(sessionStorage.getItem('settings'));
                if (!newState) newState = {};
            } catch (error) {
                newState = {};
            }

            Object.keys(action.payload).forEach(key => {
                newState[key] = action.payload[key];
            });
            
            sessionStorage.setItem("settings", JSON.stringify(newState));
            return newState;
        case settings.CLEAR:

            sessionStorage.setItem("settings", '{}');
            return {};

        default:
            return state;
            break;
    }
}

export default settingsReducer;