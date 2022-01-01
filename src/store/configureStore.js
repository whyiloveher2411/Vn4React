import rootReducer from 'reducers';
import { configureStore, getDefaultMiddleware } from '@reduxjs/toolkit';
import { applyMiddleware, compose, createStore } from 'redux';
import createSagaMiddleware from 'redux-saga';
import rootSaga from 'sagas';

import language from 'reducers/language'
import pluginsAdminReducer from 'reducers/plugins'
import requiredLoginReducer from 'reducers/requireLogin'
import settingsReducer from 'reducers/settings'
import sidebarReducer from 'reducers/sidebar'
import userReducer from 'reducers/user'
import viewMode from 'reducers/viewMode'

const sagaMiddleware = createSagaMiddleware();

const composeEnhancer = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

const store = configureStore({
    reducer: {
        user: userReducer,
        sidebar: sidebarReducer,
        plugins: pluginsAdminReducer,
        settings: settingsReducer,
        requireLogin: requiredLoginReducer,
        theme: viewMode,
        language: language,
    },
    middleware: (getDefaultMiddleware) => getDefaultMiddleware({
        serializableCheck: false
    }).concat(sagaMiddleware),
    devTools: true
});

// const store = createStore(rootReducer,
//     composeEnhancer(applyMiddleware(sagaMiddleware))
// );

// initialData.forEach((initFunc) => {
//     initFunc(store);
// });

sagaMiddleware.run(rootSaga);

export default store;