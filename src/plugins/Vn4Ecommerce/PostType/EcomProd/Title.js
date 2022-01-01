import { Box } from '@material-ui/core';
import { AvatarCustom } from 'components';
import React from 'react';

function Title({ post }) {

    return (
        <Box display="flex" alignItems="center" gridGap={8}>
            <AvatarCustom variant="square" image={post.thumbnail} name={post.title} />
            <span style={{ opacity: .6 }} >#{post.id}:</span>
            {post.title}
        </Box>
    )
}

export default Title
