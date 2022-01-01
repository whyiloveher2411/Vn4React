import { configureStore } from '@reduxjs/toolkit'
import language from './language'
import pluginsAdminReducer from './plugins'
import requiredLoginReducer from './requireLogin'
import settingsReducer from './settings'
import sidebarReducer from './sidebar'
import userReducer from './user'
import viewMode from './viewMode'

// const rootReducer = combineReducers({
//     user: userReducer,
//     sidebar: sidebarReducer,
//     plugins: pluginsAdminReducer,
//     settings: settingsReducer,
//     requireLogin: requiredLoginReducer,
//     theme: viewMode,
//     language: language,
// })


export default configureStore({
    reducer: {
        user: userReducer,
        sidebar: sidebarReducer,
        plugins: pluginsAdminReducer,
        settings: settingsReducer,
        requireLogin: requiredLoginReducer,
        theme: viewMode,
        language: language,
    },
})
