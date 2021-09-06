import * as requiredLogin from '../actions/requiredLogin'

const requiredLoginReducer = (state = { open: false, updateUser: false }, action) => {

    switch (action.type) {
        case requiredLogin.UPDATE:
            return action.payload;
            break;
        default:
            return state;
            break;
    }
}

export default requiredLoginReducer;