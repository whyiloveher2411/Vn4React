
import { update as updatePopupRequireLogin } from "reducers/requireLogin";
import { logout, refreshAccessToken } from "reducers/user";
import { put, takeEvery } from "redux-saga/effects";

function* checkInfo() {

    yield put({
        type: updatePopupRequireLogin().type,
        payload: { open: false, updateUser: false }
    });
}

export default function* popupLoginSaga() {
    yield takeEvery([logout().type, refreshAccessToken().type], checkInfo);
}