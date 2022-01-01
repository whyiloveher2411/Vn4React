import Box from '@material-ui/core/Box';
import { AvatarCustom } from 'components';
import React from 'react';

const AvatarThumbnail = ({ product }) => <AvatarCustom variant="square" image={product.thumbnail} name={product.title} />;

function Main(props) {

    if (props.post[props.name + '_moredata']) {
        return (
            <Box display="flex" alignItems="center" gridGap={8}>
                <AvatarThumbnail product={props.post[props.name + '_moredata']} />
                <span style={{ opacity: .6 }} >#{props.post[props.name + '_moredata']?.id}: </span>
                {props.post[props.name + '_moredata']?.title}
            </Box>
        )
    }

    return null;
}

export default Main
