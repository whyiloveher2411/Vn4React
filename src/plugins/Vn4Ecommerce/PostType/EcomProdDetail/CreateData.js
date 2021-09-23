import React from 'react'
import { useHistory } from 'react-router-dom';

function CreateDataEcomproddetail() {

    const history = useHistory();

    React.useEffect(() => {
        history.push('/post-type/ecom_prod/new');
    }, []);

    return null;
}

export default CreateDataEcomproddetail
