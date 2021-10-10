import React from 'react'
import FieldForm from 'components/FieldForm';
import { Box, TextField, Typography } from '@material-ui/core';
import AvatarCustom from 'components/AvatarCustom';
import { getImageUrl } from 'utils/image';

function Main({ config, post, onReview, name }) {

    return (
        <FieldForm
            compoment={'relationship_onetomany'}
            config={{
                title: config.title,
                object: config.object
            }}
            renderOption={(option) => (
                <Box display="flex" width={1} alignItems="center" gridGap={8}>
                    {
                        Boolean(option.logo) &&
                        <img style={{ width: 150, maxHeight: 40, flexShrink: 0, objectFit: 'contain' }} variant="square" src={getImageUrl(option.logo)} title={option.title} />
                    }
                    <div style={{ maxWidth: 'calc( 100% - 150px)' }}>
                        <Typography variant="h6">{option.title}</Typography>
                        <Typography variant="body2"> {option.website}</Typography>
                        <Typography noWrap variant="body2"> {option.description}</Typography>
                    </div>
                </Box>
            )}
            post={post}
            name={name}
            onReview={(value, key) => {
                onReview(value, key);
            }}
        />
    )

}

export default Main
