import { Box } from '@material-ui/core';
import { AvatarCustom } from 'components';
import React from 'react';

const AvatarThumbnail = ({ product }) => <AvatarCustom variant="square" style={{ marginRight: 8 }} image={product.thumbnail} name={product.title} />;

function Main(props) {

    if (props.post[props.name + '_moredata']) {
        return (
            <Box display="flex" alignItems="center">
                <AvatarThumbnail product={props.post[props.name + '_moredata']} />
                <div>
                    <span >(ID: {props.post[props.name + '_moredata']?.id})</span> {props.post[props.name + '_moredata']?.title}
                </div>
            </Box>
        )
    }

    return null;
}

export default Main
