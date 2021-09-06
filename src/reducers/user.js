import * as user from '../actions/user'

let userInitial = null;
try {
    userInitial = JSON.parse(localStorage.getItem('user')) || null;
} catch (error) {
}

const userReducer = (state = userInitial, action) => {

    switch (action.type) {
        case user.LOGIN:
            // console.log(action);
            localStorage.setItem("user", JSON.stringify(action.payload));
            return action.payload;
            break;
        case user.LOGOUT:
            localStorage.removeItem('user');
            localStorage.removeItem('access_token');
            return null;
            break;
        default:
            return state;
            break;
    }
}

export default userReducer;