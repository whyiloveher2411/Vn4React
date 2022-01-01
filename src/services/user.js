import { ajax } from 'utils/useAjax';

const service = {

    getInfo: async () => {
        let data = await ajax({
            url: 'user/info',
        });

        return data;
    }

}

export default service;