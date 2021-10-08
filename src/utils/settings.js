import { useSelector } from "react-redux";

export const MODE = {
    DEVELOPING: 'developing',
    PRODUCTION: 'production',
};

export function useSetting(key = false) {

    const settings = useSelector(state => state.settings);

    if (key !== false) {
        if (settings[key] !== undefined) {
            return settings[key];
        }
        return null;
    }

    return settings;
}