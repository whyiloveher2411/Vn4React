
import { createSlice } from '@reduxjs/toolkit';
import { changeViewMode, getViewMode, changeViewColorPrimary, changeViewColorSecondary } from 'utils/viewMode';

export const slice = createSlice({
    name: 'viewMode',
    initialState: getViewMode(),
    reducers: {
        changeMode: (state, action) => {
            return changeViewMode(action.payload);
        },
        changeColorPrimary: (state, action) => {
            return changeViewColorPrimary(action.payload);
        },
        changeColorSecondary: (state, action) => {
            return changeViewColorSecondary(action.payload);
        },
    },
});

export const { changeMode, changeColorPrimary, changeColorSecondary } = slice.actions;

export default slice.reducer;



// import * as viewMode from '../actions/viewMode'
// import { changeViewMode, getViewMode, changeViewColorPrimary, changeViewColorSecondary } from 'utils/viewMode';

// let valueInitial = getViewMode();

// const userReducer = (state = valueInitial, action) => {

//     switch (action.type) {
//         case viewMode.CHANGE_THEME:
//             return changeViewMode(action.payload);
//         case viewMode.CHANGE_COLOR_PRIMARY:
//             return changeViewColorPrimary(action.payload);
//         case viewMode.CHANGE_COLOR_SECONDARY:
//             return changeViewColorSecondary(action.payload);
//         default:
//             return state;
//             break;
//     }
// }

// export default userReducer;