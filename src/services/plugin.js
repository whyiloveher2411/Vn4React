import { ajax } from 'utils/useAjax';

const service = {

    get: async () => {
        let data = await ajax({
            url: 'plugin/get-all',
        });

        return data.plugins;
    }

}

export default service;