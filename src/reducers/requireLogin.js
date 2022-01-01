import { createSlice } from '@reduxjs/toolkit';

export const slice = createSlice({
    name: 'requiredLogin',
    initialState: { open: false, updateUser: false },
    reducers: {
        update: (state, action) => {
            return { ...action.payload };
        },
    },
});

export const { update } = slice.actions;

export default slice.reducer;