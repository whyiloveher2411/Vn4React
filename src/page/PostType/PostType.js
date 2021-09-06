import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { checkPermission } from 'utils/user';
import CreateData from './components/CreateData/CreateData';
import ShowData from './components/ShowData/ShowData';

const PostType = (props) => {

    if (props.match.params.action === 'list') {

        if (checkPermission(props.match.params.type + '_list')) {
            return <ShowData {...props}></ShowData>;
        } else {
            return <RedirectWithMessage />
        }

    } else if (props.match.params.action === 'edit') {

        if (checkPermission(props.match.params.type + '_edit')) {
            return <CreateData {...props}></CreateData>;
        } else {
            return <RedirectWithMessage />
        }

    } else if (props.match.params.action === 'new') {

        if (checkPermission(props.match.params.type + '_create')) {
            return <CreateData {...props}></CreateData>;
        } else {
            return <RedirectWithMessage />
        }

    }
    return <RedirectWithMessage code={404} />
}

export default PostType
