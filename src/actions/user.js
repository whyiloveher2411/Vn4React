export const LOGIN = 'USER_LOGIN'
export const LOGOUT = 'USER_LOGOUT'

export const login = (user) => (
    {
        type: LOGIN,
        payload: user
    }
)

export const logout = () => (
    {
        type: LOGOUT,
    }
)
