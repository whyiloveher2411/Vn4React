import { createSlice } from '@reduxjs/toolkit';

export const slice = createSlice({
    name: 'sidebar',
    initialState: null,
    reducers: {
        update: (state, action) => {

            if (state) {

                Object.keys(action.payload).forEach(key => {
                    if (state[key] && state[key].show) {
                        action.payload[key].show = true;
                    }
                });

            }
            return { ...action.payload };
        },
        updateSidebarAgain: () => {}
    },
});

export const { update, updateSidebarAgain } = slice.actions;

export default slice.reducer;