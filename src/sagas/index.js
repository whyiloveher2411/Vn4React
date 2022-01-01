import { all, fork } from "redux-saga/effects";
import userSaga from './user';
import settingSaga from './setting';
import sidebarSaga from './sidebar';
import pluginSaga from './plugin';
import poupupLoginSaga from './popupLogin';

export default function* () {
    yield all([
        fork(userSaga),
        fork(settingSaga),
        fork(sidebarSaga),
        fork(pluginSaga),
        fork(poupupLoginSaga),
    ]);
}