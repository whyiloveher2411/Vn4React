

import { createSlice } from '@reduxjs/toolkit';
import { plugins } from 'utils/plugin';

const updatePlugin = (state, action) => {
    let stateTemp = {};

    Object.keys(action.payload).forEach(key => {
        stateTemp[key] = action.payload[key];
    });

    let sortable = [];

    Object.keys(stateTemp).forEach(key => {
        sortable.push([key, stateTemp[key].priority ?? 99]);
    });

    sortable.sort(function (a, b) {
        return a[1] - b[1];
    });

    let newState = {};

    sortable.forEach(item => {
        newState[item[0]] = stateTemp[item[0]];
    });

    window.__plugins = newState;

    // localStorage.setItem("plugins", JSON.stringify(newState));
    return { ...newState };
}

export const slice = createSlice({
    name: 'plugin',
    initialState: plugins(),
    reducers: {
        update: updatePlugin,
        firstLoad: updatePlugin,
    },
});

export const { update, firstLoad } = slice.actions;

export default slice.reducer;


// import * as pluginsAction from '../actions/plugins';
// import { plugins } from 'utils/plugin';

// let pluginsInitial = plugins();

// const pluginsReducer = (state = pluginsInitial, action) => {

//     switch (action.type) {
//         case pluginsAction.UPDATE:

//             Object.keys(action.payload).forEach(key => {
//                 state[key] = action.payload[key];
//             });

//             let sortable = [];

//             Object.keys(state).forEach(key => {
//                 sortable.push([key, state[key].priority ?? 99]);
//             });

//             sortable.sort(function (a, b) {
//                 return a[1] - b[1];
//             });

//             let newState = {};

//             sortable.forEach(item => {
//                 newState[item[0]] = state[item[0]];
//             });

//             window.__plugins = newState;

//             // localStorage.setItem("plugins", JSON.stringify(newState));
//             return newState;

//             break;
//         default:
//             return state;
//             break;
//     }
// }

// export default pluginsReducer;