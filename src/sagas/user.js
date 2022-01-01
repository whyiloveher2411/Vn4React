
import { update as updatePopupRequireLogin } from "reducers/requireLogin";
import { logout, login, updateAccessToken, updateInfo } from "reducers/user";
import { call, fork, put, takeEvery } from "redux-saga/effects";
import userService from 'services/user';
import { getAccessToken } from "utils/user";

function* checkInfo() {

    const accessToken = getAccessToken();

    if (accessToken) {

        const info = yield call(userService.getInfo);

        if (info.user) {

            yield put({
                type: login().type,
                payload: { ...info.user }
            });

        } else {

            yield put({
                type: updatePopupRequireLogin().type,
                payload: { open: true, updateUser: false }
            });

            yield put({
                type: updateInfo().type,
                payload: { ...info }
            });

        }

    } else {

        yield put({
            type: logout().type,
        });

    }

}

export default function* userSaga() {
    yield fork(checkInfo);
    yield takeEvery(updateAccessToken().type, checkInfo);
}