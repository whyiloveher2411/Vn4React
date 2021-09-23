import React from 'react'
import { useHistory } from 'react-router-dom';

function ShowData() {

    const history = useHistory();

    React.useEffect(() => {
        history.push('/post-type/ecom_prod/list');
    }, []);

    return null;
}

export default ShowData
