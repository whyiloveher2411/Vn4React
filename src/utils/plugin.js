import { useSelector } from "react-redux";

export function usePlugin(name) {
    const plugins = useSelector(state => state.plugins);
    if (name && plugins[name]) {
        return plugins[name];
    }
    return null;
}



export function usePluginMeta(name) {

    const plugin = usePlugin(name);

    if (plugin) {

        try {

            let meta = {};

            if (plugin.meta) {
                meta = JSON.parse(plugin.meta);
                return meta;
            }

        } catch (error) {


        }
    }

    return {};
}

export function plugins() {

    if (window.__plugins) return window.__plugins;

    return {};

    let pluginsInitial = {};
    try {
        pluginsInitial = JSON.parse(localStorage.getItem('plugins')) || {};
    } catch (error) {
        pluginsInitial = {};
    }

    window.__plugins = pluginsInitial;

    return pluginsInitial;
}
