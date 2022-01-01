import { createSlice } from '@reduxjs/toolkit';
import { clearAccessToken, setAccessToken } from 'utils/user';


export const slice = createSlice({
    name: 'user',
    initialState: {
        state: 'unknown'
    },
    reducers: {
        updateAccessToken: (state, action) => {
            setAccessToken(action.payload);
            return { ...state, accessToken: action.payload, state: 'unknown' };
        },
        refreshAccessToken: (state, action) => {
            setAccessToken(action.payload);
            return { ...state, accessToken: action.payload, state: 'identify' };
        },
        login: (state, action) => {
            return { ...action.payload, state: 'identify' };
        },
        updateInfo: (state, action) => {
            return { ...action.payload, state: 'identify' };
        },
        logout: (state) => {
            clearAccessToken();
            return { state: 'nobody' };
        }
    },
});

export const { updateAccessToken, refreshAccessToken, login, updateInfo, logout } = slice.actions;

export default slice.reducer;


