
import { firstLoad } from "reducers/plugins";
import { call, fork, put, takeEvery } from "redux-saga/effects";
import pluginService from 'services/plugin';

function* getPlugins() {

    const plugins = yield call(pluginService.get);

    yield put({
        type: firstLoad().type,
        payload: plugins
    });

}

export default function* pluginSaga() {
    yield fork(getPlugins);
}