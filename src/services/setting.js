import { ajax } from 'utils/useAjax';

const settingService = {

    getAll: async () => {
        let data = await ajax({
            url: 'settings/all',
        });

        return data;
    },
    getLoginConfig: async () => {
        let data = await ajax({
            url: 'login/settings',
        });
        return data;
    }

}

export default settingService;