export const UPDATE = 'SIDEBAR_UPDATE'
export const SHOW = 'SIDEBAR_SHOW'

export const updateSidebar = (sidebar) => (
    {
        type: UPDATE,
        payload: sidebar
    }
)

export const showSidebar = (sidebar) => (
    {
        type: SHOW,
        payload: sidebar
    }
)

