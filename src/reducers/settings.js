
import { createSlice } from '@reduxjs/toolkit';

export const slice = createSlice({
    name: 'setting',
    initialState: {
        _loaded: false,
    },
    reducers: {
        update: (state, action) => {

            let newState = { ...state, _loaded: true, ...action.payload };

            // Object.keys(action.payload).forEach(key => {
            //     newState[key] = action.payload[key];
            // });

            // sessionStorage.setItem("settings", JSON.stringify(newState));

            return newState;
        },
    },
});

export const { update } = slice.actions;

export default slice.reducer;