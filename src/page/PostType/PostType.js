import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { usePermission } from 'utils/user';
import CreateData from './components/CreateData/CreateData';
import ShowData from './components/ShowData/ShowData';

const PostType = (props) => {

    const permission = usePermission(
        props.match.params.type + '_list',
        props.match.params.type + '_edit',
        props.match.params.type + '_create',
    );

    if (props.match.params.action === 'list') {

        if (permission[props.match.params.type + '_list']) {
            return <ShowData {...props}></ShowData>;
        } else {
            return <RedirectWithMessage />
        }

    } else if (props.match.params.action === 'edit') {

        if (permission[props.match.params.type + '_edit']) {
            return <CreateData {...props}></CreateData>;
        } else {
            return <RedirectWithMessage />
        }

    } else if (props.match.params.action === 'new') {

        if (permission[props.match.params.type + '_create']) {
            return <CreateData {...props}></CreateData>;
        } else {
            return <RedirectWithMessage />
        }

    }
    return <RedirectWithMessage code={404} />
}

export default PostType
