
import { update, updateSidebarAgain } from "reducers/sidebar";
import { login, refreshAccessToken, updateAccessToken } from "reducers/user";
import { update as updatePlugins } from "reducers/plugins";
import { call, put, takeEvery } from "redux-saga/effects";
import sidebarService from 'services/sidebar';

function* fetchSidebar() {

    const sidebar = yield call(sidebarService.fetch);

    yield put({
        type: update().type,
        payload: { ...sidebar }
    });
}

export default function* sidebar() {
    yield takeEvery([login().type, refreshAccessToken().type, updatePlugins().type, updateSidebarAgain().type], fetchSidebar);
}