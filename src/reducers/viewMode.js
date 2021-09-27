import * as viewMode from '../actions/viewMode'

const valueFace = { light: true, dark: true };

let valueInitial = localStorage.getItem("view_mode");

if (!valueFace[valueInitial]) valueInitial = 'light';

const userReducer = (state = valueInitial, action) => {

    switch (action.type) {
        case viewMode.TOOGLE:
            if (state.type === 'light') {
                localStorage.setItem("view_mode", 'dark');
                const theme = require('./../theme/dark').default;
                theme.type = 'dark';
                return theme;
            } else {
                localStorage.setItem("view_mode", 'light');
                const theme = require('./../theme/light').default;
                theme.type = 'light';
                return theme;
            }
            break;
        default:
            if (state === 'dark' || state.type === 'dark') {
                const theme = require('./../theme/dark').default;
                theme.type = 'dark';
                return theme;
            } else {
                const theme = require('./../theme/light').default;
                theme.type = 'light';
                return theme;
            }
            break;
    }
}

export default userReducer;