export const UPDATE = 'REQUIREDLOGIN_CHANGESTATE'

export const updateRequireLogin = (state) => {
    return {
        type: UPDATE,
        payload: state
    }
}
