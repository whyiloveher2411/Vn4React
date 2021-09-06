import { combineReducers } from 'redux'

import userReducer from './user'
import sidebarReducer from './sidebar'
import pluginsAdminReducer from './plugins'
import settingsReducer from './settings'
import requiredLoginReducer from './requireLogin'


const rootReducer = combineReducers({
    user: userReducer,
    sidebar: sidebarReducer,
    plugins: pluginsAdminReducer,
    settings: settingsReducer,
    requireLogin: requiredLoginReducer,
})

export default rootReducer
