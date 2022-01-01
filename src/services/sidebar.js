
import { ajax } from 'utils/useAjax';

const service = {
    fetch: async () => {
        let data = await ajax({
            url: 'sidebar/get',
        });

        return data.sidebar;
    }
}

export default service;