export const UPDATE = 'SETTINGS_UPDATE';
export const CLEAR = 'SETTINGS_CLEAR';

export const updateSettings = (settings) => (
    {
        type: UPDATE,
        payload: settings
    }
)

export const clearSetting = () => (
    {
        type: CLEAR,
    }
)
