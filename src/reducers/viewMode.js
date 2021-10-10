import * as viewMode from '../actions/viewMode'
import { changeViewMode, getViewMode, changeViewColorPrimary, changeViewColorSecondary } from 'utils/viewMode';

let valueInitial = getViewMode();

const userReducer = (state = valueInitial, action) => {

    switch (action.type) {
        case viewMode.CHANGE_THEME:
            return changeViewMode(action.payload);
        case viewMode.CHANGE_COLOR_PRIMARY:
            return changeViewColorPrimary(action.payload);
        case viewMode.CHANGE_COLOR_SECONDARY:
            return changeViewColorSecondary(action.payload);
        default:
            return state;
            break;
    }
}

export default userReducer;