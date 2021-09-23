import { Box } from '@material-ui/core';
import { AvatarCustom } from 'components';
import React from 'react';

function Title({ post }) {

    return (
        <Box display="flex" alignItems="center">
            <AvatarCustom variant="square" style={{ marginRight: 8 }} image={post.thumbnail} name={post.title} /> {post.title}
        </Box>
    )
}

export default Title
