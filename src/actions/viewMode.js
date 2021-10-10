export const CHANGE_THEME = 'VIEWMODE_CHANGE_THEME'
export const CHANGE_COLOR_PRIMARY = 'VIEWMODE_CHANGE_COLOR_PRIMARY'
export const CHANGE_COLOR_SECONDARY = 'VIEWMODE_CHANGE_COLOR_SECONDARY'

export const changeMode = (mode) => (
    {
        type: CHANGE_THEME,
        payload: mode
    }
)

export const changeColorPrimary = (mode) => (
    {
        type: CHANGE_COLOR_PRIMARY,
        payload: mode
    }
)

export const changeColorSecondary = (mode) => (
    {
        type: CHANGE_COLOR_SECONDARY,
        payload: mode
    }
)
