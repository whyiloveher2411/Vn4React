export const UPDATE = 'PLUGINS_UPDATE'

export const updatePlugins = (plugins) => (
    {
        type: UPDATE,
        payload: plugins
    }
)
