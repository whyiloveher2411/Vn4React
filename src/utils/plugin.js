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