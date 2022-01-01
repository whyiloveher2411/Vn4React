
import { update as updatePlugins } from "reducers/plugins";
import { update } from 'reducers/settings';
import { login, refreshAccessToken } from "reducers/user";
import { call, put, takeEvery } from "redux-saga/effects";
import settingService from 'services/setting';

function* getSettings() {

    const settings = yield call(settingService.getAll);

    yield put({
        type: update().type,
        payload: { ...settings }
    });

}

export default function* settingSaga() {
    yield takeEvery([login().type, refreshAccessToken().type, updatePlugins().type], getSettings);
}