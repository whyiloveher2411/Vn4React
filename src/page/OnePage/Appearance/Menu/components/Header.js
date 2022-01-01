import { Box, IconButton, Tooltip, Typography } from '@material-ui/core';
import ArrowBackOutlined from '@material-ui/icons/ArrowBackOutlined';
import React from 'react';
import { useHistory } from 'react-router-dom';
import { __ } from 'utils/i18n';

function Header({ back = null }) {
    const history = useHistory();

    return (
        <>
            <Typography component="h2" gutterBottom variant="overline">
                {__('Appearance')}
            </Typography>
            <Box display="flex" alignItems="center" gridGap={8}>
                {
                    back !== null &&
                    <Tooltip onClick={() => { history.push(back) }} title={__('Go Back')} aria-label="go-back">
                        <IconButton color="default" aria-label={__('Go Back')} component="span">
                            <ArrowBackOutlined />
                        </IconButton>
                    </Tooltip>
                }

                <Typography component="h1" variant="h3">
                    {__('Menu')}
                </Typography>
            </Box>
        </>
    )
}

export default Header
