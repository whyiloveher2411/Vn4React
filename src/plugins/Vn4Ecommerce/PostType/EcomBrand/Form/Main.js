import { Box, CircularProgress, TextField, Typography } from '@material-ui/core';
import FieldForm from 'components/FieldForm';
import React from 'react';
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

            // <div>
            //             {
            //                 Boolean(post[name + '_detail']?.logo) &&
            //                 <img style={{ width: 150, maxHeight: 40, flexShrink: 0, objectFit: 'contain' }} variant="square" src={getImageUrl(post[name + '_detail']?.logo)} title={post[name + '_detail']?.title} />
            //             }
            //         </div>

            renderInput={(params, detail, loading) => (
                <TextField
                    {...params}
                    label={config.title}
                    variant="outlined"
                    InputProps={{
                        ...params.InputProps,
                        endAdornment: (
                            <React.Fragment>
                                {loading ? <CircularProgress color="inherit" size={20} /> : null}
                                {params.InputProps.endAdornment}
                            </React.Fragment>
                        ),
                        startAdornment: (
                            <Box display="flex" alignItems="center">
                                {
                                    Boolean(detail?.logo) &&
                                    <img style={{ marginRight: 4, maxWidth: 150, height: 24, flexShrink: 0, objectFit: 'contain' }} variant="square" src={getImageUrl(detail.logo)} title={detail?.title} />
                                }
                            </Box>
                        )
                    }}
                />
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
